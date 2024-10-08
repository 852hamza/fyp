@extends('frontend.layouts.app')

@section('styles')
<style>
    .section-1 {
        padding: 2.5%;
    }

    .contact-page-1 {
        position: relative;
        /* Set relative positioning for the parent */
        display: flex;
        /* align-items: center; */
        /* Center the content vertically */
        background-color: blue;
        opacity: 0.82;
        /* Purple background */
        padding-left: 20px;
        /* Padding for spacing the content */
        /* min-height: 95vh; */
        /* Full height */
        border-radius: 10px;
    }


    .contact-form {
        position: absolute;
        /* Absolute positioning */
        right: 3%;
        /* Align to the right side */
        top: 8%;
        /* Align to the top */
        width: 45%;
        /* Width of the form */
        background-color: white;
        /* Background color of the form */
        padding: 20px;
        /* Padding inside the form */
        /* min-height: 70vh; */
        /* Full height */
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
        /* Shadow for 3D effect */
        z-index: 1;
        /* Lower index to stay below contact details if overlapping */
        border-radius: 10px;
    }

    .contact-form form {
        display: flex;
        flex-direction: column;
    }

    .form-field {
        margin-bottom: 20px;
        /* Space between form fields */
    }

    .form-field label {
        display: inline-block;
        font-size: 16px;
        word-break: break-word;
        cursor: default;
        margin-bottom: 0.25rem;
        font-weight: 500;
        color: rgb(0, 0, 0);
    }


    button {
        background-color: #6200EA;
        /* Deep purple for the button */
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        width: 100%;
        /* Full width button */
    }

    .contact-details-1 {
        /* background-color: #9C27B0; */
        /* Purple background */
        color: white;
        /* White text for contrast */
        font-family: 'Arial', sans-serif;
        /* Arial font for clean typography */
        padding: 40px;
        /* Padding around the content */
        width: 50%;
        /* Full width of the container */
    }

    .contact-details-1 h1 {
        font-size: 32px;
        /* Large font size for the header */
        margin-bottom: 10px;
        /* Space below the header */
    }

    /* .contact-details-1 p1 {

        font-family: Poppins;
        line-height: 1.55;
        text-decoration: none;
        color: red;
        max-width: 400px;
        margin-top: 12px;
        margin-bottom: 30px;

    } */

    .contact-details-1 ul {
        list-style: none;
        /* Remove default list styling */
        padding: 0;
        /* Remove default padding */
        margin: 0 0 20px;
        /* Space below the list */

    }

    .contact-details-1 ul li {
        font-size: 16px;
        /* Standard font size for list items */
        margin-bottom: 8px;
        /* Space between list items */
    }

    .social-icons-1 {
        display: flex;
        flex-direction: column;
        /* Stack icons vertically */
        align-items: flex-start;
        /* Align icons to the left */
        margin-top: 20px;
        /* Space above the first icon */
    }

    .social-icons-1 a {
        color: white;
        /* Icon color */
        margin-bottom: 15px;
        /* Space between icons */
        text-decoration: none;
        /* No underline */
        font-size: 16px;
        /* Size of the icons */
    }

    .social-icons-1 i {
        margin-right: 10px;
        /* color: rgb(255, 255, 255); */
    }

    .contact-details-1 ul li i {
        margin-right: 5px;
    }

    /*  */

    .contact-info {
        display: flex;
        flex-direction: column;
        margin-bottom: 25px;
        margin-top: 30px;
        /* background-color: #f4f4f4; */
        /* Light background for visibility */
        /* padding: 5px; */
    }

    .contact-detail {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        /* Space between contact details */
    }

    .contact-detail i {
        font-size: 22px;
        color: white;
        /* Dark color for icons */
        margin-right: 10px;
        /* Space between icon and text */
    }

    .detail {
        display: block;
    }

    .detail span {
        /* font-weight: bold; */
        color: white;
        font-size: 12px;
        /* Slightly darker text for labels */
    }

    .detail p {
        margin: 0;
        /* Remove default margin */
        color: while;
        font-size: 15px;
        /* Lighter text for details */
    }

    /*  */

    .input-contact {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .contact-form form textarea {
        width: 100%;
        /* Ensures the textarea always takes up the full width of its parent container */
        padding: 8px;
        /* Padding inside the textarea */
        height: 140px;
        /* Default height */
    }

    #phone::placeholder {
        color: rgba(0, 0, 0, 0.4);
        /* Light grey placeholder text */
    }

    #phone:focus {
        outline: none;
        /* Optional: removes the outline */
        border: 2px solid #6200EA;
        /* Highlight with a purple border */
    }


    /* Media queries for different screen sizes */
    @media (max-height: 864px) {

        /* For tablets and smaller devices */
        .contact-form form textarea {
            height: 100px;
            /* Smaller height for smaller devices */
        }
    }

    @media (max-height: 500px) {

        /* For mobile phones */
        .contact-form form textarea {
            height: 80px;
            /* Even smaller height to fit on mobile screens */
            padding: 6px;
            /* Slightly smaller padding to save space */
        }
    }
