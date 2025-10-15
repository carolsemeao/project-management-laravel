@extends('admin.admin_single_template')
@section('title', 'Create Issue')
@section('page_title')
    <div class="content__header-title">
        <h1>{{ __('Create Issue') }}</h1>
        <p class="text-sm opacity-60">{{ __('Add a new issue to track work and progress.') }}</p>
    </div>
@endsection
@section('back_to_route', route('admin.issues'))
@section('back_to_text', __('Back to Issues'))

@section('maincontent')
    <form action="{{ route('admin.issues.create-issue') }}" method="POST">
        @csrf
        <div class="card mb-6">
            <div class="card-body">
                <h2 class="card-title">{{ __('Issue Information') }}</h2>
                <p class="text-sm opacity-60 mb-4">{{ __('Basic details about the issue') }}</p>

                <div class="card-body__form">
                    <fieldset class="fieldset mb-3">
                        <legend class="fieldset-legend">{{ __('Issue Title *') }}</legend>
                        <input type="text" class="input w-full @error('issue_title') is-invalid @enderror"
                        id="issue_title" name="issue_title" value="{{ old('issue_title') }}" autofocus />

                        @error('issue_title')
                            <div class="validator-hint hidden">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="fieldset mb-3">
                        <legend class="fieldset-legend">{{ __('Issue Description') }}</legend>
                        <textarea class="textarea w-full h-50 resize-none" id="issue_description" name="issue_description">{{ old('issue_description') }}</textarea>
                    </fieldset>

                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Project') }}</legend>
                        <select class="select w-full" id="project_id" name="project_id">
                            <option value="" disabled selected>{{ __('-- Select Project --') }}</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id || $projectId == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                          </select>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="card mb-6">
            <div class="card-body">
                <h2 class="card-title">{{ __('Status and Priority') }}</h2>
                <p class="text-sm opacity-60 mb-4">{{ __('Current status and priority level') }}</p>

                <div class="card-body__form">
                    <div class="md:grid md:grid-cols-2 md:gap-4">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Status *') }}</legend>
                            <select class="select w-full @error('status_id') is-invalid @enderror" id="status_id" name="status_id">
                                <option value="" disabled selected>{{ __('-- Select Status --') }}</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                        {{ Str::title(str_replace('_', ' ', $status->name)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <div class="validator-hint hidden">{{ $message }}</div>
                            @enderror
                        </fieldset>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Priority *') }}</legend>
                            <select class="select w-full @error('priority_id') is-invalid @enderror" id="priority_id" name="priority_id">
                                <option value="" disabled selected>{{ __('-- Select Priority --') }}</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                        {{ Str::title(str_replace('_', ' ', $priority->name)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority_id')
                                <div class="validator-hint hidden">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-8">
            <div class="card-body">
                <h2 class="card-title">{{ __('Assignment & Timeline') }}</h2>
                <p class="text-sm opacity-60 mb-4">{{ __('Who\'s working on this and when it\'s due') }}</p>

                <div class="card-body__form">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Assignee') }}</legend>
                            <select class="select w-full" id="assigned_to_user_id" name="assigned_to_user_id">
                                <option value="" disabled selected>{{ __('-- Select Assignee --') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to_user_id') == $user->id ? 'selected' : '' }}>
                                        {{ Str::title(str_replace('_', ' ', $user->name)) }}
                                    </option>
                                @endforeach
                            </select>
                        </fieldset>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">{{ __('Estimated Hours') }}</legend>
                            <div class="join">
                                <input type="number" placeholder="0.00" class="join-item input w-full" id="estimated_time_hours" name="estimated_time_hours" step="0.25" min="0"/>
                                <span class="bg-base-300 join-item w-15 flex items-center justify-center">{{ __('hours') }}</sü>
                            </div>
                            <!-- Hidden field to store the original minutes value -->
                            <input type="hidden" name="estimated_time_minutes" />
                        </fieldset>
                    </div>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">{{ __('Due Date') }}</legend>
                        <x-cally-calendar :popoverTarget="'issue_due_date'" :popoverAnchor="'issue_due_date'" />
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="text-end">
            <div class="join">
                <a href="{{ route('admin.issues') }}" class="join-item btn btn-soft">
                    <span class="icon icon-sm icon-x me-2"></span>
                    {{ __('Cancel') }}
                </a>
                <button class="join-item btn btn-neutral" type="submit">
                    <span class="icon icon-sm icon-save me-2"></span>
                    {{ __('Create Issue') }}
                </button>
            </div>
        </div>
    </form>
@endsection