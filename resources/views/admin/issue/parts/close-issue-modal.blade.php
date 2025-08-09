<div class="modal fade" id="confirm-issue-close" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Close Issue') }}</h5>
                <button type="button" class="btn-close" furtherActions="data-bs-dismiss=modal"></button>
            </div>
            <form id="deleteIssueForm" action="{{ route('admin.issues.close', $issue->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to close this issue?') }}
                    </h2>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <x-button-primary btnType="outline-secondary" furtherActions="type=button data-bs-dismiss=modal">{{ __('Cancel')
                        }}</x-button-primary>
                    <x-button-primary btnType="dark" furtherActions="type=submit"
                        classes="d-flex align-items-center justify-content-center">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="deleteIssueSpinner"></span>
                        <span class="icon icon-sm icon-x me-2"></span>
                        {{ __('Confirm') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</div>