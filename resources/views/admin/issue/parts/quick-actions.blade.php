<div class="card">
    <div class="card-body">
        <h2 class="card-title mb-3">{{ __('Quick Actions') }}</h2>
        <button type="button" class="btn btn-outline w-full mb-2" data-modal-target="confirm-issue-deletion">
            <span class="icon icon-sm icon-trash me-2"></span>
            {{ __('Delete Issue') }}
        </button>
        <button type="button" class="btn btn-neutral w-full" data-modal-target="confirm-issue-close">
            {{ __('Close Issue') }}
        </button>
    </div>
</div>