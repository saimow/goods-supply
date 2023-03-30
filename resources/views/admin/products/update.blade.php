@extends('layouts.app')

@section('breadcrumb')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.index') }}">Products</a>
            </li>
            <li class="breadcrumb-item active">
                <span>Edit</span>
            </li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<div>
    <h3 class="mb-3">Update Product</h3>
    <div class="" id="app">
        <product-update 
            id= {{ $product->id }}
        ></product-update>
    </div>
</div>

@endsection