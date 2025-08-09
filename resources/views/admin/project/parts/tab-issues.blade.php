<div class="card mt-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="card-title">Project Issues</h2>
                <small class="text-muted">
                    @php
                        $closedStatusId = App\Models\Status::where('name', 'closed')->value('id');
                        $openIssues = $project->issues()->where('status_id', '!=', $closedStatusId)->count();
                    @endphp
                    {{ __(':totalIssues total issues • :openIssues open', ['totalIssues' => $project->issues->count(), 'openIssues' => $openIssues]) }}
                </small>
            </div>
            <x-button-primary btnType="dark" classes="d-flex align-items-center justify-content-center"
                furtherActions="data-bs-toggle=modal data-bs-target=#logTimeModal">
                <span class="icon icon-sm icon-plus me-2"></span>
                {{ __('New Issue') }}
            </x-button-primary>
        </div>

        @include('admin.issue.parts.issues', ['issues' => $project->issues, 'hideProjectColumn' => true])
    </div>
</div>