@extends('layouts.app')
@section('title', 'Home Page - Online Store')
@section('content')
<div class="text-center py-5">
    <h1>Welcome to the application</h1>
    <p class="lead">Explore our products or create a new one.</p>
    <a class="btn bg-primary text-white" href="{{ route('product.index') }}">View products</a>
</div>
@endsection
