@extends('auth.body.header')
@section('title', 'Register')
@section('content')
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
                                    <form method="POST" action="{{ route('register') }}" class="my-4">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input class="form-control" name="name" type="text" id="name" required=""
                                                placeholder="Name eingeben">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">E-Mail-Adresse</label>
                                            <input class="form-control" type="email" id="email" name="email" required=""
                                                placeholder="E-Mail-Adresse eingeben">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">Passwort</label>
                                            <input class="form-control" type="password" required="" id="password"
                                                name="password" placeholder="Passwort eingeben">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password_confirmation" class="form-label">Passwort
                                                bestätigen</label>
                                            <input class="form-control" type="password" required=""
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Passwort nochmals eingeben">
                                        </div>

                                        <div class="form-group mb-0 mt-5">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="bi bi-send"></i> Registrieren</button>
                                        </div>
                                    </form>

                                    <hr class="my-4" />

                                    <div class="text-center text-muted mb-4">
                                        <p class="mb-0">Haben Sie bereits ein Konto?<a class='text-primary ms-2 fw-medium'
                                                href={{ route('login') }}>Anmelden</a></p>
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
                                <img src="{{ asset('backend/assets/images/undraw_sign-up_z2ku.svg') }}" alt="images"
                                    class="class=" mx-auto img-fluid"">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection