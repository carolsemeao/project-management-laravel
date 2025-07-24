@extends('admin.issue.admin_issue_single_template')
@section('title', 'Edit Issue #' . $issue->id)
@section('page_title', 'Edit Issue #' . $issue->id)
@section('page_subtitle', 'Update issue details and track progress')
@section('back_to_route', route('admin.issues.show', $issue->id))
@section('back_to_text', __('Back'))

@section('maincontent')
    <div class="row g-4">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <form action="{{ route('admin.issues.update', $issue->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Issue Information Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h5">{{ __('Issue Information') }}</h2>
                        <small class="text-muted d-block mb-4">{{ __('Basic details about the issue') }}</small>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="issue_title" class="form-label">{{ __('Issue Title *') }}</label>
                                <input type="text" class="form-control @error('issue_title') is-invalid @enderror" id="issue_title" name="issue_title"
                                    value="{{ old('issue_title', $issue->issue_title) }}" required>
                                @error('issue_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="issue_description" class="form-label">{{ __('Issue Description') }}</label>
                                <textarea class="form-control" id="issue_description" name="issue_description"
                                    rows="3">{{ $issue->issue_description }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="project_id" class="form-label">{{ __('Project *') }}</label>
                                <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id" required>
                                    <option value="">{{ __('-- Select Project --') }}</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id', $issue->project_id) == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status and Priority Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h5">{{ __('Status and Priority') }}</h2>
                        <small class="text-muted d-block mb-4">{{ __('Current status and priority level') }}</small>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="status_id" class="form-label">{{ __('Status') }}</label>
                                <select class="form-select" id="status_id" name="status_id">
                                    <option value="">{{ __('-- Select Status --') }}</option>
                                    @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}"
                                        {{ $issue->status_id == $status->id ? 'selected' : '' }}>
                                        {{ Str::title(str_replace('_', ' ', $status->name)) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="priority_id" class="form-label">{{ __('Priority') }}</label>
                                <select class="form-select" id="priority_id" name="priority_id">
                                    <option value="">{{ __('-- Select Priority --') }}</option>
                                    @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}"
                                        {{ $issue->priority_id == $priority->id ? 'selected' : '' }}>
                                        {{ Str::title(str_replace('_', ' ', $priority->name)) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Assignment & Timeline -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h5">{{ __('Assignment & Timeline') }}</h2>
                        <small class="text-muted d-block mb-4">{{ __('Who\'s working on this and when it\'s due') }}</small>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="assigned_to_user_id" class="form-label">{{ __('Assignee') }}</label>
                                <select class="form-select" id="assigned_to_user_id" name="assigned_to_user_id">
                                    <option value="">{{ __('-- Select Assignee --') }}</option>
                                    @foreach ($users as $user) // TODO: Change this to users inside the team assigned to the project
                                    <option value="{{ $user->id }}"
                                        {{ $issue->assigned_to_user_id == $user->id ? 'selected' : '' }}>
                                        {{ Str::title(str_replace('_', ' ', $user->name)) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="estimated_time_hours" class="form-label">{{ __('Estimated Hours') }}</label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control @error('estimated_time_hours') is-invalid @enderror" 
                                           id="estimated_time_hours" 
                                           name="estimated_time_hours" 
                                           step="0.25" 
                                           min="0"
                                           value="{{ old('estimated_time_hours', $issue->estimated_time_hours) }}" 
                                           placeholder="0.00" />
                                @error('estimated_time_hours')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                    <span class="input-group-text">hours</span>
                                </div>
                                <small class="form-text text-muted">
                                    <span id="time_conversion_display">
                                        @if($issue->estimated_time_minutes)
                                            {{ $issue->estimated_time_minutes }} minutes
                                        @endif
                                    </span>
                                </small>
                                <!-- Hidden field to store the original minutes value -->
                                <input type="hidden" name="estimated_time_minutes" value="{{ $issue->estimated_time_minutes }}" />
                            </div>
                            <div class="col-12">
                                <label for="issue_due_date" class="form-label">{{ __('Due Date') }}</label>
                                <input type="date" class="form-control" id="issue_due_date" name="issue_due_date"
                                    value="{{ $issue->issue_due_date ? $issue->issue_due_date->format('Y-m-d') : '' }}">
                            </div>

                            <div class="col-12 mt-5 text-end">
                                <div class="btn-group">
                                    <x-button-primary btnType="outline-secondary" classes="d-flex align-items-center justify-content-center" isLink="true"
                                        href="{{ route('admin.issues.show', $issue->id) }}">
                                        <i data-feather="x" class="me-2" style="width: 16px; height: 16px;"></i>
                                        {{ __('Cancel') }}
                                    </x-button-primary>

                                    <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center"
                                        furtherActions="type=submit">
                                        <i data-feather="save" class="me-2" style="width: 16px; height: 16px;"></i>
                                        {{ __('Save Changes') }}
                                    </x-button-primary>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Current Status') }}</h5>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Validation</h5>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Issue History') }}</h5>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hoursInput = document.getElementById('estimated_time_hours');
            const conversionDisplay = document.getElementById('time_conversion_display');
            const hiddenMinutesField = document.querySelector('input[name="estimated_time_minutes"]');

            function updateConversionDisplay() {
                const hours = parseFloat(hoursInput.value) || 0;
                const minutes = Math.round(hours * 60);
                
                if (hours > 0) {
                    conversionDisplay.textContent = `${minutes} minutes`;
                    hiddenMinutesField.value = minutes;
                } else {
                    conversionDisplay.textContent = '';
                    hiddenMinutesField.value = '';
                }
            }

            // Update display on input change
            hoursInput.addEventListener('input', updateConversionDisplay);
            
            // Initial display update
            updateConversionDisplay();
        });
    </script>
    @endpush
@endsection