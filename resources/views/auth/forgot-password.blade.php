@extends('auth.auth_master')
@section('title', 'Passwort vergessen')
@section('content')
    <main class="main-content max-w-[100rem] w-full mx-auto py-15 grow flex items-center" id="mainContent">
        <div class="content grid grid-cols-1 md:grid-cols-2 gap-x-5 items-center w-full">
            <div>
                <a href="{{ route('login') }}" class="link link-secondary">
                    <span class="icon icon-sm icon-arrow-left"></span>
                    {{ __('Zurück') }}
                </a>
                <h1 class="text-3xl font-bold mb-3 mt-6">{{ __('Passwort vergessen?') }}</h1>
                <p>{{ __('Passwort vergessen? Kein Problem. Teilen Sie uns einfach Ihre E-Mail-Adresse mit und wir senden Ihnen einen Link zum Zurücksetzen Ihres Passworts zu, über den Sie ein neues Passwort festlegen können.') }}
                </p>

                <form method="POST" action="{{ route('password.email') }}" class="my-8">
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
                            <input type="email" placeholder="E-Mail-Adresse eingeben" id="email" name="email" required
                                value="{{ old('email') }}" autofocus />
                        </label>
                        @error('email')
                            <div class="validator-hint hidden">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-0 mt-5">
                        <button class="btn btn-primary" type="submit">
                            {{ __('Bestätigen') }}
                            <span class="icon icon-sm icon-arrow-right"></span>
                        </button>
                    </div>
                </form>
            </div>

            <img src="{{ asset('backend/assets/images/undraw_forgot-password_nttj.svg') }}" alt="image"
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