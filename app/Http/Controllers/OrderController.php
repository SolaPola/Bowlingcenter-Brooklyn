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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'orderNumber' => 'required|string|max:255',
            'orderDate' => 'required|date',
            'packageType' => 'required|string|in:Basic,Premium,VIP',
        ]);
        
        Order::create($validated);
        
        return redirect()->route('order.index')->with('success', 'Bestelling succesvol toegevoegd');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validated = $request->validate([
            'orderNumber' => 'required|string|max:255',
            'orderDate' => 'required|date',
            'packageType' => 'required|string|in:Basic,Premium,VIP',
        ]);
        
        $order->update($validated);
        
        return redirect()->route('order.index')->with('success', 'Bestelling succesvol bijgewerkt');
    }

    public function destroy($id)
    {
        $order = order::findOrFail($id);
        $order->delete();

        return redirect()->route('order.index')->with('success', 'The order is successfully deleted');
    }
}
