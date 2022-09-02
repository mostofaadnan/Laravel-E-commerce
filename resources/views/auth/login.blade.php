@extends('frontend.layout.master')
@section('content')
<!-- Bread Crumb STRAT -->
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Login</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Login</span></li>
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
                    <div class="col-xl-6 col-lg-8 col-md-8 ">
                        <form class="main-form full" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-20">
                                    <div class="heading-part heading-bg">
                                        <h2 class="heading">Customer Login</h2>
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
                               <!--      @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="error">{{ $message }}</strong>
                                    </span>
                                    @enderror -->
                                    <div class="input-box">
                                        <label for="login-email">{{ __('E-Mail Address') }}<span>*</span></label>

                                        <input id="login-email" type="email" class="from-class input_user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

                                    </div>
                                </div>
                                <div class="col-12">
                                 <!--    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror -->
                                    <div class="input-box">
                                        <label for="login-pass">{{ __('Password') }}<span>*</span></label>
                                    
                                        <input id="login-pass" type="password" class="input_pass form__input @error('password') is-invalid @enderror" name="password" required placeholder="@lang('home.password')" autocomplete="current-password">

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="check-box left-side">
                                        <span>
                                            <input type="checkbox" name="remember_me" id="remember_me" class="checkbox">
                                            <label for="remember_me">Remember Me</label>
                                        </span>
                                    </div>
                                    <button name="submit" type="submit" class="btn-color right-side">Log In</button>
                                </div>
                                <div class="col-12">
                                    @if (Route::has('password.request'))
                                    <a title="Forgot Password" class="forgot-password mtb-20" href="{{ route('password.request') }}">Forgot your password?</a>
                                    @endif
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="new-account align-center mt-20"> <span>New to REEHA PERFUMES</span> <a class="link" title="Register with Shopholic" href="register.html">Create New Account</a> </div>
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