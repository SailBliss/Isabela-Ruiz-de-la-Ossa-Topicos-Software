@extends('layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)
@section('content')
<div class="card mx-auto contact-card">
    <div class="card-body">
        <h3 class="card-title">Creator information</h3>
        <dl class="row mb-0">
            <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $name }}</dd>
            <dt class="col-sm-3">Address</dt><dd class="col-sm-9">{{ $address }}</dd>
            <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $phone }}</dd>
        </dl>
    </div>
</div>
@endsection
