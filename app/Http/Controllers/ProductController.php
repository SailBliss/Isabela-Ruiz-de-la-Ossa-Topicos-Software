<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /** @var array<int, array{id: int, name: string, description: string, price: float}> */
    public static array $products = [
        ['id' => 1, 'name' => 'TV', 'description' => 'Best TV', 'price' => 499.99],
        ['id' => 2, 'name' => 'iPhone', 'description' => 'Best iPhone', 'price' => 899.99],
        ['id' => 3, 'name' => 'Chromecast', 'description' => 'Best Chromecast', 'price' => 49.99],
        ['id' => 4, 'name' => 'Glasses', 'description' => 'Best Glasses', 'price' => 79.99],
    ];

    public function index(): View
    {
        return view('product.index', ['viewData' => [
            'title' => 'Products - Online Store',
            'subtitle' => 'List of products',
            'products' => self::$products,
        ]]);
    }

    public function show(string $id): View|RedirectResponse
    {
        $product = collect(self::$products)->firstWhere('id', (int) $id);

        if ($product === null || ! ctype_digit($id)) {
            return redirect()->route('home.index');
        }

        return view('product.show', ['viewData' => [
            'title' => $product['name'].' - Online Store',
            'subtitle' => $product['name'].' - Product information',
            'product' => $product,
        ]]);
    }

    public function create(): View
    {
        return view('product.create', ['viewData' => [
            'title' => 'Create product',
            'subtitle' => 'New product',
        ]]);
    }

    public function save(Request $request): View
    {
        $product = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:0'],
        ]);

        return view('product.created', [
            'viewData' => [
                'title' => 'Product created - Online Store',
                'subtitle' => 'Product created successfully!',
            ],
            'product' => $product,
        ]);
    }
}
