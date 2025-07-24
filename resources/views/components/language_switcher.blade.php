<div class="d-flex justify-content-center pt-8 sm:justify-start sm:pt-0">
    @foreach ($available_locales as $locale_name => $available_locale)
        @if ($available_locale === $current_locale)
            <span class="ml-2 mr-2 text-muted">{{ $locale_name }}</span>
        @else
            <a href="{{ url('/language/' . $available_locale) }}" class="underline ml-2 mr-2">
                <span>{{ $locale_name }}</span>
            </a>
        @endif
    @endforeach
</div>