@extends('admin.project.admin_project_single_template')
@section('title', 'Edit Project: ' . $project->name)
@section('page_title', 'Edit Project: ' . $project->name)
@section('page_subtitle', 'Update project details and customer assignment')
@section('back_to_route', route('admin.projects.show', $project->id))
@section('back_to_text', __('Back'))

@section('project-header')
    @include('admin.project.parts.header', ['project' => $project])
@endsection

@section('maincontent')
    <div class="md:grid md:grid-cols-12 gap-4">
        <!-- Left Column - Main Content -->
        <div class="md:col-span-8">
            @if($errors->any())
                <div class="alert alert-error alert-soft mb-8 items-start" role="alert">
                    <i class="icon icon-sm icon-alert-triangle mt-[0.1em]"></i>
                    <span>{{ __('Please mind the highlighted fields.') }}</span>
                </div>
            @endif
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" id="projectEditForm">
                @method('PUT')
                @csrf
                <!-- Project Information Card -->
                <div class="card mb-6">
                    <div class="card-body">
                        <h2 class="card-title">{{ __('Project Information') }}</h2>
                        <p class="text-sm opacity-60 mb-4">{{ __('Basic details about the project') }}</p>

                        <div class="card-body__form">
                            <fieldset class="fieldset mb-4">
                                <legend class="fieldset-legend">{{ __('Project Title *') }}</legend>
                                <input type="text" class="input w-full @error('name') input-error @enderror" id="name"
                                name="name" value="{{ old('name', $project->name) }}">
                                @error('name')
                                    <div class="text-error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </fieldset>

                            <fieldset class="fieldset mb-4">
                                <legend class="fieldset-legend">{{ __('Project Description') }}</legend>
                                <textarea class="textarea w-full h-50 resize-none" id="description"
                                    name="description">{{ old('description', $project->description) }}</textarea>
                            </fieldset>

                            <div class="md:grid md:grid-cols-2 md:gap-4">
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Start Date') }}</legend>
                                    <x-cally-calendar :popoverTarget="'start_date'" :popoverAnchor="'start_date'"
                                    :initialValue="$project->start_date?->format('Y-m-d')" />
                                </fieldset>
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Due Date') }}</legend>
                                    <x-cally-calendar :popoverTarget="'due_date'" :popoverAnchor="'due_date'"
                                    :initialValue="$project->due_date?->format('Y-m-d')" />
                                </fieldset>
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Status') }}</legend>
                                    <select class="select w-full @error('status_id') select-error @enderror" id="status_id"
                                    name="status_id">
                                        <option value="" disabled selected>{{ __('-- Select Status --') }}</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $project->status_id == $status->id ? 'selected' : ''}}>
                                                {{ Str::title(str_replace('_', ' ', $status->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <div class="text-error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </fieldset>
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Priority') }}</legend>
                                    <select class="select w-full @error('priority_id') select-error @enderror" id="priority_id"
                                    name="priority_id">
                                        <option value="" disabled selected>{{ __('-- Select Priority --') }}</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}" {{ $project->priority_id == $priority->id ? 'selected': '' }}>
                                                {{ Str::title(str_replace('_', ' ', $priority->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('priority_id')
                                        <div class="text-error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </fieldset>
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Budget') }}</legend>
                                    <div class="join">
                                        <span class="btn btn-neutral btn-disabled join-item">CHF</span>
                                        <input type="number" class="input w-full join-item @error('budget') input-error @enderror" id="budget" aria-label="Amount (to the nearest dollar)" step="0.50" min="0"
                                        name="budget" value="{{ $project->budget }}">
                                        @error('budget')
                                            <div class="text-error">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Assignment Card -->
                <div class="card mb-6">
                    <div class="card-body">
                        <h2 class="card-title">{{ __('Customer Assignment') }}</h2>
                        <p class="text-sm opacity-60 mb-4">{{ __('Assign a customer to the project') }}</p>

                        <div class="card-body__form">
                            <div class="md:grid md:grid-cols-2 md:gap-4 mb-4">
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Company') }}</legend>
                                    <select class="select w-full @error('company_id') select-error @enderror" id="company_id"
                                    name="company_id">
                                        <option value="" disabled {{ old('company_id', $project->company_id) ? '' : 'selected' }}>{{ __('-- Select Company --') }}</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id', $project->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <div class="text-error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </fieldset>

                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">{{ __('Contact Person') }}</legend>
                                    <select class="select w-full @error('customer_id') select-error @enderror" id="customer_id"
                                    name="customer_id">
                                        <option value="" disabled {{ old('customer_id', $project->customer_id) ? '' : 'selected' }}>{{ __('-- Select Contact Person --') }}</option>
                                        @foreach ($availableCustomers as $customer)
                                            <option value="{{ $customer->id }}"
                                                data-company-id="{{ $customer->company_id }}"
                                                data-email="{{ $customer->email }}"
                                                data-phone="{{ $customer->phone }}"
                                                data-notes="{{ $customer->notes }}"
                                                {{ old('customer_id', $project->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="text-error">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </fieldset>
                            </div>

                            <div class="card bg-base-200/50" id="customer-card">
                                <div class="card-body">
                                    <h3>{{ __('Contact Information') }}</h3>
                                    <p id="customer_email">
                                        <span class="icon icon-sm icon-mail me-1"></span>
                                        <span class="font-semibold">{{ __('Email') }}: </span>
                                        <span id="customer_email_text">{{ $project->customer->email ?? __('Not assigned') }}</span>
                                    </p>

                                    <p id="customer_phone">
                                        <span class="icon icon-sm icon-phone me-1"></span>
                                        <span class="font-semibold">{{ __('Phone number') }}:</span>
                                        <span id="customer_phone_text">{{ $project->customer->phone ?? __('Not assigned') }}</span>
                                    </p>

                                    <div id="customer_notes">
                                        <h3 class="mt-5">{{ __('Notes') }}</h3>
                                        <span id="customer_notes_text">{{ $project->customer->notes ?? __('No notes') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <div class="join">
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="join-item btn btn-soft">
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
                        <x-badge :label="$project->getFormattedStatusName()" classes="badge-xs" />
                    </p>

                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Priority') }}</span>
                        <x-priority_badge :priority="$project->priority->name" iconsize="xs" classes="badge-xs" />
                    </p>

                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Due date') }}</span>
                        <span class="flex items-center">
                            <span class="icon icon-xs icon-calendar me-1"></span>
                            <span class="text-xs">{{ $project->due_date->format('d.m.Y') ?? __('Not set') }}</span>
                        </span>
                    </p>

                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Company') }}</span>
                        <span class="text-xs">{{ $project->company->name ?? __('Not assigned') }}</span>
                    </p>

                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Contact Person') }}</span>
                        <span class="text-xs">{{ $project->customer->name ?? __('Not assigned') }}</span>
                    </p>
                </div>
            </div>

            <div class="card mb-6">
                <div class="card-body">
                    <div class="card-header">
                        <h2 class="card-title">{{ __('Project History') }}</h2>
                    </div>
                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Created At') }}</span>
                        <span class="text-xs">{{ $project->created_at->format('d.m.Y H:i') }}</span>
                    </p>

                    <p class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold">{{ __('Last Updated') }}</span>
                        <span class="text-xs">{{ $project->updated_at->format('d.m.Y H:i') }}</span>
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-3">{{ __('Quick Actions') }}</h2>
                    <button type="button" class="btn btn-outline w-full mb-2" data-modal-target="confirm-project-complete">
                        <span class="icon icon-sm icon-check me-2"></span>
                        {{ __('Mark as completed') }}
                    </button>
                    <button type="button" class="btn btn-neutral w-full" data-modal-target="confirm-project-hold">
                        {{ __('Put on hold') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('admin.project.modals.project-complete')
    @include('admin.project.modals.project-on-hold')
@endsection