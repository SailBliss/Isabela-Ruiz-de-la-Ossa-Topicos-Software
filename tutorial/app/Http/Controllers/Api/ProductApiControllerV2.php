<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductApiControllerV2 extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => ProductResource::collection(Product::query()->orderBy('id')->get())], 200);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(['data' => new ProductResource(Product::query()->findOrFail($id))], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:0'],
        ]);

        $product = DB::transaction(fn (): Product => Product::query()->create($validated));

        return response()->json(['data' => new ProductResource($product)], 201);
    }
}
