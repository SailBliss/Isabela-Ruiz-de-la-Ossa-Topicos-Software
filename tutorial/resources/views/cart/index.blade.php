@extends('layouts.app')
@section("title", $viewData["title"])
@section("subtitle", $viewData["subtitle"])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Available products</h1>
            <ul>
                @foreach($viewData["products"] as $key => $product)
                <li>
                    Id: {{ $key }} -
                    Name: {{ $product["name"] }} -
                    Price: {{ $product["price"] }} -
                    <form method="POST" action="{{ route('cart.add', ['id' => $key]) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-link p-0" type="submit">Add to cart</button>
                    </form>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Products in cart</h1>
            <ul>
                @foreach($viewData["cartProducts"] as $key => $product)
                <li>
                    Id: {{ $key }} -
                    Name: {{ $product["name"] }} -
                    Price: {{ $product["price"] }}
                </li>
                @endforeach
            </ul>
            <form method="POST" action="{{ route('cart.removeAll') }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-link p-0" type="submit">Remove all products from cart</button>
            </form>
        </div>
    </div>
</div>
@endsection
