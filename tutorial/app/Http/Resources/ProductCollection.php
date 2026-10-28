<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public $collects = ProductResource::class;

    public function paginationInformation($request, $paginated, $default): array
    {
        return $default;
    }

    public function toArray(Request $request): array
    {
        if ($this->resource instanceof \Illuminate\Contracts\Pagination\Paginator) {
            return ProductResource::collection($this->collection)->toArray($request);
        }

        return [
            'data' => ProductResource::collection($this->collection),
            'additionalData' => [
                'storeName' => 'Mega Store',
                'storeProductsLink' => route('product.index'),
            ],
        ];
    }
}
