<dialog id="{{ $modalId }}" class="modal">
    <div class="modal-box">
        <h2>{{ $title }}</h2>
        <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
            data-modal-close="{{ $modalId }}">
            <span class="icon icon-sm icon-x"></span>
        </button>

        <form id="{{ $formID }}" class="mt-4" action="{{ $action }}" method="{{ $method }}">
            @if ($methodType)
                @method($methodType)
            @endif
            @csrf
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="mt-4 flex justify-end items-center gap-3">
                <button class="btn btn-soft" type="button" data-modal-close="{{ $modalId }}">
                    {{ $cancelButtonText }}
                </button>
                <button class="btn btn-neutral" type="submit">
                    {{ $confirmButtonText }}
                </button>
            </div>
        </form>
    </div>
</dialog>