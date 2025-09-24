<dialog id="confirm-project-hold" class="modal">
    <div class="modal-box">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">{{ __('Put Project on Hold') }}</h3>
            <button type="button" class="btn btn-sm btn-circle btn-ghost"
                onclick="document.getElementById('confirm-project-hold').close()">✕</button>
        </div>

        <form id="projectOnHoldForm" action="{{ route('admin.projects.hold', $project->id) }}" method="POST">
            @method('POST')
            @csrf
            <div class="py-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to put this project on hold?') }}
                </h2>
            </div>
            <div class="modal-action">
                <x-button-primary btnType="outline-secondary"
                    furtherActions="type=button onclick=document.getElementById('confirm-project-hold').close()">{{ __('Cancel') }}</x-button-primary>
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