</style>

@endsection

@section('content')
<section class="section-1">
    <div class="contact-page-1">
        <div class="contact-details-1">
            <h1>Contact Us</h1>
            <h6>Leave your email and we will get back to you </h6>
            <h6> within 24 hours</h6>
            <div class="contact-info">
                <div class="contact-detail">
                    <i class="bi bi-at"></i>
                    <div class="detail">
                        <span>Email</span>
                        <p>hamzaarain852sba@gmail.com</p>
                    </div>
                </div>
                <div class="contact-detail">
                    <i class="bi bi-telephone"></i>
                    <div class="detail">
                        <span>Phone</span>
                        <p>+92 (306) 12 32 852</p>
                    </div>
                </div>
                <div class="contact-detail">
                    <i class="bi bi-geo-alt"></i>
                    <div class="detail">
                        <span>Address</span>
                        <p>2-KM Muridke Road, Narowal</p>
                    </div>
                </div>
                <div class="contact-detail">
                    <i class="bi bi-sun"></i>
                    <div class="detail">
                        <span>Open Hours</span>
                        <p>10 AM – 6 PM (Monday – Friday)</p>
                    </div>
                </div>
            </div>

            <div class="social-icons-1">
                <a href="#"><i class="bi bi-facebook"></i>Facebook</a>
                <a href="#"><i class="bi bi-twitter"></i>Twitter</a>
                <a href="#"><i class="bi bi-youtube"></i>Youtube</a>
                <a href="#"><i class="bi bi-instagram"></i>Instagram</a>
            </div>

        </div>
        <div class="contact-form">
            <form action="{{ route('contact.send') }}" method="POST">
                @csrf {{-- CSRF token for form protection --}}
                <div class="form-field">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-field">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-field">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" placeholder="+92xxxxxxxxx" pattern="\+92\d{10}" title="Phone number must start with +92 followed by 10 digits." value="+92" maxlength="13" required>

                    <div class="form-field">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="btn-send">Send Message</button>
            </form>
        </div>

    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('textarea#message').characterCounter();

        $('#contact-us').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = "{{ route('contact.send') }}";
            var btn = $('#msgsubmitbtn');

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                beforeSend: function() {
                    btn.addClass('disabled');
                    btn.html('<span>LOADING...</span><i class="material-icons right">rotate_right</i>');
                },
                success: function(response) {
                    M.toast({
                        html: response.message,
                        classes: 'green darken-4'
                    });
                    $('#contact-us')[0].reset(); // Reset form after successful submission
                },
                error: function() {
                    M.toast({
                        html: 'ERROR: Failed to send message!',
                        classes: 'red darken-4'
                    });
                },
                complete: function() {
                    btn.removeClass('disabled');
                    btn.html('<span>SEND</span><i class="material-icons right">send</i>');
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function() {
            let inputVal = this.value;
            // If the user deletes the +92 prefix, add it back.
            if (!inputVal.startsWith('+92')) {
                this.value = '+92' + inputVal.replace(/[^0-9]/g, '');
            } else {
                this.value = '+92' + inputVal.slice(3).replace(/[^0-9]/g, '');
            }
            // Ensure the total length does not exceed 13 characters (+92 followed by 10 digits)
            if (this.value.length > 13) {
                this.value = this.value.slice(0, 13);
            }
        });
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

@endsection