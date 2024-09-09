@extends('frontend.layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Payment Successful</h1>
    <p>{{ session('success') }}</p>
    <a href="{{ route('cart.index') }}" class="btn btn-primary">Back to Cart</a>
</div>
@endsection
