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
                            <i class="small material-icons left">check_box</i>
                            <span>{{ ucfirst($property->type) }}</span>
                        </div>
                        <div class="address">
                            <i class="small material-icons left">check_box</i>
                            <span>For {{ ucfirst($property->purpose) }}</span>
                        </div>

                        <h5>
                            &dollar;{{ $property->price }}
                            <div class="right" id="propertyrating-{{$property->id}}"></div>
                        </h5>
                    </div>
                    <div class="card-action property-action">
                        <span class="btn-flat">
                            <i class="material-icons">check_box</i>
                            Bedroom: <strong>{{ $property->bedroom}}</strong>
                        </span>
                        <span class="btn-flat">
                            <i class="material-icons">check_box</i>
                            Bathroom: <strong>{{ $property->bathroom}}</strong>
                        </span>
                        <span class="btn-flat">
                            <i class="material-icons">check_box</i>
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
<!-- <script>
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
                    if(response.success) {
                        alert('Added to cart successfully!');
                    } else {
                        alert('Failed to add to cart.');
                    }
                },
                error: function() {
                    alert('Error adding to cart.');
                }
            });
        });
    });
</script> -->

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
                    if (response.success) {
                        showTemporaryAlert('Added to cart successfully!');
                    } else {
                        showTemporaryAlert('Failed to add to cart.');
                    }
                },
                error: function() {
                    showTemporaryAlert('Error adding to cart.');
                }
            });
        });

        function showTemporaryAlert(message) {
            var alertBox = $('<div class="alert-box">' + message + '</div>');
            $('body').append(alertBox);
            setTimeout(function() {
                alertBox.fadeOut(function() {
                    $(this).remove();
                });
            }, 2000);
        }
    });
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
        /* padding: 10px 20px; */
        border-radius: 5px;
        cursor: pointer;
    }

    .card {
        position: relative;
    }
</style>
@endsection