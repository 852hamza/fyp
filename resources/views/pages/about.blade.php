@extends('frontend.layouts.app')

@section('styles')
<style>
    .container-about {
        width: 100%;
        max-width: 100%;
        padding: 0 15px;
        /* Adjusted for better spacing on smaller screens */
    }

    .team-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 20px;
        margin: 10px auto;
        /* Centering cards */
        background: #fff;
        border-radius: 8px;
        width: 100%;
        /* Ensures full width on smaller screens */
        max-width: 400px;
        /* Maximum width on larger screens */
        height: auto;
        /* Auto height for card */
    }

    .team-card img {
        width: 100%;
        /* Responsive image */
        height: 370px;
        /* Fixed height for all images */
        object-fit: cover;
        /* Cover ensures the image fills the height */
        border-radius: 2%;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .col {
        padding: 10px;
        box-sizing: border-box;
        width: 100%;
        /* Full width by default */
        display: flex;
        align-items: stretch;
        /* Aligns the cards vertically */
    }

    #map {
        height: 500px;
        /* Increased height */
        width: 80%;
        /* Reduced width */
        margin: auto;
        /* Centers the map horizontally */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .card-no-box-shadow {
        text-align: center;
        /* Ensures that the contents are centered */
    }

    .p-15 {
        padding: 15px 0;
        /* Adjust padding for better visual spacing */
    }

    .map-container {
        display: flex;
        justify-content: center;
        /* Centers the map container horizontally */
        align-items: center;
        /* Centers the map container vertically */
    }

    /* .map-container {
        position: relative;
    } */

    #map-button {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        background-color: #f44336;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    #map-button:hover {
        background-color: #d32f2f;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    @media (min-width: 600px) {

        /* For tablets and above */
        .col.s12.m3 {
            width: 50%;
            /* 2 columns for tablets */
        }
    }

    @media (min-width: 992px) {

        /* For desktops and larger devices */
        .col.s12.m3 {
            width: 25%;
            /* 4 columns for large screens */
        }
    }

    .social-icons i {
        padding: 5px;
        font-size: 30px;
        cursor: pointer;
    }

    @media (max-width: 767px) {
        .container-about {
            padding: 0 10px;
            /* Smaller padding on smaller screens */
        }

        .about-paragraph,
        .card-title,
        .designation {
            font-size: 16px;
            /* Smaller font size for mobile */
        }
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col s12 m12">
                <div class="about-content">
                    <h4 class="about-title">About Us</h4>
                    <p class="about-paragraph">Welcome to Terra Trove, your trusted partner in real estate with over five years of industry experience. We are dedicated to providing exceptional service and innovative solutions for all your real estate needs.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<hr style="opacity: 0.5; width:80%">
<!-- Developer SECTION -->
<section class="section white lighten-3 center">
    <div class="container-about">

        <h4>Meet Our Team</h4>
        <p class="about-paragraph">Introducing our dream team, the driving force behind project Terra Trove, a synergy of visionary designers, tech enthusiasts, and ingenious minds, all united to</p>
        <p class="about-paragraph">turn creativity into reality.</p>
        <hr style="text-align: center; width:10%; opacity: 0.5;">
        <div class="row" style="margin-left: 0; margin-right: 0;">
            <!-- Developer 1 -->
            <div class="col s12 m3">
                <div class="card team-card">
                    <img src="{{ asset('storage/developer/qasir.jpeg') }}" alt="Professor Qaisar">
                    <span class="card-title">Professor Qaisar</span>
                    <p class="designation">Supervisor</p>
                    <p>Expert in Computing & Data Analyst, specializing Theory of Automata and AI Computing.</p>
                    <hr style="width:100%; opacity: 0.5;">
                    <div class="social-icons">
                        <a href="https://www.linkedin.com/in/your-profile" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/your-username" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://www.facebook.com/qaiser.riaz.96930?mibextid=ZbWKwL" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col s12 m3">
                <div class="card team-card">
                    <img src="{{ asset('storage/developer/hamza.png') }}" alt="M Hamza Shabbir">
                    <span class="card-title">M Hamza Shabbir</span>
                    <p class="designation">Cloud Computing Expert</p>
                    <p>Expert in cloud & large scale infrastructure management & specializes in web & database.</p>
                    <hr style="width:100%; opacity: 0.5;">
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
                    <hr style="width:100%; opacity: 0.5;">
                    <div class="social-icons">
                        <a href="https://www.linkedin.com/in/ali-ahmad-0201a3299/" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://www.behance.net/aliahmad283" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-behance"></i>
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
                    <img src="{{ asset('storage/developer/adeel.jpeg') }}" alt="Adeel Ahmad">
                    <span class="card-title">Adeel Ahmad</span>
                    <p class="designation">Front-end Developer</p>
                    <p>Front-end developer with a keen eye for design and user experience, expert in React and JavaScript.</p>
                    <hr style="width:100%; opacity: 0.5;">
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
<section>
    <div class="card-no-box-shadow card">
        <div class="p-15 grey lighten-4">
            <h5 class="m-0">Location</h5>
        </div>
        <div class="map-container">
            <div id="map"></div>
        </div>
    </div>
</section>

<script>
    function initMap() {
        var propLatLng = {
            lat: 32.1009752,
            lng: 74.872238
        };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13.5,
            center: propLatLng
        });
        var marker = new google.maps.Marker({
            position: propLatLng,
            map: map,
        });
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRLaJEjRudGCuEi1_pqC4n3hpVHIyJJZA&callback=initMap">
</script>
@endsection