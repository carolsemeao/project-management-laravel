@extends('auth.auth_master')
@section('title', 'Neuen Account erstellen')
@section('content')
    <main class="main-content max-w-[100rem] w-full mx-auto py-15 grow flex items-center" id="mainContent">
        <div class="content grid grid-cols-1 md:grid-cols-2 gap-x-20 items-center w-full">
            <div>
                <h1 class="text-3xl font-bold">{{ __('Neuen Account erstellen') }}</h1>
                <form method="POST" action="{{ route('register') }}" class="my-4">
                    @csrf

                    @if(session('error'))
                        <div role="alert" class="alert alert-error">
                            <span class="icon icon-sm icon-alert-triangle"></span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label class="input validator" for="name">
                            <span class="icon icon-sm icon-user"></span>
                            <input type="text" placeholder="Name eingeben" id="name" name="name" required />
                        </label>
                        @error('name')
                            <div class="validator-hint hidden">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="input validator" for="email">
                            <span class="icon icon-sm icon-mail"></span>
                            <input type="email" placeholder="E-Mail-Adresse eingeben" id="email" name="email" required />
                        </label>
                        @error('email')
                            <div class="validator-hint hidden">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="input validator" for="password">
                            <span class="icon icon-sm icon-key"></span>
                            <input type="password" required name="password" id="password" placeholder="Passwort eingeben" minlength="8" />
                        </label>
                        @error('password')
                            <div class="validator-hint hidden">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="input" for="password_confirmation">
                            <span class="icon icon-sm icon-key"></span>
                            <input type="password" required name="password_confirmation" id="password_confirmation" placeholder="Passwort nochmals eingeben" minlength="8" />
                        </label>
                    </div>

                    <div class="form-group mb-0 mt-5">
                        <button class="btn btn-primary" type="submit">
                            {{ __('Registrieren') }}
                            <span class="icon icon-sm icon-arrow-right"></span>
                        </button>
                    </div>
                </form>

                <div class="divider"></div>

                <p class="mt-4">{{ __('Haben Sie bereits ein Konto?') }} <a class='link link-secondary'
                    href={{ route('login') }}>{{ __('Anmelden') }}</a></p>
            </div>

            <img src="{{ asset('backend/assets/images/undraw_sign-up_z2ku.svg') }}" alt="image"
                class="mx-auto img-fluid max-w-[30rem]" id="theme-image">
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateImage = () => {
                const img = document.querySelector('#theme-image');
                if (!img) return;

                const isDark = (localStorage.getItem('theme') || 'valentine') !== 'valentine';
                img.src = "{{ asset('backend/assets/images/undraw_sign-up_z2ku') }}" + (isDark ? '-dark' : '') + ".svg";
            };

            updateImage();

            // Listen for storage changes, theme clicks, and data-theme mutations
            window.addEventListener('storage', e => e.key === 'theme' && updateImage());
            document.addEventListener('click', e =>
                (e.target.classList.contains('theme-controller') || e.target.closest('.theme-controller')) &&
                setTimeout(updateImage, 100)
            );
            new MutationObserver(mutations =>
                mutations.some(m => m.type === 'attributes' && m.attributeName === 'data-theme') && updateImage()
            ).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
        });
    </script>
@endpush