@extends('layouts.auth-layout')

@section('content')
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100 mx-5">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{asset('img/logo.png')}}"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-4 col-lg-4 col-xl-4 offset-xl-1">
                    <form method="POST" action="{{ route('login') }}" class="mx-5">
                        @csrf
                    
                        <div class="d-flex flex-column align-items-start my-4">
                            <p class="fw-bold mb-1">Welcome Back!</p>
                            <span class="text-muted">Login to your account by entering your email and password.</span>
                        </div>
                    
                        <!-- Email input -->
                        <div class="mb-4">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required />
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    
                        <!-- Password input -->
                        <div class="mb-4">
                            <label for="password" class="col-form-label">Password</label>
                            <input type="password" class="form-control" name="password" required />
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2025. All rights reserved.
            </div>
            <!-- Copyright -->

            <!-- Right -->
            <div>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#!" class="text-white">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
            <!-- Right -->
        </div>
    </section>
@endsection
