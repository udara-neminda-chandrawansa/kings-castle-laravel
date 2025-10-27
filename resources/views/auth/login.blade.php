@extends('layouts.auth')

@section('content')
    <div class="authincation fix-wrapper">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="mb-4 text-center">Sign in to your account</h4>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Email</label>
                                            <input type="email" name="email" type="email" placeholder="Email Address" value="{{ old('email') }}" class="form-control">
                                        </div>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" name="password" id="password" placeholder="Password" required class="form-control" value="123456">
                                            <span class="show-pass eye" id="togglePassword">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                        </div>
                                    </form>
                                    {{-- <div class="mt-3 new-account">
                                        <p>Don't have an account? <a class="text-primary" href="/register">Sign Up</a></p>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection