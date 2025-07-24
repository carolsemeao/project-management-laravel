<div class="card mt-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="card-title">Project Issues</h2>
                <small class="text-muted">
                    {{ __(':totalIssues total issues • :openIssues open', ['totalIssues' => $project->issues->count(), 'openIssues' => $project->issues()->where('status_id', '!=', 6)->count()]) }}
                </small>
            </div>
            <x-button-primary btnType="dark" classes="d-flex align-items-center justify-content-center"
                furtherActions="data-bs-toggle=modal data-bs-target=#logTimeModal">
                <i data-feather="plus" class="me-2" style="width: 16px; height: 16px;"></i>
                {{ __('New Issue') }}
            </x-button-primary>
        </div>

        @include('admin.issue.parts.issues', ['issues' => $project->issues, 'hideProjectColumn' => true])
    </div>
</div>