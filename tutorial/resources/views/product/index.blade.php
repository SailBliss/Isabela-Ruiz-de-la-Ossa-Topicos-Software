@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="row">
    @foreach ($viewData['products'] as $product)
        <div class="col-md-4 col-lg-3 mb-3">
            <div class="card h-100">
                <img src="https://laravel.com/img/logotype.min.svg" class="card-img-top img-card p-4" alt="Laravel logo">
                <div class="card-body text-center">
                    <h3 class="h5">{{ $product['name'] }}</h3>
                    <p>${{ number_format($product['price'], 2) }}</p>
                    <a href="{{ route('product.show', ['id' => $product['id']]) }}" class="btn bg-primary text-white">View details</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
