@extends('frontend.layouts.app')

@section('styles')

@endsection

@section('content')

<section class="section">
    <div class="container">

        <div class="row">
            <h4 class="section-heading">Properties</h4>
        </div>

        <div class="row">
            <div class="city-categories">
                @foreach($cities as $city)
                <div class="col s12 m3">
                    <a href="{{ route('property.city',$city->city_slug) }}">
                        <div class="city-category">
                            <span>{{ $city->city }}</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <div class="row">

            @foreach($properties as $property)
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        @if(Storage::disk('public')->exists('property/'.$property->image) && $property->image)
                        <span class="card-image-bg" style="background-image:url({{Storage::url('property/'.$property->image)}});"></span>
                        @else
                        <span class="card-image-bg"><span>
                                @endif
                                @if($property->featured == 1)
                                <a class="btn-floating halfway-fab waves-effect waves-light indigo"><i class="small material-icons">star</i></a>
                                @endif
                    </div>
                    <div class="card-content property-content">
                        <a href="{{ route('property.show',$property->slug) }}">
                            <span class="card-title tooltipped" data-position="bottom" data-tooltip="{{ $property->title }}">{{ str_limit( $property->title, 18 ) }}</span>
                        </a>

                        <div class="address">
                            <i class="small material-icons left">place</i>
                            <span>{{ ucfirst($property->city) }}</span>
                        </div>
                        <div class="address">
                            <i class="small material-icons left">language</i>
                            <span>{{ ucfirst($property->address) }}</span>
                        </div>

                        @if(auth()->check() && auth()->user()->role_id == 3)
                        <button class="add-to-cart-btn btn btn-primary" data-id="{{ $property->id }}">Add to Cart</button>
                        @endif
                        <div class="address">
                            <i class="small material-icons left">home</i>
                            <span>{{ ucfirst($property->type) }}</span>
                        </div>
                        <div class="address">
                            <i class="small material-icons left">local_offer</i>
                            <span>For {{ ucfirst($property->purpose) }}</span>
                        </div>

                        <h5>
                            &#8360;{{ $property->price }}
                            <div class="right" id="propertyrating-{{$property->id}}"></div>
                        </h5>
                    </div>
                    <div class="card-action property-action">
                        <span class="btn-flat">
                            <i class="material-icons">hotel</i>
                            Bedroom: <strong>{{ $property->bedroom}}</strong>
                        </span>
                        <span class="btn-flat">
                            <i class="material-icons">bathtub</i>
                            Bathroom: <strong>{{ $property->bathroom}}</strong>
                        </span>
                        <span class="btn-flat">
                            <i class="material-icons">square_foot</i>
                            Area: <strong>{{ $property->area}}</strong> Square Feet
                        </span>
                        <span class="btn-flat">
                            <i class="material-icons">comment</i>
                            <strong>{{ $property->comments_count}}</strong>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="m-t-30 m-b-60 center">
            {{ $properties->links() }}
        </div>

    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $('.add-to-cart-btn').click(function() {
            var propertyId = $(this).data('id');
            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: propertyId
                },
                success: function(response) {
                    if (response.already_in_cart) {
                        // If the same property is already in the cart, show notification
                        Swal.fire({
                            icon: 'info',
                            title: 'Already in Cart',
                            text: response.message
                        });
                    } else if (response.replace_confirmation) {
                        // If a different property is already in the cart, show a confirmation dialog
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
                                Swal.fire('Cancelled', 'Your current cart item was not replaced', 'info');
                            }
                        });
                    } else {
                        // If a new property is added without conflict, show success message
                        Swal.fire('Success', 'Property added to cart successfully!', 'success');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error adding property to cart!', 'error');
                }
            });
        });

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
                error: function() {
                    Swal.fire('Error', 'Error replacing cart item!', 'error');
                }
            });
        }
    });
</script>

<script>
    $(function() {
        var js_properties = <?php echo json_encode($properties); ?>;
        js_properties.data.forEach(element => {
            if (element.rating) {
                var elmt = element.rating;
                var sum = 0;
                for (var i = 0; i < elmt.length; i++) {
                    sum += parseFloat(elmt[i].rating);
                }
                var avg = sum / elmt.length;
                if (isNaN(avg) == false) {
                    $("#propertyrating-" + element.id).rateYo({
                        rating: avg,
                        starWidth: "20px",
                        readOnly: true
                    });
                } else {
                    $("#propertyrating-" + element.id).rateYo({
                        rating: 0,
                        starWidth: "20px",
                        readOnly: true
                    });
                }
            }
        });
    })
</script>

<style>
    .alert-box {
        position: fixed;
        top: 52%;
        right: 60%;
        padding: 10px 20px;
        background-color: #f0ad4e;
        color: white;
        border-radius: 5px;
        z-index: 1000;
    }

    .add-to-cart-btn {
        position: absolute;
        top: 55%;
        right: 10px;
        z-index: 10;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .card {
        position: relative;
    }
</style>

@endsection