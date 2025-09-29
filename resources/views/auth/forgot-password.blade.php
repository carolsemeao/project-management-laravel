@extends('auth.auth_master')
@section('title', __('Forgot your password?'))
@section('content')
    <div>
        <a href="{{ route('login') }}" class="btn btn-link px-0">
            <span class="icon icon-sm icon-arrow-left"></span>
            {{ __('Back') }}
        </a>
        <h1 class="text-3xl font-bold mb-3 mt-6">{{ __('Forgot your password?') }}</h1>
        <p>{{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>

        <form method="POST" action="{{ route('password.email') }}" class="my-8">
            @csrf

            @if(session('error'))
                <div role="alert" class="alert alert-error">
                    <span class="icon icon-sm icon-alert-triangle"></span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="join w-full">
                <label class="input validator join-item">
                    <span class="icon icon-sm icon-mail"></span>
                    <input type="email" placeholder="{{ __('Enter your email address') }}" id="email" name="email" required
                        value="{{ old('email') }}" autofocus />
                </label>
                @error('email')
                    <div class="validator-hint hidden">{{ $message }}</div>
                @enderror
                <button class="btn join-item btn-neutral" type="submit">
                    {{ __('Send reset link') }}
                    <span class="icon icon-sm icon-arrow-right"></span>
                </button>
            </div>
        </form>
    </div>

    <img src="{{ asset('backend/assets/images/undraw_forgot-password_nttj.svg') }}" alt="image"
        class="mx-auto img-fluid max-w-[30rem]" id="theme-image">
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateImage = () => {
                const img = document.querySelector('#theme-image');
                if (!img) return;

                const isDark = (localStorage.getItem('theme') || 'valentine') !== 'valentine';
                img.src = "{{ asset('backend/assets/images/undraw_forgot-password_nttj') }}" + (isDark ? '-dark' : '') + ".svg";
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