<div class="modal fade" id="confirm-project-delete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Delete Project') }}</h5>
                <button type="button" class="btn-close" furtherActions="data-bs-dismiss=modal"></button>
            </div>
            <form id="deleteProjectForm" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to delete this project?') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Once this project is deleted, all of its data will be permanently deleted.') }}
                    </p>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <x-button-primary btnType="outline-secondary" furtherActions="type=button data-bs-dismiss=modal">{{ __('Cancel')
                        }}</x-button-primary>
                    <x-button-primary btnType="dark" furtherActions="type=submit">
                        {{ __('Delete') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</div>