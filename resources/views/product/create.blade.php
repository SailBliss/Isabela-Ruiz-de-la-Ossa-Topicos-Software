@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Create product</div>
            <div class="card-body">
                @if ($errors->any())
                    <ul id="errors" class="alert alert-danger list-unstyled" role="alert">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                @endif
                <form method="POST" action="{{ route('product.save') }}">
                    @csrf
                    <label class="form-label" for="name">Name</label>
                    <input id="name" type="text" class="form-control mb-2" name="name" value="{{ old('name') }}" required>
                    <label class="form-label" for="price">Price</label>
                    <input id="price" type="number" min="0.01" step="0.01" class="form-control mb-3" name="price" value="{{ old('price') }}" required>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
