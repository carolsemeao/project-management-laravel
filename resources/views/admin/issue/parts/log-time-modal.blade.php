<div class="modal fade" id="logTimeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Log Time') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="logTimeForm" action="{{ route('admin.issues.log-time', $issue->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="time_input" class="form-label">{{ __('Time Spent') }}</label>
                        <input type="text" class="form-control" id="time_input" name="time_input"
                            placeholder="e.g., 1h 30m, 90m, 1.5h" required>
                        <div class="form-text">
                            {{ __('Supported formats: 1h 30m, 90m, 1.5h, 1:30') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="work_date" class="form-label">{{ __('Work Date') }}</label>
                        <input type="date" class="form-control" id="work_date" name="work_date"
                            value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="time_description" class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control" id="time_description" name="description" rows="3"
                            placeholder="{{ __('What did you work on?') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <x-button-primary btnType="outline-secondary"
                        furtherActions="data-bs-dismiss=modal type=button">{{ __('Cancel') }}</x-button-primary>
                    <x-button-primary btnType="dark" furtherActions="type=submit">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="logTimeSpinner"></span>
                        {{ __('Log Time') }}
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</div>