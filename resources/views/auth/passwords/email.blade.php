@extends('frontend.layout.master')
@section('content')
<?php $pagetitle = "Login" ?>
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Reset Pawword</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Reset Password </span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!--breadcrumbs area end-->


<!-- customer login start -->

<section class="checkout-section ptb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8 col-md-8 ">
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
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" class="main-form full" action="{{ route('password.email') }}">
                            @csrf
                            <div class="col-12">
                                <div class="input-box">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn-color right-side">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection