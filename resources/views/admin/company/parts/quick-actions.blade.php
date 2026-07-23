<div class="card mb-6">
    <div class="card-body">
        <h2 class="card-title mb-4">{{ __('Quick Actions') }}</h2>
        <a href="{{ route('admin.company.edit', $company->id) }}" class="btn btn-neutral w-full">
            <span class="icon icon-sm icon-edit me-2"></span>
            {{ __('Edit Company') }}
        </a>
        <a href="mailto:{{ $company->email }}" class="btn btn-outline w-full">
            <span class="icon icon-sm icon-mail me-2"></span>
            {{ __('Send Email') }}
        </a>
        @if ($company->phone)
            <a href="tel:{{ $company->phone }}" class="btn btn-outline w-full">
                <span class="icon icon-sm icon-phone me-2"></span>
                {{ __('Call Company') }}
            </a>
        @endif
    </div>
</div>