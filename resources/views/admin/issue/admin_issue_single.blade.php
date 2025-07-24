@extends('admin.issue.admin_issue_single_template')
@section('title', 'Issue Details')
@section('page_title', $issue->issue_title)
@section('back_to_route', route('admin.issues'))
@section('back_to_text', __('Back to Issues'))
@section('header_actions')
    <div class="btn-group">
        <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center"
            furtherActions="data-bs-toggle=modal data-bs-target=#logTimeModal">
            <i data-feather="plus" class="me-2" style="width: 16px; height: 16px;"></i>
            {{ __('Log Time') }}
        </x-button-primary>
        <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center" isLink=true
            href="{{ route('admin.issues.edit', $issue->id) }}">
            <i data-feather="edit" class="me-2" style="width: 16px; height: 16px;"></i>
            {{ __('Edit Issue') }}
        </x-button-primary>
    </div>
@endsection

@section('maincontent')
    <div class="row g-4">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <!-- Issue Details Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title h5 mb-4">{{ __('Issue Details') }}</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Project') }}</strong>
                                <p class="mb-0 mt-1 d-flex align-items-center">
                                    @if($issue->project)
                                        <span class="me-2 rounded-circle d-inline-block"
                                            style="width: 10px; height: 10px; background-color: {{ $issue->project->color }};"></span>
                                        <span>{{ $issue->project->name }}</span>
                                    @else
                                        <span class="text-muted">{{ __('No project assigned') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Priority') }}</strong>
                                <p class="mb-0 mt-1">
                                    <x-priority_badge :priority="$issue->priority->name" />
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Assignee') }}</strong>
                                <p class="mb-0 mt-1">
                                    <i data-feather="user" class="me-1" style="width: 16px; height: 16px;"></i>
                                    @if($issue->assignedUser)
                                        {{ $issue->assignedUser->name }}
                                        <small class="text-muted">({{ $issue->assignedUser->email }})</small>
                                    @elseif($issue->issue_assigned_to)
                                        {{ $issue->issue_assigned_to }} <small class="text-muted">(legacy)</small>
                                    @else
                                        <span class="text-muted">{{ __('Not assigned') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Due Date') }}</strong>
                                <p class="mb-0 mt-1">
                                    <i data-feather="calendar" class="me-1" style="width: 16px; height: 16px;"></i>
                                    {{ $issue->issue_due_date ? $issue->issue_due_date->format('d/m/Y') : __('Not set') }}
                                    @if($issue->issue_due_date && $issue->issue_due_date->isPast())
                                        <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1" />
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Created') }}</strong>
                                <p class="mb-0 mt-1">
                                    <i data-feather="calendar" class="me-1" style="width: 16px; height: 16px;"></i>
                                    {{ $issue->created_at->format('d/m/Y') }}
                                    @if($issue->createdByUser)
                                        {{ __('by :createdByUser', ['createdByUser' => $issue->createdByUser->name]) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Status') }}</strong>
                                <p class="mb-0 mt-1">
                                    <x-badge :label="Str::title(str_replace('_', ' ', $issue->status->name))" />
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($issue->issue_description)
                        <hr class="my-4">
                        <div>
                            <strong class="text-muted small">{{ __('Description') }}</strong>
                            <p class="mt-2 mb-0">{{ $issue->issue_description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Time Tracking Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">{{ __('Time Tracking') }}</h5>
                        @if(auth()->user()->hasPermission('can_assign_issues') || $issue->assigned_to_user_id === auth()->id() || $issue->created_by_user_id === auth()->id())
                            <x-button-primary btnType="outline-primary" classes="btn-sm"
                                furtherActions="data-bs-toggle=modal data-bs-target=#estimateModal">
                                <i data-feather="clock" class="me-1" style="width: 14px; height: 14px;"></i>
                                {{ $issue->estimated_time_minutes ? __('Update Estimate') : __('Set Estimate') }}
                            </x-button-primary>
                        @endif
                    </div>

                    @if($issue->estimated_time_minutes || $issue->getTotalLoggedTimeMinutes() > 0)
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i data-feather="clock" class="me-2" style="width: 20px; height: 20px;"></i>
                                <div>
                                    <strong id="logged-time-display">{{ $issue->formatted_logged_time ?: '0m' }}</strong>
                                    @if($issue->estimated_time_minutes)
                                        <span class="text-muted">of {{ $issue->formatted_estimated_time }} estimated</span>
                                    @endif
                                </div>
                            </div>

                            @if($issue->estimated_time_minutes)
                                @php $timeStatus = $issue->getTimeTrackingStatus(); @endphp
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted">{{ $timeStatus['percentage'] }}% completed</small>
                                    </div>
                                    <div class="progress" style="height: 8px;" id="time-progress">
                                        <div class="progress-bar bg-dark" role="progressbar"
                                            style="width: {{ min($timeStatus['percentage'], 100) }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-3">{{ __('No time tracking data yet') }}</p>
                    @endif

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">{{ __('Recent Time Entries') }}</h6>
                    </div>

                    <div id="time-entries-container">
                        @if($issue->timeEntries()->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th>{{ __('Time') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="time-entries-table">
                                        @foreach($issue->timeEntries()->with('user')->get() as $entry)
                                            <tr>
                                                <td>
                                                    <i data-feather="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                                                    {{ $entry->work_date->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $entry->user->name }}</td>
                                                <td>{{ $entry->description ?: __('No description') }}</td>
                                                <td><x-badge :label="$entry->formatted_time" /></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i data-feather="clock" class="mb-2" style="width: 24px; height: 24px;"></i>
                                <p class="mb-0 small">{{ __('No time entries yet') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Log Time Modal -->
            <div class="modal fade" id="logTimeModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Log Time') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form id="logTimeForm">
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
                                        value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="time_description" class="form-label">{{ __('Description') }}</label>
                                    <textarea class="form-control" id="time_description" name="description" rows="3"
                                        placeholder="{{ __('What did you work on?') }}"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <x-button-primary btnType="outline-secondary" classes="w-100"
                                    furtherActions="data-bs-dismiss=modal">{{ __('Cancel') }}</x-button-primary>
                                <x-button-primary btnType="primary" classes="w-100">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="logTimeSpinner"></span>
                                    {{ __('Log Time') }}
                                </x-button-primary>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Set Estimate Modal -->
            <div class="modal fade" id="estimateModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Set Time Estimate') }}</h5>
                            <button type="button" class="btn-close" furtherActions="data-bs-dismiss=modal"></button>
                        </div>
                        <form id="estimateForm">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="estimated_time" class="form-label">{{ __('Estimated Time') }}</label>
                                    <input type="text" class="form-control" id="estimated_time" name="estimated_time"
                                        placeholder="e.g., 8h, 2d, 1h 30m" value="{{ $issue->formatted_estimated_time }}"
                                        required>
                                    <div class="form-text">
                                        {{ __('Supported formats: 8h, 2d (days), 1h 30m, 480m') }}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <x-button-primary btnType="outline-secondary" classes="w-100"
                                    furtherActions="data-bs-dismiss=modal">{{ __('Cancel') }}</x-button-primary>
                                <x-button-primary btnType="primary" classes="w-100">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="estimateSpinner"></span>
                                    {{ __('Set Estimate') }}
                                </x-button-primary>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ __('Quick Actions') }}</h5>
                    <div class="d-grid gap-2">
                        <x-button-primary btnType="outline-secondary"
                            classes="d-flex align-items-center justify-content-center">
                            <i data-feather="trash" class="me-2" style="width: 16px; height: 16px;"></i>
                            {{ __('Delete Issue') }}
                        </x-button-primary>
                        <x-button-primary btnType="dark" classes="w-100">
                            {{ __('Close Issue') }}
                        </x-button-primary>
                    </div>
                </div>
            </div>

            <!-- Assignment Card -->
            {{-- @if(auth()->user()->hasPermission('can_assign_issues'))
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ __('Assignment') }}</h5>
                    <form id="assignmentForm">
                        @csrf
                        <div class="mb-3">
                            <label for="assigned_to_user_id" class="form-label small">{{ __('Assignee') }}</label>
                            <select class="form-select form-select-sm" id="assigned_to_user_id" name="assigned_to_user_id">
                                <option value="">{{ __('Unassigned') }}</option>
                                @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ $issue->assigned_to_user_id == $user->id ? 'selected' :
                                    '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <x-button-primary btnType="outline-primary" classes="btn-sm w-100">
                            <i data-feather="user-check" class="me-1" style="width: 14px; height: 14px;"></i>
                            {{ __('Update Assignment') }}
                        </x-button-primary>
                    </form>
                </div>
            </div>
            @endif --}}

            <!-- Project Information Card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ __('Project Information') }}</h5>

                    @if($issue->project)
                        <div class="mb-3">
                            <strong class="text-muted small">{{ __('Project Name') }}</strong>
                            <p class="mb-0 mt-1 d-flex align-items-center">
                                <span class="me-2 rounded-circle d-inline-block"
                                    style="width: 10px; height: 10px; background-color: {{ $issue->project->color }};"></span>
                                <span>{{ $issue->project->name }}</span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <strong class="text-muted small">{{ __('Status') }}</strong>
                            <p class="mb-0 mt-1">
                                <x-badge :label="ucfirst($issue->project->status)"
                                    textColor="text-{{ $issue->project->status === 'active' ? 'success' : ($issue->project->status === 'planning' ? 'warning' : 'secondary') }}" />
                            </p>
                        </div>

                        <div class="mb-3">
                            <strong class="text-muted small">{{ __('Priority') }}</strong>
                            <p class="mb-0 mt-1">
                                <x-badge :label="ucfirst($issue->project->priority)"
                                    textColor="text-{{ $issue->project->priority === 'urgent' ? 'danger' : ($issue->project->priority === 'high' ? 'warning' : 'secondary') }}" />
                            </p>
                        </div>

                        @if($issue->project->description)
                            <div class="mb-3">
                                <strong class="text-muted small">{{ __('Description') }}</strong>
                                <p class="mb-0 mt-1 small text-muted">{{ $issue->project->description }}</p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong class="text-muted small">{{ __('Progress') }}</strong>
                            <div class="mt-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">{{ $issue->project->getProgressPercentage() }}% complete</small>
                                    <small class="text-muted">{{ $issue->project->issues()->count() }} issues</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-dark" role="progressbar"
                                        style="width: {{ $issue->project->getProgressPercentage() }}%"></div>
                                </div>
                            </div>
                        </div>

                        @if($issue->project->budget)
                            <div class="mb-3">
                                <strong class="text-muted small">{{ __('Budget') }}</strong>
                                <p class="mb-0 mt-1">
                                    <i data-feather="dollar-sign" class="me-1" style="width: 14px; height: 14px;"></i>
                                    ${{ number_format($issue->project->budget, 0) }}
                                </p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong class="text-muted small">{{ __('Project Due Date') }}</strong>
                            <p class="mb-0 mt-1">
                                <i data-feather="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                                {{ $issue->project->due_date ? $issue->project->due_date->format('d/m/Y') : __('Not set') }}
                                @if($issue->project->isOverdue())
                                    <x-badge :label="__('Overdue')" textColor="text-danger" classes="ms-1 small" />
                                @elseif($issue->project->isDueSoon())
                                    <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1 small" />
                                @endif
                            </p>
                        </div>

                        <div class="mb-0">
                            <strong class="text-muted small">{{ __('Project Teams') }}</strong>
                            <div class="mt-1">
                                @foreach($issue->project->teams as $team)
                                    <x-badge :label="$team->name" classes="me-1 mb-1" />
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <i data-feather="folder" class="mb-2" style="width: 24px; height: 24px;"></i>
                            <p class="mb-0">{{ __('No project assigned to this issue') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Assignment form handling (simplified)
            const assignmentForm = document.getElementById('assignmentForm');

            // Handle assignment form submission
            if (assignmentForm) {
                assignmentForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const issueId = {{ $issue->id }};

                    fetch(`/admin/issues/${issueId}/assignment`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            assigned_to_user_id: formData.get('assigned_to_user_id') || null
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Assignment updated successfully', 'success');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showToast(data.message || 'Failed to update assignment', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error updating assignment:', error);
                            showToast('An error occurred while updating assignment', 'error');
                        });
                });
            }

            // Time tracking functionality
            const logTimeForm = document.getElementById('logTimeForm');
            const estimateForm = document.getElementById('estimateForm');

            // Handle log time form submission
            if (logTimeForm) {
                logTimeForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const issueId = {{ $issue->id }};
                    const spinner = document.getElementById('logTimeSpinner');

                    spinner.classList.remove('d-none');

                    fetch(`/admin/issues/${issueId}/time`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            spinner.classList.add('d-none');

                            if (data.success) {
                                showToast('Time logged successfully', 'success');

                                // Update UI with new time data
                                updateTimeDisplay(data.issue_progress);

                                // Reset form
                                logTimeForm.reset();
                                document.getElementById('work_date').value = new Date().toISOString().split('T')[0];

                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById('logTimeModal'));
                                modal.hide();

                                // Refresh time entries
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showToast(data.message || 'Failed to log time', 'error');
                            }
                        })
                        .catch(error => {
                            spinner.classList.add('d-none');
                            console.error('Error logging time:', error);
                            showToast('An error occurred while logging time', 'error');
                        });
                });
            }

            // Handle estimate form submission
            if (estimateForm) {
                estimateForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const issueId = {{ $issue->id }};
                    const spinner = document.getElementById('estimateSpinner');

                    spinner.classList.remove('d-none');

                    fetch(`/admin/issues/${issueId}/estimate`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            estimated_time: formData.get('estimated_time')
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            spinner.classList.add('d-none');

                            if (data.success) {
                                showToast('Estimate updated successfully', 'success');

                                // Update UI with new estimate data
                                updateTimeDisplay(data.issue_progress);

                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById('estimateModal'));
                                modal.hide();

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showToast(data.message || 'Failed to set estimate', 'error');
                            }
                        })
                        .catch(error => {
                            spinner.classList.add('d-none');
                            console.error('Error setting estimate:', error);
                            showToast('An error occurred while setting estimate', 'error');
                        });
                });
            }

            // Update time display function
            function updateTimeDisplay(progressData) {
                const loggedTimeDisplay = document.getElementById('logged-time-display');
                const timeProgress = document.getElementById('time-progress');

                if (loggedTimeDisplay && progressData.logged_time) {
                    loggedTimeDisplay.textContent = progressData.logged_time;
                }

                if (timeProgress && progressData.percentage !== undefined) {
                    const progressBar = timeProgress.querySelector('.progress-bar');
                    if (progressBar) {
                        progressBar.style.width = Math.min(progressData.percentage, 100) + '%';

                        // Keep progress bar black
                        progressBar.className = 'progress-bar bg-dark';
                    }
                }
            }

            // Toast function (existing)
            /* function showToast(message, type = 'info') {
                let toastContainer = document.querySelector('.toast-container');
                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                    document.body.appendChild(toastContainer);
                }

                const toastHtml = `
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body d-flex justify-content-between align-items-center bg-${type === 'success' ? 'success' : 'danger'} text-white">
                            <span>${message}</span>
                            <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;

                toastContainer.insertAdjacentHTML('beforeend', toastHtml);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    const toast = toastContainer.lastElementChild;
                    if (toast) {
                        toast.remove();
                    }
                }, 3000);
            } */
        });
    </script>
@endsection