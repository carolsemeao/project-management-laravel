<dialog id="confirm-project-delete" class="modal">
    <div class="modal-box">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">{{ __('Delete Project') }}</h3>
            <button type="button" class="btn btn-sm btn-circle btn-ghost"
                onclick="document.getElementById('confirm-project-delete').close()">✕</button>
        </div>

        <form id="deleteProjectForm" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <div class="py-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete this project?') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once this project is deleted, all of its data will be permanently deleted.') }}
                </p>
            </div>
            <div class="modal-action">
                <x-button-primary btnType="outline-secondary"
                    furtherActions="type=button onclick=document.getElementById('confirm-project-delete').close()">{{ __('Cancel') }}</x-button-primary>
                <x-button-primary btnType="danger" furtherActions="type=submit">
                    {{ __('Delete') }}
                </x-button-primary>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>