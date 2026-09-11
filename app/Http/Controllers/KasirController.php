<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    /**
     * Tampilkan halaman utama Kasir POS Cafe.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::with('category')->get();

        return view('kasir.index', compact('categories', 'products'));
    }

    /**
     * Proses transaksi kasir.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_type' => 'required|string',
            'customer_name' => 'nullable|string|max:255',
            'table_number' => 'nullable|string|max:50',
            'payment_method' => 'required|string',
            'cash_given' => 'nullable|numeric|min:0',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric|min:0',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $subtotal = 0;
            // Validate stock first
            foreach ($request->cart as $item) {
                $product = Product::lockForUpdate()->find($item['id']);
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi. (Sisa: {$product->stock})");
                }
                $subtotal += $item['price'] * $item['qty'];
            }

            $taxRate = 0.10;
            $tax = $subtotal * $taxRate;
            $grandTotal = $subtotal + $tax;

            // Mapping payment method
            $paymentMethodCode = 0; // default cash
            if ($request->payment_method === 'QRIS') {
                $paymentMethodCode = 1;
            } elseif ($request->payment_method === 'Debit / EDC') {
                $paymentMethodCode = 2; // custom, if we want
            }

            // Create Order
            $order = \App\Models\Order::create([
                'user_id' => auth()->id() ?? 1, // fallback to 1 if no user (should not happen with middleware)
                'order_number' => 'TRX-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'order_type' => $request->order_type,
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'total-price' => $grandTotal,
                'payment_method' => $paymentMethodCode,
                'payment_status' => 1, // paid
                'snap_token' => null,
            ]);

            // Insert Order Details and Deduct Stock
            foreach ($request->cart as $item) {
                $product = Product::find($item['id']);
                
                \App\Models\OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                $product->decrement('stock', $item['qty']);
            }

            \Illuminate\Support\Facades\DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil.',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}

