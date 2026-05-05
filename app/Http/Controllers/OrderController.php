<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    // Displays the orders list (with SSR DataTables)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('user')->orderBy('created_at', 'desc');
            return DataTables::of($orders)
                ->addColumn('action', fn($order) => '<a href="' . route("admin_orders.show", $order->id) . '" class="btn btn-sm btn-primary">View</a>')
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('Y-m-d H:i');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.orders.index');
    }

    // Displays the details for a specific order
    public function show($id)
    {
        $order = Order::with('orderItems.merchItem', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
