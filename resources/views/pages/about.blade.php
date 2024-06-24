@extends('frontend.layouts.app')
@section('styles')

<style>
    .container {
        width: 100%;
        /* Ensures container takes full width */
        max-width: 100%;
        /* Removes any maximum width constraints */
        padding: 0 30px;
        /* Adds some padding on the sides */
    }

    .team-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 20px;
        margin: 10px;
        background: #fff;
        /* Optional: Adds background color */
        border-radius: 8px;
        /* Optional: Rounds the corners of the card */
        width: 400px;
        /* Makes the card take full width of the column */
    }

    .col {
        padding: 10px;
        /* Adds padding to handle spacing between columns */
        float: left;
        /* Ensures that columns are aligned horizontally */
        box-sizing: border-box;
        /* Includes padding in the width calculation */
    }

    .col.s12.m3 {
        width: 25%;
        /* Each column takes 25% of the row on medium and up screens */
    }

    .team-card img {
        width: 350px;
        /* Ensures image takes up full column width */
        height: 350px;
        /* Keeps image aspect ratio intact */
        border-radius: 7%;
        /* Optional: Rounds the corners of the image */
    }

    .card-title {
        margin-top: 10px;
        font-size: 20px;
    }

    .designation {
        font-size: 16px;
        color: gray;
        margin-bottom: 10px;
        /* Adds space between designation and description */
    }

    .social-icons {
        margin-top: 10px;
    }

    .social-icons i {
        padding: 5px;
        font-size: 30px;
        cursor: pointer;
    }

</style>
@endsection

@section('content')

<section class="section">
    <div class="container">
        <div class="row">

            <div class="col s12 m8">
                <div class="about-content">
                    <h4 class="about-title">About Us</h4>

                    <!-- Image Section -->
                    <!-- <div class="about-image"> -->
                        <!-- <img src="{{ asset('images/about-us.jpg') }}" alt="About Terra Trove" class="responsive-img"> -->
                        <!-- <img src="https://images.unsplash.com/photo-1565402170291-8491f14678db?text=Real+Estate" alt="About Terra Trove" class="responsive-img" style="width: 400px; height: 200px;  "> -->
                    <!-- </div> -->

                    <p>Welcome to Terra Trove, your trusted partner in real estate with over five years of industry experience. We are dedicated to providing exceptional service and innovative solutions for all your real estate needs.

                        Founded in 2019, Terra Trove has quickly become a leading name in the real estate sector, known for our commitment to quality, integrity, and customer satisfaction. Our team of experienced professionals is here to guide you through every step of your real estate journey, whether you're buying, selling, or renting.

                        At Terra Trove, we believe in building lasting relationships with our clients and communities, striving to exceed expectations with every project we undertake. Join us as we continue to shape the future of real estate.</p>

                </div>
            </div>

            <div class="col s12 m3">
                <div class="about-sidebar" style="display: flex;">
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
                    <!-- <div class="m-t-30">
                            <i class="material-icons left">group</i>
                            <h6 class="uppercase">Our Team</h6>
                            <p>Meet our dedicated team of real estate professionals who bring their expertise, creativity, and passion to every project.</p>
                        </div> -->
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Developer SECTION -->
<section class="section white lighten-3 center">
    <div class="container">

        <h4 class="section-heading">Meet Our Team</h4>

        <div class="row" style="margin-left: 0; margin-right: 0;">
            <!-- Developer 1 -->
            <div class="col s12 m3">
                <div class="card team-card">
                    <img src="{{ asset('storage/developer/qaiser.jpeg') }}" alt="Professor Qaisar">
                    <span class="card-title">Professor Qaisar</span>
                    <p class="designation">Supervisor</p>
                    <p>Expert in Computing & Data Analyst, specializing Theory of Automata and AI Computing.</p>
                    <div class="social-icons">
                        <a href="https://www.linkedin.com/in/your-profile" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/your-username" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://facebook.com/your-username" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col s12 m3">
                <div class="card team-card">
                    <img src="{{ asset('storage/developer/hamza.jpg') }}" alt="M Hamza Shabbir">
                    <span class="card-title">M Hamza Shabbir</span>
                    <p class="designation">Cloud Computing Expert</p>
                    <p>Expert in cloud & large scale infrastructure management & specializes in web & database.</p>
                    <div class="social-icons">
                        <a href="https://www.linkedin.com/in/mhamza-shabbir/" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/852hamza" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://facebook.com/m_hamza852" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Developer 2 -->
            <div class="col s12 m3">
                <div class="card team-card">
                    <img src="{{ asset('storage/developer/ali.jpg') }}" alt="Ali Ahmad">
                    <span class="card-title">Ali Ahmad</span>
                    <p class="designation">UI/UX Specialist</p>
                    <p>Specializes in UI/UX, passionate about new web technologies.</p>
                    <div class="social-icons">
                        <a href="https://www.linkedin.com/in/ali-ahmad-0201a3299/" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/your-username" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://www.facebook.com/aa5614535?mibextid=ZbWKwL" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Developer 3 -->
            <div class="col s12 m3">
                <div class="card team-card">
                    <img src="{{ asset('storage/developer/adeel.jpg') }}" alt="Adeel Ahmad">
                    <span class="card-title">Adeel Ahmad</span>
                    <p class="designation">Front-end Developer</p>
                    <p>Front-end developer with a keen eye for design and user experience, expert in React and JavaScript.</p>
                    <div class="social-icons">
                        <a href="https://www.linkedin.com/in/adeel-ahmad-9a3969247/" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/adeel091" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://www.facebook.com/chotta.malik.161?mibextid=ZbWKwL" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>

                </div>
            </div>
            <!-- Add more developers as needed -->
        </div>

    </div>

    </div>

</section>

@endsection

@section('scripts')
<script>
    $(function() {
        // Add any specific JavaScript needed for the About Us page
    })
</script>
@endsection