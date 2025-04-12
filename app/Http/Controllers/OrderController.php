<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OrderController extends Controller
{
    // List user's orders
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $orders = $user->orders()->get();
            return response()->json($orders);
        }

        return response()->json(['error' => 'Vous devez être connecté pour voir vos commandes.'], 401);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'price' => 'nullable|numeric',
            'platform' => 'required|string|max:50',
            'quantity' => 'nullable|integer',
            'total' => 'nullable|numeric',
            'product_id' => 'nullable|string|max:255',
            'gencode' => 'nullable|integer',
            'name' => 'nullable|string|max:50',
            'adress' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
            'tracking_number' => 'nullable|string|max:255',
            'tracking_url' => 'nullable|string|max:255',
        ]);

        if (Auth::check()) {
            $user = Auth::user();
            $order = $user->orders()->create($request->all());
            return response()->json($order, 201);
        }
    }

    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', OrderStatus::values())],
        ]);

        $order = Order::findOrFail($orderId);
        $order->status = OrderStatus::from($request->status);
        $order->save();

        return response()->json(['message' => 'Order status updated successfully']);
    }
}
