@extends('frontend.layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Property Cart</h1>

    @if($cartItems->count() > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Property Name</th>
                <th>Price (PKR)</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item->property->title }}</td>
                <td>{{ number_format($item->property->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->property->price * $item->quantity, 2) }}</td>
                <td>
                    <!-- Add the confirmation pop-up here -->
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmRemove({{ $item->property_id }})">
                        Remove
                    </button>
                    <!-- Hidden form that will be submitted on confirmation -->
                    <form id="remove-form-{{ $item->property_id }}" action="{{ route('cart.remove', $item->property_id) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-right"><strong>Total</strong></td>
                <td colspan="2">{{ number_format($total, 2) }} PKR</td>
            </tr>
        </tbody>
    </table>

    <!-- Checkout Button -->
    <form action="{{ route('checkout.create') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary mt-3">Proceed to Payment</button>
    </form>
    @else
    <p>Your cart is empty.</p>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function confirmRemove(propertyId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will remove this property from your cart!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the remove form
                document.getElementById('remove-form-' + propertyId).submit();
            }
        });
    }
</script>

@endsection