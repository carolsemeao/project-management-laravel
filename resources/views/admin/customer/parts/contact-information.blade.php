<div class="card mb-6">
    <div class="card-body">
        <h2 class="card-title mb-4">{{ __('Contact Information') }}</h2>

        <div class="grid md:grid-cols-2 gap-x-3 gap-y-5">
            <div class="flex items-start gap-2">
                <i class="icon icon-sm icon-mail"></i>
                <div class="info-box">
                    <p class="font-medium opacity-70 mb-1">{{ __('Email') }}</p>
                    <span>{{ $customer->email }}</span>
                </div>
            </div>
            <div class="flex items-start gap-2">
                <i class="icon icon-sm icon-buildings"></i>
                <div class="info-box">
                    <p class="font-medium opacity-70 mb-1">{{ __('Company') }}</p>
                    <span>{{ $customer->company->name }}</span>
                </div>
            </div>
            <div class="flex items-start gap-2">
                <i class="icon icon-sm icon-phone"></i>
                <div class="info-box">
                    <p class="font-medium opacity-70 mb-1">{{ __('Phone') }}</p>
                    <span>{{ $customer->phone ?? '-' }}</span>
                </div>
            </div>
            <div class="flex items-start gap-2">
                <i class="icon icon-sm icon-buildings"></i>
                <div class="info-box">
                    <p class="font-medium opacity-70 mb-1">{{ __('Address') }}</p>
                    <address class="not-italic">
                        {{ $customer->address }}<br>
                        {{ $customer->zip }}
                        {{ $customer->city }}{{ $customer->state ? ", $customer->state" : '' }}<br>
                        {{ $customer->country }}
                    </address>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="flex items-start gap-2">
            <i class="icon icon-sm icon-file-text"></i>
            <div class="info-box">
                <p class="font-medium opacity-70 mb-1">{{ __('Notes') }}</p>
                <p>{{ $customer->notes ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>