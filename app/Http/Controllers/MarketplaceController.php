<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Cart;
use App\Models\MerchItem;
use App\Models\Wishlist;
use Auth;
use Http;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 8; // number of items per "page"
        $query = $this->getMerchItemsQuery($request);
        $query = $query->orderBy('created_at', 'desc');
        // use paginate on the builder
        $merchItems = $query->paginate($perPage)->withQueryString();

        // fetch user-specific IDs
        $wishlist = $this->getUserItems('wishlist');
        $cartItems = $this->getUserItems('cartItems');

        $trendingItems = MerchItem::with('user', 'images')
            ->where('trending', true)
            ->get();
        // $printifyProducts = $this->fetchPrintifyProducts();
        // $printifyProducts = [];
        // dd($printifyProducts);

        if ($request->ajax()) {
            $html = view('marketplace.partials.items', compact('merchItems', 'wishlist', 'cartItems'))->render();

            return response()->json([
                'items' => $html,
                'next_page_url' => $merchItems->nextPageUrl(),
            ]);
        }

        // first full page load
        $artists = Artist::with('user')->get();

        return view('marketplace.index', compact('merchItems', 'wishlist', 'cartItems', 'artists', 'trendingItems'));
    }
    private function fetchPrintifyProducts()
    {
        $shopId = config('services.printify.shop_id');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.printify.api_token'),
        ])->get("https://api.printify.com/v1/shops/{$shopId}/products.json");

        return $response->json()['data'] ?? [];
    }
    private function getUserItems(string $itemType): array
    {
        return Auth::check()
            ? Auth::user()->{$itemType}()->pluck('merch_item_id')->toArray()
            : [];
    }

    private function getMerchItemsQuery(Request $request)
    {
        return MerchItem::with('user', 'images')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('artists') && is_array($request->artists), function ($query) use ($request) {
                $query->whereHas('user.artist', function ($artistQuery) use ($request) {
                    $artistQuery->whereIn('artists.id', $request->artists);
                });
            });
    }
    // public function show(MerchItem $merchItem)
    // {
    //     // Load the item with its relationships
    //     $merchItem->load(['images', 'user']);

    //     // Increment view count or track popularity (optional)
    //     // $merchItem->increment('views');

    //     // Get related items by the same artist or similar category
    //     $relatedItems = MerchItem::where('id', '!=', $merchItem->id)
    //         ->where(function ($query) use ($merchItem) {
    //             $query->where('user_id', $merchItem->artist_id)
    //                 ->orWhere(function ($query) use ($merchItem) {
    //                     // You can add more similarity logic here
    //                     $query->where('id', '!=', $merchItem->id);
    //                 });
    //         })
    //         ->with(['images'])
    //         ->inRandomOrder()
    //         ->limit(4)
    //         ->get();

    //     return view('marketplace.show', compact('merchItem', 'relatedItems'));
    // }
    public function show($id)
    {

        $merchItem = MerchItem::with(['images', 'user'])
            ->find($id);

        if ($merchItem) {
            // related items as before
            $relatedItems = MerchItem::where('id', '!=', $merchItem->id)
                ->where(function ($q) use ($merchItem) {
                    $q->where('user_id', $merchItem->user_id)
                        ->orWhere('id', '!=', $merchItem->id);
                })
                ->with('images')
                ->inRandomOrder()
                ->limit(4)
                ->get();

            return view('marketplace.show', compact(
                'merchItem',
                'relatedItems',
            ));
        }



        $products = $this->fetchPrintifyProducts();

        // 2.3 Find the one matching your {id}
        $product = collect($products)->firstWhere('id', $id);
        if (!$product) {
            abort(404, 'Printify product not found in this shop.');
        }
        // return $product;

        return view('marketplace.printify_show', compact(
            'product',
        ));
    }

    // … your getUserItems() helper methods …

}
