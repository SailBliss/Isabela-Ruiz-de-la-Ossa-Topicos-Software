<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::query()->orderBy('id')->get(), 200);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(Product::query()->findOrFail($id), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:0'],
        ]);

        $product = DB::transaction(fn (): Product => Product::query()->create($validated));

        return response()->json($product, 201);
    }
}
