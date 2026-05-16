<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CashierController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->get();
        return view('pos', compact('products'));
    }

    public function nota(Request $request): View
    {
        $cart = json_decode($request->input('cart'), true);

        $subtotal = 0;
        foreach ($cart as &$item) {
            $item['subtotal'] = $item['harga'] * $item['qty'];
            $subtotal += $item['subtotal'];
        }

        return view('nota', compact('cart', 'subtotal'));
    }
}
