@extends('admin.project.admin_project_single_template')
@section('title', 'Create New Project')
@section('page_title', 'Create New Project')
@section('page_subtitle', 'Add a new project to start tracking issues and time.')
@section('back_to_route', route('admin.projects'))
@section('back_to_text', __('Back to Projects'))

@section('project-header')
    @include('admin.project.parts.header')
@endsection

@section('maincontent')
    <div class="row g-4">
        <div class="col-lg-8">
            <form action="{{ route('admin.projects.create-project') }}" method="POST" id="projectCreateForm">
                @csrf
                @method('POST')
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h5">{{ __('Project Information') }}</h2>
                        <small class="text-muted d-block mb-4">{{ __('Basic details about the project') }}</small>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">{{ __('Project Title *') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">{{ __('Project Description') }}</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label">{{ __('Due Date') }}</label>
                                <input type="date" class="form-control" id="due_date" name="due_date">
                            </div>
                            <div class="col-md-6">
                                <label for="status_id" class="form-label">{{ __('Status') }}</label>
                                <select class="form-select @error('status_id') is-invalid @enderror" id="status_id"
                                    name="status_id">
                                    <option value="">{{ __('-- Select Status --') }}</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">
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
                                        <option value="{{ $priority->id }}">
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
                                    name="color">
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
                                        id="budget" name="budget" aria-label="Amount (to the nearest dollar)" step="0.50"
                                        min="0">
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
            </form>
        </div>
    </div>
@endsection