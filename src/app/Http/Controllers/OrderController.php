<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use AuthorizesRequests;

    /**
     * Create Order with Stock Deduction
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        $order = DB::transaction(function () use ($data) {

            $totalAmount = 0;

            // Create order first
            $order = Order::create([
                'customer_id'  => $data['customer_id'],
                'status'       => 'pending',
                'total_amount' => 0,
            ]);

            foreach ($data['items'] as $item) {

                /** @var Product $product */
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                // ❌ Negative inventory prevention
                if ($product->stock < $item['quantity']) {
                    throw new \Exception(
                        "Insufficient stock for product: {$product->name}"
                    );
                }

                // Deduct stock
                $product->decrement('stock', $item['quantity']);

                // Calculate line total
                $lineTotal = $product->price * $item['quantity'];
                $totalAmount += $lineTotal;

                // Create order item
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id'=> $product->id,
                    'quantity'  => $item['quantity'],
                    'price'     => $product->price,
                ]);
            }

            // Update total
            $order->update([
                'total_amount' => $totalAmount
            ]);

            return $order;
        });

        return response()->json([
            'message' => 'Order created successfully',
            'data'    => new OrderResource(
                $order->load(['items', 'customer'])
            )
        ], 201);
    }

    /**
     * Cancel Order & Restore Stock
     */
    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        if ($order->status === 'cancelled') {
            return response()->json([
                'message' => 'Order already cancelled'
            ], 400);
        }

        DB::transaction(function () use ($order) {

            foreach ($order->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);

                // Restore stock
                $product->increment('stock', $item->quantity);
            }

            $order->update([
                'status' => 'cancelled'
            ]);
        });

        return response()->json([
            'message' => 'Order cancelled and stock restored'
        ]);
    }
}
