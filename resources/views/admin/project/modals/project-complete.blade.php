<div class="modal fade" id="confirm-project-complete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Complete Project') }}</h5>
                <button type="button" class="btn-close" furtherActions="data-bs-dismiss=modal"></button>
            </div>
            <form id="completeProjectForm" action="{{ route('admin.projects.complete', $project->id) }}" method="POST">
                @method('POST')
                @csrf
                <div class="modal-body">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to mark this project as completed?') }}
                    </h2>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <x-button-primary btnType="outline-secondary" furtherActions="type=button data-bs-dismiss=modal">{{ __('Cancel')
                        }}</x-button-primary>
                    <x-button-primary btnType="dark" furtherActions="type=submit">
                        {{ __('Confirm') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</div>