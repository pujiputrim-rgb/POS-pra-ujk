<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class PimpinanController extends Controller
{
    /**
     * Tampilkan halaman dashboard Pimpinan
     */
    public function dashboard()
    {
        return view('pimpinan.dashboard');
    }

    /**
     * Tampilkan data stok barang (Read-Only)
     */
    public function stok()
    {
        // Load produk beserta relasi kategori
        $products = Product::with('category')->orderBy('name', 'asc')->get();

        return view('pimpinan.stok', compact('products'));
    }

    /**
     * Tampilkan laporan penjualan
     */
    public function laporan(Request $request)
    {
        $filter = $request->query('filter', 'semua');

        // Ambil order yang sukses (payment_status = 1)
        $query = Order::with('user')->where('payment_status', 1);

        if ($filter === 'harian') {
            $query->whereDate('created_at', today());
        } elseif ($filter === 'mingguan') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter === 'bulanan') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        // Urutkan dari yang terbaru
        $orders = $query->orderBy('created_at', 'desc')->get();

        // Hitung total pendapatan dari data yang difilter
        // Kolom total pada tabel adalah 'total-price' sesuai dengan migrasi.
        $totalPendapatan = $orders->sum('total-price');

        return view('pimpinan.laporan', compact('orders', 'totalPendapatan', 'filter'));
    }
}
