@extends('layouts.user')

@section('content')

<div class="">
    <h3 class="mb-3">Show Product</h3>
    <div class="" id="app">
        <product-show
            id='{{ $id }}'
        ></product-show>
    </div>
</div>

@endsection