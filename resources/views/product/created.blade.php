@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="alert alert-success text-center" role="status">
    <h3>Product created successfully!</h3>
    <p class="mb-3"><strong>{{ $product['name'] }}</strong> — ${{ number_format((float) $product['price'], 2) }}</p>
    <a class="btn btn-success" href="{{ route('product.create') }}">Create another product</a>
</div>
@endsection
