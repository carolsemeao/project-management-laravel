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
    <div class="row g-4">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" id="projectEditForm">
                @csrf
                @method('PUT')
                <!-- Project Information Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h5">{{ __('Project Information') }}</h2>
                        <small class="text-muted d-block mb-4">{{ __('Basic details about the project') }}</small>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">{{ __('Project Title *') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $project->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">{{ __('Project Description') }}</label>
                                <textarea class="form-control" id="description" name="description"
                                    rows="3">{{ $project->description }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ $project->start_date ? $project->start_date->format('Y-m-d') : '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label">{{ __('Due Date') }}</label>
                                <input type="date" class="form-control" id="due_date" name="due_date"
                                    value="{{ $project->due_date ? $project->due_date->format('Y-m-d') : '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="status_id" class="form-label">{{ __('Status') }}</label>
                                <select class="form-select @error('status_id') is-invalid @enderror" id="status_id"
                                    name="status_id">
                                    <option value="">{{ __('-- Select Status --') }}</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ $project->status_id == $status->id ? 'selected' : ''
                                                                                                                                                                                                                                                                                                                                }}>
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
                                <select class="form-select @error('priority_id') is-invalid @enderror" id="priority_id"
                                    name="priority_id">
                                    <option value="">{{ __('-- Select Priority --') }}</option>
                                    @foreach ($priorities as $priority)
                                                                <option value="{{ $priority->id }}" {{ $project->priority_id == $priority->id ? 'selected'
                                        : '' }}>
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
                            <div class="col-md-6">
                                <label for="color" class="form-label">{{ __('Project Color') }}</label>
                                <input type="color"
                                    class="form-control form-control-color @error('color') is-invalid @enderror" id="color"
                                    name="color" value="{{ $project->color }}">
                                @error('color')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="budget" class="form-label">{{ __('Budget') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">CHF</span>
                                    <input type="number" class="form-control @error('budget') is-invalid @enderror"
                                        id="budget" name="budget" value="{{ $project->budget }}"
                                        aria-label="Amount (to the nearest dollar)" step="0.50" min="0">
                                </div>
                                @error('budget')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h5">{{ __('Customer Assignment') }}</h2>
                        <small class="text-muted d-block mb-4">{{ __('Assign a customer to the project') }}</small>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="company_id" class="form-label">{{ __('Company') }}</label>
                                <select class="form-select @error('company_id') is-invalid @enderror" id="company_id"
                                    name="company_id">
                                    <option value="">{{ __('-- Select Company --') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ $project->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12" id="contact-person-select">
                                <label for="customer_id" class="form-label">{{ __('Contact Person') }}</label>
                                <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id"
                                    name="customer_id">
                                    <option value="">{{ __('-- Select Contact Person --') }}</option>
                                    @foreach ($availableCustomers as $customer)
                                        <option value="{{ $customer->id }}"
                                            data-company-id="{{ $customer->company_id }}"
                                            data-email="{{ $customer->email }}"
                                            data-phone="{{ $customer->phone }}"
                                            data-notes="{{ $customer->notes }}"
                                                {{ $project->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="card bg-secondary-subtle" id="customer-card">
                                    <div class="card-body">
                                        <p class="card-text">
                                            <span id="customer_email">
                                                <span class="icon icon-sm icon-mail me-1"></span>
                                                <span id="customer_email_text">{{ $project->customer->email ?? __('Not assigned') }}</span>
                                            </span><br>
                                            <span id="customer_phone">
                                                <span class="icon icon-sm icon-phone me-1"></span>
                                                <span id="customer_phone_text">{{ $project->customer->phone ?? __('Not assigned') }}</span>
                                            </span><br>
                                            <span id="customer_notes">
                                                <span class="icon icon-sm icon-edit me-1"></span>
                                                    <span id="customer_notes_text">{{ $project->customer->notes ?? __('No notes') }}</span>
                                                </span>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5 text-end">
                    <div class="btn-group">
                        <x-button-primary btnType="outline-secondary"
                            classes="d-flex align-items-center justify-content-center" furtherActions="type=button id=cancelButton data-redirect-url={{ route('admin.projects.show', $project->id) }}">
                            <span class="icon icon-sm icon-x me-2"></span>
                            {{ __('Cancel') }}
                        </x-button-primary>

                        <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center"
                            furtherActions="type=submit">
                            <span class="icon icon-sm icon-save me-2"></span>
                            {{ __('Save Changes') }}
                        </x-button-primary>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Current Status') }}</h5>
                    <p class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('Status') }}</span>
                        <x-badge :label="$project->getFormattedStatusName()" />
                    </p>
                    <p class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('Due Date') }}</span>
                        @if($project->due_date)
                            <span class="d-flex align-items-center">
                                <span class="icon icon-sm icon-calendar me-1"></span>
                                <span class="small">{{ $project->due_date->format('d/m/Y') }}</span>
                            </span>
                        @else
                            <span class="d-flex align-items-center">
                                <span class="icon icon-sm icon-calendar me-1"></span>
                                <span class=" small">{{ __('Not set') }}</span>
                            </span>
                        @endif
                    </p>
                    <p class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('Company') }}</span>
                        <span class="d-flex align-items-center">
                            <span class="icon icon-sm icon-buildings me-1"></span>
                            <span class="small">{{ $project->company->name ?? __('Not assigned') }}</span>
                        </span>
                    </p>
                    <p class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('Contact Person') }}</span>
                        <span class="d-flex align-items-center">
                            <span class="icon icon-sm icon-user me-1"></span>
                            <span class="small">{{ $project->customer->name ?? __('Not assigned') }}</span>
                        </span>
                    </p>
                    <p class="d-flex justify-content-between mb-2 mt-4">
                        <span class="text-muted small">{{ __('Created At') }}</span>
                        <span class="small">{{ $project->created_at->format('d/m/Y H:i')}}</span>
                    </p>
                    <p class="d-flex justify-content-between">
                        <span class="text-muted small">{{ __('Last Updated') }}</span>
                        <span class="small">{{ $project->updated_at->format('d/m/Y H:i')}}</span>
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Quick Actions') }}</h5>
                    <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center w-100 mb-2 mt-3" furtherActions="onclick=document.getElementById('confirm-project-complete').showModal()">
                        <span class="icon icon-sm icon-target me-2"></span>
                        {{ __('Mark as completed') }}
                    </x-button-primary>
                    <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center w-100" furtherActions="onclick=document.getElementById('confirm-project-hold').showModal()">
                        <span class="icon icon-sm icon-settings me-2"></span>
                        {{ __('Put on hold') }}
                    </x-button-primary>
                </div>
            </div>
        </div>
    </div>
    @include('admin.project.modals.project-complete')
    @include('admin.project.modals.project-on-hold')
@endsection