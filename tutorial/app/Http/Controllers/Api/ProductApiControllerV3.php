<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductApiControllerV3 extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(new ProductCollection(Product::query()->orderBy('id')->get()), 200);
    }

    public function paginate(): JsonResponse
    {
        $products = Product::query()->orderBy('id')->paginate(5);

        return response()->json((new ProductCollection($products))->response()->getData(true), 200);
    }
}
