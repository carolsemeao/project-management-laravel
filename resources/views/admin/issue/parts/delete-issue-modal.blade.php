<div class="modal fade" id="confirm-issue-deletion" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Delete Issue') }}</h5>
                <button type="button" class="btn-close" furtherActions="data-bs-dismiss=modal"></button>
            </div>
            <form id="deleteIssueForm" action="{{ route('admin.issues.destroy', $issue->id) }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to delete this issue?') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Once this issue is deleted, all of its data will be permanently deleted.') }}
                    </p>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <x-button-primary btnType="outline-secondary" furtherActions="type=button data-bs-dismiss=modal">{{ __('Cancel')
                        }}</x-button-primary>
                    <x-button-primary btnType="dark" furtherActions="type=submit">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="deleteIssueSpinner"></span>
                        {{ __('Delete Issue') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</div>