<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    private const PRODUCTS = [
        121 => ['name' => 'Tv samsung', 'price' => '1000'],
        11 => ['name' => 'Iphone', 'price' => '2000'],
    ];

    public function index(Request $request): View
    {
        $cartProductData = $request->session()->get('cart_product_data', []);
        $cartProducts = array_intersect_key(self::PRODUCTS, array_flip($cartProductData));

        $viewData = [];
        $viewData['title'] = 'Cart - Online Store';
        $viewData['subtitle'] = 'Shopping Cart';
        $viewData['products'] = self::PRODUCTS;
        $viewData['cartProducts'] = $cartProducts;

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(string $id, Request $request): RedirectResponse
    {
        abort_unless(ctype_digit($id) && isset(self::PRODUCTS[(int) $id]), 404);

        $cartProductData = $request->session()->get('cart_product_data', []);
        $cartProductData[(int) $id] = (int) $id;
        $request->session()->put('cart_product_data', $cartProductData);

        return back();
    }

    public function removeAll(Request $request): RedirectResponse
    {
        $request->session()->forget('cart_product_data');

        return back();
    }
}
