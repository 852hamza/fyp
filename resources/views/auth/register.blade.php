@extends('frontend.layouts.app')

@section('content')
<div class="row">
    <div class="col s12 m6 offset-m3">
        <div class="card">
            <h4 class="center indigo-text uppercase p-t-30">{{ __('Register') }}</h4>
            <div class="p-20">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
    <div class="input-field col s12">
        <label for="name">{{ __('Name') }}</label>
        <input id="name" type="text" name="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" required>
        @include('partials.error', ['fieldName' => 'name'])
    </div>
</div>

                    <!-- Username Field -->
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="username">{{ __('Username') }}</label>
                            <input id="username" type="text" class="{{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                            <span id="username-result"></span>
                            @include('partials.error', ['fieldName' => 'username'])
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="input-field col s12">
                        <label for="email">{{ __('E-Mail Address (Gmail only)') }}</label>
                        <input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="example@gmail.com">
                        <span id="email-result"></span>
                        @include('partials.error', ['fieldName' => 'email'])
                    </div>

                    <!-- Password Fields -->
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>
                            @include('partials.error', ['fieldName' => 'password'])
                        </div>
                        <div class="input-field col s12">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" name="password_confirmation" required>
                        </div>
                    </div>

                    <!-- Agent Checkbox -->
                    <p>
                        <label>
                            <input type="checkbox" name="agent" class="filled-in" />
                            <span>{{ __('Registration as Agent') }}</span>
                        </label>
                    </p>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="waves-effect waves-light btn indigo">{{ __('Register') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    var checkUsername = debounce(function() {
        var username = $('#username').val();
        if (username.length >= 3) {
            $.ajax({
                url: '{{ route('username.check') }}',
                type: 'POST',
                data: { username, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    $('#username-result').text(response ? 'Username is available.' : 'Username is not available.').css('color', response ? 'green' : 'red');
                }
            });
        } else {
            $('#username-result').text('');
        }
    }, 250);

    $('#username').on('keyup', checkUsername);

    $('#email').on('keyup', debounce(function() {
        var email = $(this).val();
        if (email.length > 5 && email.includes('@') && email.includes('.')) {
            $.ajax({
                url: '{{ route('email.check') }}',
                type: 'POST',
                data: { email, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    $('#email-result').text(response ? 'Email is available.' : 'Account with this email already exists.').css('color', response ? 'green' : 'red');
                }
            });
        } else {
            $('#email-result').text('');
        }
    }, 250));
});
</script>

@endsection
