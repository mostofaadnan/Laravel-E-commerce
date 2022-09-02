@extends('frontend.layout.master')
@section('content')
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Register</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Register</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!-- Bread Crumb END -->

<!-- CONTAIN START -->
<section class="checkout-section ptb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-md-8 ">

                        <form class="main-form full" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-20">
                                    <div class="heading-part heading-bg">
                                        <h2 class="heading">Create your account</h2>
                                    </div>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <ul>
                                            @foreach ($errors->all() as $message)
                                            <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="heading-part line-bottom ">
                                        <h2 class="form-title heading">Your Personal Details</h2>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-box">

                                        <label for="f-name">Full Name</label>
                                        <input id="f-name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-box">
                                        <label for="login-email">Email address</label>
                                        <input id="login-email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-box">
                                        <label for="telephone">Mobile<span>*</span></label>
                                        <input id="telephone" type="tel" name="phone"  required placeholder="Mobile Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-box">
                                        <label for="login-pass">Password <span>*(Minimum 8 digits)</span></label>
                                        <input id="login-pass" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter your Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-box">
                                        <label for="re-enter-pass">Confirm Passwords <span>*</span></label>
                                        <input id="re-enter-pass" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter your Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="check-box left-side mb-20">
                                        <span>
                                            <input type="checkbox" name="remember_me" id="remember_me" class="checkbox">
                                            <label for="remember_me">Remember Me</label>
                                        </span>
                                    </div>
                                    <button name="submit" type="submit" class="btn-color right-side">Submit</button>
                                </div>
                                <div class="col-12">
                                    <hr>
                                    <div class="new-account align-center mt-20"> <span>Already have an account with us</span> <a class="link" title="Register with Shopholic" href="{{ route('login') }}">Login Here</a> </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection