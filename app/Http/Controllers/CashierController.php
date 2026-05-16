<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CashierController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->get();
        $paymentSettings = PaymentSetting::firstOrNew();
        return view('pos', compact('products', 'paymentSettings'));
    }

    public function nota(Request $request): View
    {
        $cart = json_decode($request->input('cart'), true);

        $productIds = collect($cart)->pluck('id');
        $dbProducts = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $subtotal = 0;
        foreach ($cart as &$item) {
            $dbProduct = $dbProducts->get($item['id']);
            if (!$dbProduct) {
                continue;
            }
            $item['nama_kopi'] = $dbProduct->nama_kopi;
            $item['harga'] = $dbProduct->harga;
            $item['subtotal'] = $dbProduct->harga * $item['qty'];
            $subtotal += $item['subtotal'];
        }

        $paymentMethod = $request->input('payment_method', 'tunai');
        $paymentSettings = PaymentSetting::firstOrNew();

        return view('nota', compact('cart', 'subtotal', 'paymentMethod', 'paymentSettings'));
    }
}
