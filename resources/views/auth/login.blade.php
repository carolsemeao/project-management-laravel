@extends('auth.auth_master')
@section('title', __('Login'))
@section('content')
    <div>
        <h1 class="text-3xl font-bold">{{ __('Login') }}</h1>
        <form method="POST" action="{{ route('login') }}" class="my-4">
            @csrf

            @if(session('error'))
                <div role="alert" class="alert alert-error">
                    <span class="icon icon-sm icon-alert-triangle"></span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="form-group mb-3">
                <label class="input validator">
                    <span class="icon icon-sm icon-mail"></span>
                    <input type="email" placeholder="{{ __('Enter your email address') }}" id="email" name="email" autofocus
                        required />
                </label>
                @error('email')
                    <div class="validator-hint hidden">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label class="input validator" for="password">
                    <span class="icon icon-sm icon-key"></span>
                    <input type="password" required name="password" id="password"
                        placeholder="{{ __('Enter your password') }}" />
                </label>
                @error('password')
                    <div class="validator-hint hidden">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group d-flex mb-3">
                <a class="link text-sm link-hover" href={{ route('password.request') }}>{{ __('Forgot your password?') }}</a>
            </div>

            <div class="form-group mb-0 mt-5">
                <button class="btn btn-neutral" type="submit">
                    {{ __('Login') }}
                    <span class="icon icon-sm icon-arrow-right"></span>
                </button>
            </div>
        </form>

        <div class="divider"></div>

        <p class="mt-4 text-sm">{{ __('Don\'t have an account yet?') }} <a class='link link-primary'
                href="{{ route('register') }}">{{ __('Sign up') }}</a></p>
    </div>

    <img src="{{ asset('backend/assets/images/undraw_authentication_tbfc.svg') }}" alt="image"
        class="mx-auto img-fluid max-w-[30rem]" id="theme-image">
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateImage = () => {
                const img = document.querySelector('#theme-image');
                if (!img) return;

                const isDark = (localStorage.getItem('theme') || 'valentine') !== 'valentine';
                img.src = "{{ asset('backend/assets/images/undraw_authentication_tbfc') }}" + (isDark ? '-dark' : '') + ".svg";
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