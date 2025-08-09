<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title mb-3">{{ __('Quick Actions') }}</h5>
        <div class="d-grid gap-2">
            <x-button-primary btnType="outline-secondary" classes="d-flex align-items-center justify-content-center"
                furtherActions="data-bs-toggle=modal data-bs-target=#confirm-issue-deletion type=button">
                <span class="icon icon-sm icon-trash me-2"></span>
                {{ __('Delete Issue') }}
            </x-button-primary>
            <x-button-primary btnType="dark" classes="w-100"
                furtherActions="data-bs-toggle=modal data-bs-target=#confirm-issue-close type=button">
                {{ __('Close Issue') }}
            </x-button-primary>
        </div>
    </div>
</div>