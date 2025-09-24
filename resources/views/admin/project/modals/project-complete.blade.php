<dialog id="confirm-project-complete" class="modal">
    <div class="modal-box">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">{{ __('Complete Project') }}</h3>
            <button type="button" class="btn btn-sm btn-circle btn-ghost"
                onclick="document.getElementById('confirm-project-complete').close()">✕</button>
        </div>

        <form id="completeProjectForm" action="{{ route('admin.projects.complete', $project->id) }}" method="POST">
            @method('POST')
            @csrf
            <div class="py-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to mark this project as completed?') }}
                </h2>
            </div>
            <div class="modal-action">
                <x-button-primary btnType="outline-secondary"
                    furtherActions="type=button onclick=document.getElementById('confirm-project-complete').close()">{{ __('Cancel') }}</x-button-primary>
                <x-button-primary btnType="dark" furtherActions="type=submit">
                    {{ __('Confirm') }}
                </x-button-primary>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>