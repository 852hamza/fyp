{{-- resources/views/cart/index.blade.php --}}

@extends('frontend.layouts.app')

@section('styles')

@endsection



@section('content')
<div class="container mt-4">
    <h1>Property Cart</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($cartItems->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Property Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cartItems as $item)
                    @php
                        $property = $item->property;
                        $subtotal = $property->price * $item->quantity;
                    @endphp
                    <tr>
                        <td>{{ $property->title }}</td>
                        <td>${{ $property->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $subtotal }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->property_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @php $total += $subtotal; @endphp
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>Total</strong></td>
                    <td colspan="2">${{ $total }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
