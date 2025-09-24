<div class="fixed bottom-4 right-4 z-50">
    @if(Session::has('message'))
        @php
            $alertType = Session::get('alert-type', 'primary');
            $alertClasses = [
                'primary' => 'alert-info',
                'success' => 'alert-success',
                'warning' => 'alert-warning',
                'danger' => 'alert-error',
                'error' => 'alert-error'
            ];
            $alertClass = $alertClasses[$alertType] ?? 'alert-info';
        @endphp
        <div class="toast show alert {{ $alertClass }}" role="alert" aria-live="assertive" aria-atomic="true"
            data-delay="5000">
            <span>{{ Session::get('message') }}</span>
            <button type="button" class="toast-close btn btn-sm btn-circle btn-ghost ml-auto" aria-label="Close">
                ✕
            </button>
        </div>
    @endif
</div>