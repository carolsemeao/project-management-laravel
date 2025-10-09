@extends('admin.issue.admin_issue_single_template')
@section('title', 'Edit Issue #' . $issue->id)
@section('page_title', 'Edit Issue #' . $issue->id)
@section('page_subtitle', 'Update issue details and track progress')
@section('back_to_route', route('admin.issues.show', $issue->id))
@section('back_to_text', __('Back'))

@section('maincontent')
    <div class="md:grid md:grid-cols-12 gap-4">
        <!-- Left Column - Main Content -->
        <div class="md:col-span-8">
            <form action="{{ route('admin.issues.update', $issue->id) }}" method="POST">
                @method('PUT')
                @csrf
                <!-- Issue Information Card -->
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="card-header">
                            <h2 class="card-title">{{ __('Issue Information') }}</h2>
                            <p class="text-sm opacity-60 mb-4">{{ __('Basic details about the issue') }}</p>
                        </div>

                        <div class="card-body__form">
                            <fieldset class="fieldset mb-3">
                                <legend class="fieldset-legend">{{ __('Issue Title *') }}</legend>
                                <input type="text" class="input w-full @error('issue_title') is-invalid @enderror"
                                    id="issue_title" name="issue_title"
                                    value="{{ old('issue_title', $issue->issue_title) }}" autofocus />

                                @error('issue_title')
                                    <div class="validator-hint hidden">{{ $message }}</div>
                                @enderror
                            </fieldset>

                            <fieldset class="fieldset mb-3">
                                <legend class="fieldset-legend">{{ __('Issue Description') }}</legend>
                                <textarea class="textarea w-full h-50 resize-none" id="issue_description"
                                    name="issue_description">{{ old('issue_description', $issue->issue_description) }}</textarea>
                            </fieldset>

                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">{{ __('Project') }}</legend>
                                <select class="select w-full" id="project_id" name="project_id">
                                    <option value="" disabled selected>{{ __('-- Select Project --') }}</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id', $issue->project_id) == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <!-- Status and Priority Card -->
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="card-header">
                            <h2 class="card-title">{{ __('Status and Priority') }}</h2>
                            <p class="text-sm opacity-60 mb-4">{{ __('Current status and priority level') }}</p>
                        </div>

                        <div class="card-body__form">
                            <div class="md:grid md:grid-cols-2 md:gap-4">
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Status *') }}</legend>
                                    <select class="select w-full @error('status_id') is-invalid @enderror" id="status_id"
                                        name="status_id">
                                        <option value="" disabled selected>{{ __('-- Select Status --') }}</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id', $issue->status_id) == $status->id ? 'selected' : '' }}>
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
                                    <select class="select w-full @error('priority_id') is-invalid @enderror"
                                        id="priority_id" name="priority_id">
                                        <option value="" disabled selected>{{ __('-- Select Priority --') }}</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}" {{ old('priority_id', $issue->priority_id) == $priority->id ? 'selected' : '' }}>
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

                <!-- Assignment & Timeline -->
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="card-header">
                            <h2 class="card-title">{{ __('Assignment & Timeline') }}</h2>
                            <p class="text-sm opacity-60 mb-4">{{ __('Who\'s working on this and when it\'s due') }}</p>
                        </div>
                        <div class="card-body__form">
                            <div class="md:grid md:grid-cols-2 md:gap-4 mb-3">
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Assignee') }}</legend>
                                    <select class="select w-full" id="assigned_to_user_id" name="assigned_to_user_id">
                                        <option value="" disabled selected>{{ __('-- Select Assignee --') }}</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to_user_id', $issue->assigned_to_user_id) == $user->id ? 'selected' : '' }}>
                                                {{ Str::title(str_replace('_', ' ', $user->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </fieldset>

                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Estimated Hours') }}</legend>
                                    <div class="join">
                                        <input type="number" placeholder="0.00" class="join-item input w-full"
                                            id="estimated_time_hours" name="estimated_time_hours" step="0.25" min="0"
                                            value="{{ old('estimated_time_hours', $issue->estimated_time_hours) }}" />
                                        <span
                                            class="bg-base-300 join-item w-15 flex items-center justify-center">{{ __('hours') }}
                                        </span>
                                    </div>
                                    <!-- Hidden field to store the original minutes value -->
                                    <input type="hidden" name="estimated_time_minutes"
                                        value="{{ $issue->estimated_time_minutes }}" />
                                </fieldset>
                            </div>
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">{{ __('Due Date') }}</legend>
                                <x-cally-calendar :popoverTarget="'issue_due_date'" :popoverAnchor="'issue_due_date'"
                                    :initialValue="$issue->issue_due_date?->format('Y-m-d')" />
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <div class="join">
                        <a href="{{ route('admin.issues.show', $issue->id) }}" class="join-item btn btn-soft">
                            <span class="icon icon-sm icon-x me-2"></span>
                            {{ __('Cancel') }}
                        </a>
                        <button class="join-item btn btn-neutral" type="submit">
                            <span class="icon icon-sm icon-save me-2"></span>
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="md:col-span-4">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-header">
                        <h2 class="card-title">{{ __('Current Status') }}</h2>
                    </div>
                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Status') }}</span>
                        <x-badge :label="$issue->getFormattedStatus()" classes="badge-xs" />
                    </p>
                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Priority') }}</span>
                        <x-priority_badge :priority="$issue->priority->name" iconsize="xs" classes="badge-xs" />
                    </p>
                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Assigned to') }}</span>
                        @if($issue->assigned_to_user_id)
                            <span class="text-xs">{{ $issue->assignedUser->name }}</span>
                        @else
                            <span class="text-xs">{{ __('Unassigned') }}</span>
                        @endif
                    </p>
                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Due date') }}</span>
                        @if($issue->issue_due_date)
                            <span class="flex items-center">
                                <span class="icon icon-xs icon-calendar me-1"></span>
                                <span class="text-xs">{{ $issue->issue_due_date->format('d/m/Y') }}</span>
                            </span>
                        @else
                            <span class="flex items-center">
                                <span class="icon icon-xs icon-calendar me-1"></span>
                                <span class="text-xs">{{ __('Not set') }}</span>
                            </span>
                        @endif
                    </p>
                    <p class="flex justify-between mb-2">
                        <span class="text-xs font-semibold">{{ __('Estimated') }}</span>
                        @if($issue->estimated_time_hours)
                            <span class="flex items-center">
                                <span class="icon icon-xs icon-clock me-1"></span>
                                <span class="text-xs">{{ $issue->estimated_time_hours }} {{ __('h') }}</span>
                            </span>
                        @else
                            <span class="flex items-center">
                                <span class="icon icon-xs icon-clock me-1"></span>
                                <span class="text-xs">{{ __('0h') }}</span>
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <h2 class="card-title">{{ __('Issue History') }}</h2>
                    </div>
                    <p class="flex justify-between mb-2">
                        <span class="text-xs font-semibold">{{ __('Created') }}</span>
                        <span class="text-xs">{{ $issue->created_at->format('d/m/Y H:i') }}</span>
                    </p>
                    <p class="flex justify-between mb-2">
                        <span class="text-xs font-semibold">{{ __('Created by') }}</span>
                        <span class="text-xs">{{ $issue->createdByUser->name }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="text-xs font-semibold">{{ __('Last updated') }}</span>
                        <span class="text-xs">{{ $issue->updated_at->format('d/m/Y H:i') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection