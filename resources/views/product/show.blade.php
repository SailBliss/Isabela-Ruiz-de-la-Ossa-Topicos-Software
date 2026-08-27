@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-4 d-flex align-items-center"><img src="https://laravel.com/img/logotype.min.svg" class="img-fluid p-4" alt="Laravel logo"></div>
        <div class="col-md-8">
            <div class="card-body">
                <h3 class="card-title {{ $viewData['product']['price'] > 80 ? 'text-danger' : '' }}">{{ $viewData['product']['name'] }}</h3>
                <p class="card-text">{{ $viewData["product"]["price"] }}</p>
                <p class="card-text fw-bold">Price: ${{ number_format($viewData['product']['price'], 2) }}</p>

                @foreach($viewData["product"]->comments as $comment)
                    - {{ $comment->getDescription() }}<br />
                @endforeach

                <a class="btn btn-outline-secondary" href="{{ route('product.index') }}">Back to products</a>
            </div>
        </div>
    </div>
</div>
@endsection
