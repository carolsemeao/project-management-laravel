@extends('admin.issue.admin_issue_single_template')
@section('title', 'Create Issue')
@section('page_title', 'Create Issue')
@section('page_subtitle', 'Add a new issue to track work and progress.')
@section('back_to_route', route('admin.issues'))
@section('back_to_text', __('Back to Issues'))

@section('maincontent')
    <div class="row g-4">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <form action="{{ route('admin.issues.create-issue') }}" method="POST">
                @csrf
                <!-- Issue Information Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h5">{{ __('Issue Information') }}</h2>
                        <small class="text-muted d-block mb-4">{{ __('Basic details about the issue') }}</small>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="issue_title" class="form-label">{{ __('Issue Title *') }}</label>
                                <input type="text" class="form-control @error('issue_title') is-invalid @enderror"
                                    id="issue_title" name="issue_title" value="{{ old('issue_title') }}">
                                @error('issue_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="issue_description" class="form-label">{{ __('Issue Description') }}</label>
                                <textarea class="form-control" id="issue_description" name="issue_description"
                                    rows="3">{{ old('issue_description') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="project_id" class="form-label">{{ __('Project') }}</label>
                                <select class="form-select" id="project_id"
                                    name="project_id">
                                    <option value="">{{ __('-- Select Project --') }}</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id">
                                    <option value="">{{ __('-- Select Status --') }}</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                            {{ Str::title(str_replace('_', ' ', $status->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="priority_id" class="form-label">{{ __('Priority') }}</label>
                                <select class="form-select @error('priority_id') is-invalid @enderror" id="priority_id" name="priority_id">
                                    <option value="">{{ __('-- Select Priority --') }}</option>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                            {{ Str::title(str_replace('_', ' ', $priority->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to_user_id') == $user->id ? 'selected' : '' }}>
                                            {{ Str::title(str_replace('_', ' ', $user->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="estimated_time_hours" class="form-label">{{ __('Estimated Hours') }}</label>
                                <div class="input-group">
                                    <input type="number"
                                        class="form-control"
                                        id="estimated_time_hours" name="estimated_time_hours" step="0.25" min="0"
                                        placeholder="0.00" value="{{ old('estimated_time_hours') }}" />
                                    <span class="input-group-text">{{ __('hours') }}</span>
                                </div>
                                <!-- Hidden field to store the original minutes value -->
                                <input type="hidden" name="estimated_time_minutes" />
                            </div>
                            <div class="col-12">
                                <label for="issue_due_date" class="form-label">{{ __('Due Date') }}</label>
                                <input type="date" class="form-control" id="issue_due_date" name="issue_due_date" value="{{ old('issue_due_date') }}">
                            </div>

                            <div class="col-12 mt-5 text-end">
                                <div class="btn-group">
                                    <x-button-primary btnType="outline-secondary"
                                        classes="d-flex align-items-center justify-content-center" isLink="true"
                                        href="{{ route('admin.issues') }}">
                                        <span class="icon icon-sm icon-x me-2"></span>
                                        {{ __('Cancel') }}
                                    </x-button-primary>

                                    <x-button-primary btnType="outline-dark"
                                        classes="d-flex align-items-center justify-content-center"
                                        furtherActions="type=submit">
                                        <span class="icon icon-sm icon-save me-2"></span>
                                        {{ __('Create Issue') }}
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

        </div>
    </div>
@endsection