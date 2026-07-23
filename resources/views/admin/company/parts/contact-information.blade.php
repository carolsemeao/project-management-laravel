<div class="card mb-6">
    <div class="card-body">
        <h2 class="card-title mb-4">{{ __('Contact Information') }}</h2>

        <div class="grid md:grid-cols-2 gap-x-3 gap-y-5">
            <div class="flex items-start gap-2">
                <i class="icon icon-sm icon-mail"></i>
                <div class="info-box">
                    <p class="font-medium opacity-70 mb-1">{{ __('Email') }}</p>
                    <span>{{ $company->email }}</span>
                </div>
            </div>
            <div class="flex items-start gap-2">
                <i class="icon icon-sm icon-globe"></i>
                <div class="info-box">
                    <p class="font-medium opacity-70 mb-1">{{ __('Website') }}</p>
                    <span>{{ $company->website ?? '-' }}</span>
                </div>
            </div>
            <div class="flex items-start gap-2">
                <i class="icon icon-sm icon-phone"></i>
                <div class="info-box">
                    <p class="font-medium opacity-70 mb-1">{{ __('Phone') }}</p>
                    <span>{{ $company->phone ?? '-' }}</span>
                </div>
            </div>
            <div class="flex items-start gap-2">
                <i class="icon icon-sm icon-buildings"></i>
                <div class="info-box">
                    <p class="font-medium opacity-70 mb-1">{{ __('Address') }}</p>
                    <address class="not-italic">
                        {{ $company->address }}<br>
                        {{ $company->zip }}
                        {{ $company->city }}{{ $company->state ? ", $company->state" : '' }}<br>
                        {{ $company->country }}
                    </address>
                </div>
            </div>
        </div>
    </div>
</div>