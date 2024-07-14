@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form id="loginForm" class="form-horizontal" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="loginBtn">
                                    Login
                                </button>
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    Don't have an account?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submit
        const formData = $(this).serialize(); // Serialize form data
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#loginBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...');
            },
            success: function(response) {
                const token = response.token; // Extract the token from response
                localStorage.setItem('token', token); // Store token in localStorage
                window.location.href = '/'; // Redirect to home
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseJSON.message);
                $('#loginBtn').prop('disabled', false).html('Login');
                alert('Login failed. Please check your credentials.');
            },
            complete: function() {
                $('#loginBtn').prop('disabled', false).html('Login');
            }
        });
    });
});
</script>
@endsection
