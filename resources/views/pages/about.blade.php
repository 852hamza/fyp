@extends('frontend.layouts.app')

@section('styles')

@endsection

@section('content')

    <section class="section">
        <div class="container">
            <div class="row">

                <div class="col s12 m8">
                    <div class="about-content">
                        <h4 class="about-title">About Us</h4>
                        
                        <!-- Image Section -->
                        <div class="about-image">
                            <!-- <img src="{{ asset('images/about-us.jpg') }}" alt="About Terra Trove" class="responsive-img"> -->
                            <img src="https://images.unsplash.com/photo-1565402170291-8491f14678db?text=Real+Estate" alt="About Terra Trove" class="responsive-img" style="width: 100%; height: 400px;">
                        </div>

                        <p>Welcome to Terra Trove, your trusted partner in real estate with over five years of industry experience. We are dedicated to providing exceptional service and innovative solutions for all your real estate needs.</p>

                        <p>Founded in 2019, Terra Trove has quickly become a leading name in the real estate sector, known for our commitment to quality, integrity, and customer satisfaction. Our team of experienced professionals is here to guide you through every step of your real estate journey, whether you're buying, selling, or renting.</p>

                        <p>At Terra Trove, we believe in building lasting relationships with our clients and communities, striving to exceed expectations with every project we undertake. Join us as we continue to shape the future of real estate.</p>

                    </div>
                </div> <!-- /.col -->

                <div class="col s12 m4">
                    <div class="about-sidebar">
                        <div class="m-t-30">
                            <i class="material-icons left">business</i>
                            <h6 class="uppercase">Our Mission</h6>
                            <p>To deliver outstanding real estate experiences with passion, reliability, and unparalleled expertise.</p>
                        </div>
                        <div class="m-t-30">
                            <i class="material-icons left">timeline</i>
                            <h6 class="uppercase">Our Vision</h6>
                            <p>To be the leading real estate firm admired for its people, partnerships, and performance.</p>
                        </div>
                        <div class="m-t-30">
                            <i class="material-icons left">group</i>
                            <h6 class="uppercase">Our Team</h6>
                            <p>Meet our dedicated team of real estate professionals who bring their expertise, creativity, and passion to every project.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        $(function(){
            // Add any specific JavaScript needed for the About Us page
        })

    </script>
@endsection
