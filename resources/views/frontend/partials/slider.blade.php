<section class="carousel carousel-slider center">
    @if($sliders)
        @foreach($sliders as $slider)
            <div class="carousel-item" style="background-image: url({{Storage::url('slider/'.$slider->image)}}); background-size: cover; background-repeat: no-repeat; background-position: center; display: flex; align-items: center; justify-content: center; height: 100%;" href="#{{$slider->id}}!">
                <div class="slider-content">
                    <h2 class="white-text">{{ $slider->title }}</h2>
                    <!-- <p class="white-text">{{ $slider->description }}</p> -->
                </div>
            </div>
        @endforeach
    @else 
        <div class="carousel-item amber indigo-text" style="background-image: url({{ asset('frontend/images/real_estate.jpg') }}); background-size: cover; background-repeat: no-repeat; background-position: center;" href="#1!">
            <h2>Slider Title goes here</h2>
            <p class="indigo-text">Slider description goes here</p>
        </div>
    @endif
</section>