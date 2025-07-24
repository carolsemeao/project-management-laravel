@extends('auth.body.header')
@section('title', 'Login')
@section('content')
    <!-- Begin page -->
    <div class="account-page vh-100">
        <div class="container-fluid p-0 h-100">
            <div class="row align-items-center g-0 h-100">
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="mb-0 border-0 p-md-5 p-lg-0 p-4">
                                <div class="mb-4 p-0">
                                    <a href="index.html" class="auth-logo h2">
                                        <i class="bi bi-alarm"></i> <!-- TODO: Logo here -->
                                    </a>
                                </div>

                                <div class="pt-0">
                                    <form method="POST" action="{{ route('login') }}" class="my-4">
                                        @csrf

                                        @if(session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <div class="form-group mb-3">
                                            <label for="emailaddress" class="form-label">E-Mail-Adresse</label>
                                            <input class="form-control" type="email" id="email" name="email" required=""
                                                placeholder="E-Mail-Adresse eingeben">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">Passwort</label>
                                            <input class="form-control" type="password" required="" id="password"
                                                name="password" placeholder="Passwort eingeben">
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group d-flex mb-3">
                                            <a class='text-muted fs-14' href={{ route('password.request') }}>Passwort
                                                vergessen?</a>
                                        </div>

                                        <div class="form-group mb-0 mt-5">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="bi bi-send"></i> Anmelden</button>
                                        </div>
                                    </form>
                                    <hr class="my-4" />

                                    <div class="text-center text-muted mb-4">
                                        <p class="mb-0">Haben Sie noch kein Konto?<a class='text-primary ms-2 fw-medium'
                                                href="{{ route('register') }}">Registrieren</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="account-page-bg p-md-5 p-4">
                        <div class="text-center">
                            <div class="auth-image">
                                <img src="{{ asset('backend/assets/images/undraw_authentication_tbfc.svg') }}" alt="images"
                                    class="mx-auto img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection