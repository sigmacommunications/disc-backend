<?php

namespace App\Http\Controllers;

use App\Models\MerchItem;
use App\Models\Wishlist;
use Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        // Retrieve all wishlist items
        $wishlistItems = Wishlist::with('merchItem.user', 'merchItem.images')
            ->where('user_id', Auth::id())
            ->get();
        $cartItems = $this->getUserItems('cartItems');

        return view('wishlist.index', compact('wishlistItems', 'cartItems'));
    }
    private function getUserItems(string $itemType)
    {
        return Auth::check() ? Auth::user()->$itemType()->pluck('merch_item_id')->toArray() : [];
    }
    public function addToWishlist(MerchItem $merchItem)
    {
        if (!Auth::check()) {
            return $this->redirectToLoginWithMessage('You need to login to add to wishlist.');
        }

        // Add or remove item from wishlist
        return $this->toggleItemInWishlist($merchItem);
    }
    // Helper method to handle redirect when not logged in
    private function redirectToLoginWithMessage(string $message)
    {
        return redirect()->route('login')->with('error', $message);
    }

    // Helper method to add or remove item from wishlist
    private function toggleItemInWishlist(MerchItem $merchItem)
    {
        $existingWishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('merch_item_id', $merchItem->id)
            ->first();

        if ($existingWishlistItem) {
            $existingWishlistItem->delete();
            return redirect()->route('marketplace.index')->with('success', 'Item removed from wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'merch_item_id' => $merchItem->id,
        ]);

        return redirect()->route('marketplace.index')->with('success', 'Item added to wishlist.');
    }
}
