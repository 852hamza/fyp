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
    function addToCart(propertyId) {
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                id: propertyId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.already_in_cart) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already in Cart',
                        text: response.message
                    });
                } else if (response.replace_confirmation) {
                    Swal.fire({
                        title: 'Replace Cart Item?',
                        text: response.message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, replace it!',
                        cancelButtonText: 'No, keep current'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user confirms, replace the cart item
                            replaceCartItem(response.property_id);
                        } else {
                            // If user cancels, do nothing
                            Swal.fire('Cancelled', 'Your cart item was not replaced', 'info');
                        }
                    });
                } else {
                    Swal.fire('Success', 'Property added to cart successfully!', 'success');
                }
            },
            error: function(error) {
                Swal.fire('Error', 'Error adding property to cart!', 'error');
            }
        });
    }

    function replaceCartItem(propertyId) {
        $.ajax({
            url: '{{ route("cart.replace") }}',
            method: 'POST',
            data: {
                id: propertyId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire('Success', response.success, 'success');
                // Optionally, refresh the page or update the cart UI here
            },
            error: function(error) {
                Swal.fire('Error', 'Error replacing cart item!', 'error');
            }
        });
    }
</script>
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