<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Cart;
use App\Models\MerchItem;
use App\Models\MerchItemImage;
use App\Models\Wishlist;
use App\Services\PrintifyService;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MerchItemController extends Controller
{
    public function create()
    {
        $artists = Artist::all();
        return view('merch.create', compact('artists'));
    }
    public function destroy(MerchItem $merchItem)
    {
        // Delete all associated images
        foreach ($merchItem->images as $image) {
            \Storage::delete("public/{$image->image_path}");
            $image->delete();
        }

        // Delete the merch item
        $merchItem->delete();

        return redirect()->back()->with('success', 'Merch item rejected and deleted successfully.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'images' => 'required|array',
            'images.*' => 'image',
        ]);

        // Create the merch item
        $merchItem = MerchItem::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // Store multiple images
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('images/merch', 'public');
            MerchItemImage::create([
                'merch_item_id' => $merchItem->id,
                'image_path' => $imagePath,
            ]);
        }

        return redirect()->route('artist.merch.index')->with('success', 'Merch item created successfully.');
    }

    public function index()
    {
        $merchItems = MerchItem::with('user', 'images')->where('user_id', Auth::id())->get();
        return view('merch.index', compact('merchItems'));
    }

    public function getApprovedData(Request $req)
    {
        $query = MerchItem::with('user')->where('approved', true)->get();
        return DataTables::of($query)
            ->addColumn('artist', fn($i) => $i->user->name)
            ->addColumn('price', fn($i) => '$' . number_format($i->price, 2))
            ->addColumn(
                'action',
                fn($i) =>
                '<a href="' . route('admin.merch.edit', $i->id) . '"
                   class="btn btn-warning btn-sm">Edit</a>'
            )
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getPendingData(Request $request)
    {
        $query = MerchItem::with('user')
            ->where('approved', false);

        return DataTables::of($query)
            ->addColumn('artist', fn($item) => $item->user->name)
            ->addColumn('price', fn($item) => '$' . number_format($item->price, 2))
            ->addColumn('action', function ($item) {
                $reject = route('admin.merch.reject', $item->id);
                $approve = route('admin.merch.approve', $item->id);
                $edit = route('admin.merch.edit', $item->id);

                return "
                    <form action=\"{$reject}\"  method=\"POST\" style=\"display:inline\">
                      " . csrf_field() . method_field('DELETE') . "
                      <button class=\"btn btn-danger btn-sm\"
                              onclick=\"return confirm('Reject & delete?')\">
                        Reject
                      </button>
                    </form>
                    <form action=\"{$approve}\" method=\"POST\" style=\"display:inline\">
                      " . csrf_field() . "
                      <button class=\"btn btn-success btn-sm\"
                              onclick=\"return confirm('Approve this item?')\">
                        Approve
                      </button>
                    </form>
                    <a href=\"{$edit}\" class=\"btn btn-warning btn-sm\">Edit</a>
                ";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function markTrending(Request $req)
    {
        MerchItem::whereIn('id', $req->ids)->update(['trending' => true]);
        return response()->json(['message' => 'Selected items marked as trending.']);
    }

    public function trendingIndex()
    {
        return view('admin.merch.trending');
    }

    public function getTrendingData(Request $req)
    {
        $query = MerchItem::with('user')->where('trending', true);

        return DataTables::of($query)
            ->addColumn('artist', fn($i) => $i->user->name)
            ->addColumn('price', fn($i) => '$' . number_format($i->price, 2))
            ->make(true);
    }

    public function removeTrending(Request $req)
    {
        MerchItem::whereIn('id', $req->ids)->update(['trending' => false]);
        return response()->json(['message' => 'Selected items removed from trending.']);
    }


    public function approve(MerchItem $merchItem)
    {
        $merchItem->update(['approved' => true]);
        return redirect()->route('artist-merch.index')->with('success', 'Merch item approved successfully.');
    }
    public function edit(MerchItem $merchItem)
    {
        return view('admin.artist_merch.edit', compact('merchItem'));
    }
    public function artistedit(MerchItem $merchItem)
    {
        // dd($merchItem);
        return view('merch.create', compact('merchItem'));
    }

    public function update(Request $request, MerchItem $merchItem)
    {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('artist-merch.index')->with('error', 'Merch is already approved.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image',
        ]);

        // Update the basic information of the merch item
        $merchItem->update($request->only('description', 'price', 'name'));

        // Add new images if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images/merch', 'public');
                MerchItemImage::create([
                    'merch_item_id' => $merchItem->id,
                    'image_path' => $imagePath,
                ]);
            }
        }
        if (Auth::user()->hasRole('artist')) {
            $merchItem->update(['approved' => false]);
            return redirect()->route('artist.merch.index')->with('success', 'Merch item updated successfully.');
        }
        return redirect()->route('artist-merch.index')->with('success', 'Merch item updated successfully.');
    }

    public function adminIndex()
    {
        $merchItems = MerchItem::with('user', 'images')->where('approved', true)->get();
        return view('admin.merch.index', compact('merchItems'));
    }

    public function admincreate()
    {
        return view('admin.merch.create');
    }

    public function getPrintifyProducts()
    {
        $printify = new PrintifyService();
        $printifyProducts = $printify->getProducts();

        return response()->json($printifyProducts['data']);
    }
    public function syncPrintifyProducts()
    {
        $printify = new PrintifyService();
        $products = $printify->getProducts()['data'] ?? [];

        foreach ($products as $product) {
            // Skip if already in DB
            if (MerchItem::where('printify_product_id', $product['id'])->exists()) {
                continue;
            }

            // Determine minimum price among variants
            $minPrice = collect($product['variants'])
                ->pluck('price')
                ->map(fn($p) => (float) $p)
                ->min();
            // dd($minPrice / 100, $product);
            // Create the merch item
            $merchItem = MerchItem::create([
                'user_id' => Auth::id(),
                'name' => $product['title'],
                'description' => $product['description'],
                'printify_product_id' => $product['id'],
                'price' => $minPrice / 100,
                'approved' => true,         // or true if you want to auto-approve
            ]);

            // Attach the first image (if any)
            if (!empty($product['images'])) {
                MerchItemImage::create([
                    'merch_item_id' => $merchItem->id,
                    'image_path' => $product['images'][0]['src'],
                ]);
            }
        }
        return redirect()->route('admin.merch.index')->with('success', 'Printify products synced successfully.');

    }
    public function adminstore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'printify_product_id' => 'nullable|string|unique:merch_items,printify_product_id',
            'price' => 'required|numeric|min:0|max:999999.99',
            'images' => 'required|array',
            'images.*' => 'image',
        ]);

        $approved = Auth::user()->hasRole('admin') ? true : false;

        // Create the merch item
        $merchItem = MerchItem::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'printify_product_id' => $request->printify_product_id ?? null,
            'price' => $request->price,
            'approved' => $approved,
        ]);

        // Store multiple images
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('images/merch', 'public');
            MerchItemImage::create([
                'merch_item_id' => $merchItem->id,
                'image_path' => $imagePath,
            ]);
        }

        return redirect()->route('admin.merch.index')->with('success', 'Merch item created successfully.');
    }

    public function adminedit(MerchItem $merchItem)
    {
        return view('admin.merch.create', compact('merchItem'));
    }

    public function adminupdate(Request $request, MerchItem $merchItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'images' => 'nullable|array',
            'printify_product_id' => 'nullable|string|unique:merch_items,printify_product_id' . $merchItem->id,
            'images.*' => 'nullable|image',
        ]);

        // Update the basic information of the merch item
        $merchItem->update($request->only('description', 'price', 'name', 'printify_product_id'));

        // Add new images if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images/merch', 'public');
                MerchItemImage::create([
                    'merch_item_id' => $merchItem->id,
                    'image_path' => $imagePath,
                ]);
            }
        }
        return redirect()->route('admin.merch.index')->with('success', 'Merch item updated successfully.');
    }

    public function admindestroy(MerchItem $merchItem)
    {
        // Delete all associated images
        foreach ($merchItem->images as $image) {
            \Storage::delete("public/{$image->image_path}");
            $image->delete();
        }

        // Delete the merch item
        $merchItem->delete();

        return redirect()->back()->with('success', 'Merch item rejected and deleted successfully.');
    }
}
