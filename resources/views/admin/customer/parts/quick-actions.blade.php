<div class="card mb-6">
    <div class="card-body">
        <h2 class="card-title mb-4">{{ __('Quick Actions') }}</h2>
        <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-neutral w-full">
            <span class="icon icon-sm icon-edit me-2"></span>
            {{ __('Edit Customer') }}
        </a>
        <a href="mailto:{{ $customer->email }}" class="btn btn-outline w-full">
            <span class="icon icon-sm icon-mail me-2"></span>
            {{ __('Send Email') }}
        </a>
    </div>
</div>