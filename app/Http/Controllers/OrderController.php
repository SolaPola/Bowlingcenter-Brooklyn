<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(10); // Fetch 10 orders per page
        return view('order.index', compact('orders')); // Pass the paginated orders to the view
    }

    public function create()
    {
        return view('order.create');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('order.edit', compact('order'));
    }

    public function destroy($id)
    {
        $order = order::findOrFail($id);
        $order->delete();

        return redirect()->route('order.index')->with('success', 'The order is successfully deleted');
    }
}
