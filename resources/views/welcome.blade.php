@extends('layouts.authentication.master')
@section('title', 'Welcome!')
@section('content')
<!-- Content -->

<div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0">

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
            <div class="w-px-400 mx-auto text-center justify-content-center">
                <!-- Logo -->
                <div class="app-brand justify-content-center mb-4">
                    <a href="https://jgu.ac.id/" target="_blank" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                            <img src="{{asset('assets/img/jgu.png')}}" width="150">
                        </span>
                    </a>
                </div>
                <!-- /Logo -->
                <p class="mb-2">Selamat Datang Pada Sistem</p>
                <h4 class="mb-3">Rekognisi Pembelajaran Lampau (RPL)</h4>
                <br>
                @if (Route::has('login'))
                @auth
                <a href="{{ route('home') }}" class="btn btn-primary text-white text-center w-50"><i
                        class="bx bx-home me-2"></i>Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary text-white text-center w-50"><i
                        class="bx bx-log-in-circle me-2"></i>Log in</a>
                <!-- @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-success text-white text-center w-50 mt-2"><i class="bx bx-edit me-2"></i>Daftar</a>
                    @endif -->
                @endauth
                @endif
                <br><br>
                <div class="divider mt-4">
                    <div class="divider-text">© 2022</div>
                </div>
                <div class="">
                    <span class="mr-2">Dikembangkan oleh </span>
                    <a href="https://itic.jgu.ac.id/" target="_blank" class="footer-link fw-bolder ml-2">ITIC JGU</a>
                </div>
                <small class="ml-4 text-center text-sm text-light sm:text-right sm:ml-0">
                    v{{ Illuminate\Foundation\Application::VERSION }} (v{{ PHP_VERSION }})
                </small>
            </div>
        </div>
        <!-- /Login -->
        <!-- /Left Text -->
        <!-- <div class=" col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="{{asset('assets/img/rplnew.jpg')}}" class="img-fluid" alt="Login image"
                    width="700" data-app-dark-img="{{asset('assets/img/rplnew.jpg')}}"
                    data-app-light-img="{{asset('assets/img/rplnew.jpg')}}">
            </div>
        </div> -->
        <!-- /Left Text -->

    </div>
</div>

<!-- / Content -->
@endsection
