<div class="pt-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1 mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.projects') }}" class="text-decoration-none">←
                    {{ __('Back to Projects') }}</a>
                <div class="btn-group">
                    <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center">
                        <i data-feather="edit" class="me-2" style="width: 16px; height: 16px;"></i>
                        {{ __('Edit') }}
                    </x-button-primary>
                    <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center">
                        <i data-feather="settings" class="me-2" style="width: 16px; height: 16px;"></i>
                        {{ __('Settings') }}
                    </x-button-primary>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="fw-bold m-0">
                        <div class="d-flex align-items-center">
                            <span class="me-2 rounded-circle d-inline-block"
                                style="width: 20px; height: 20px; background-color: {{ $project->color }};"></span>
                            <span>{{ $project->name }}</span>
                        </div>
                        @if ($project->isOverdue())
                            <x-badge :label="__('Overdue')" textColor="text-danger" classes="ms-1 small" />
                        @elseif($project->isDueSoon())
                            <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1 small" />
                        @endif
                    </h1>
                    <p class="text-muted m-0">{{$project->description}}</p>
                </div>
                <select class="form-select form-select-sm status-select" data-project-id="{{ $project->id }}"
                    data-original-status="{{ $project->status }}" name="project_status" style="width: 200px;">
                    <option value="planning" {{ $project->status === 'planning' ? 'selected' : '' }}>Planning
                    </option>
                    <option value="in_progress" {{ $project->status === 'in_progress' ? 'selected' : '' }}>In
                        Progress</option>
                    <option value="feedback" {{ $project->status === 'feedback' ? 'selected' : '' }}>Feedback
                    </option>
                    <option value="closed" {{ $project->status === 'closed' ? 'selected' : '' }}>Closed
                    </option>
                    <option value="active" {{ $project->status === 'active' ? 'selected' : '' }}>Active
                    </option>
                </select>
            </div>
        </div>
    </div>