<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<footer class="page-footer  darken-2">
    <div class="container-footer">
        <div class="row">
            <div class="col m4 s12">
                <div > <!-- Center content horizontally -->
                    <img src="{{ asset('storage/logo-white.png') }}" alt="Terra Trove" style="width: 95px;"> <!-- Adjust path and size as needed -->
                    <p class="white-text">Experience comprehensive real estate services with us: Manage your property listings, enhance your portfolio, and streamline your transactions using our digital tools.</p>
                    <div class="social-icons">
                        <a href="your_facebook_link" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="your_linkedin_link" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="your_instagram_link" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        
            <div class="col m4 s12">
                <ul>
                    <h5 class="white-text uppercase">Quick Links</h5>
                    <li class="uppercase {{ Request::is('property*') ? 'underline' : '' }}">
                        <a href="{{ route('home') }}" class="grey-text text-lighten-3">Home</a>
                    </li>
                    <li class="uppercase {{ Request::is('property*') ? 'underline' : '' }}">
                        <a href="{{ route('property') }}" class="grey-text text-lighten-3">Properties</a>
                    </li>

                    <li class="uppercase {{ Request::is('agents*') ? 'underline' : '' }}">
                        <a href="{{ route('agents') }}" class="grey-text text-lighten-3">Agents</a>
                    </li>

                    <li class="uppercase {{ Request::is('gallery*') ? 'underline' : '' }}">
                        <a href="{{ route('gallery') }}" class="grey-text text-lighten-3">Gallery</a>
                    </li>

                    <li class="uppercase {{ Request::is('blog*') ? 'underline' : '' }}">
                        <a href="{{ route('blog') }}" class="grey-text text-lighten-3">Blog</a>
                    </li>

                    <li class="uppercase {{ Request::is('contact') ? 'underline' : '' }}">
                        <a href="{{ route('contact') }}" class="grey-text text-lighten-3">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="col m4 s12">
                <ul class="collection-border0-loc" style="margin-top: 75px; margin-right: 130px;">
                    <li class="collection-item transparent clearfix p-0 border0" style="margin-bottom: 20px;">
                        <i class="material-icons left">location_on</i>
                        <span class="white-text">Narowal</span>
                    </li>
                    <li class="collection-item transparent clearfix p-0 border0" style="margin-bottom: 20px;">
                        <i class="material-icons left">phone</i>
                        <span class="white-text">03061232852</span>
                    </li>
                    <li class="collection-item transparent clearfix p-0 border0" style="margin-bottom: 20px;">
                        <i class="material-icons left">email</i>
                        <span class="white-text">ali6859099@gmail.com</span>
                    </li>
                </ul>

            </div>

        </div>
        <hr class="hr-footer">
        <div class="footer-copyright">
            <div >
                @if(isset($footersettings[0]) && $footersettings[0]['footer'])
                {{ $footersettings[0]['footer'] }}
                @else
                © Copyright 2024 Terra Trove All Rights Reserved.
                @endif

                @if(isset($footersettings[0]) && $footersettings[0]['facebook'])
                <a class="grey-text text-lighten-4 right" href="{{ $footersettings[0]['facebook'] }}" target="_blank">FACEBOOK</a>
                @endif
                @if(isset($footersettings[0]) && $footersettings[0]['twitter'])
                <a class="grey-text text-lighten-4 right m-r-10" href="{{ $footersettings[0]['twitter'] }}" target="_blank">TWITTER</a>
                @endif
                @if(isset($footersettings[0]) && $footersettings[0]['linkedin'])
                <a class="grey-text text-lighten-4 right m-r-10" href="{{ $footersettings[0]['linkedin'] }}" target="_blank">LINKEDIN</a>
                @endif

            </div>
        </div>
</footer>