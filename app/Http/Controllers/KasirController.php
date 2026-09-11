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
}
