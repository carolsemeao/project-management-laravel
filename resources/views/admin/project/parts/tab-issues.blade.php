<div class="flex justify-end items-center mb-6">
    <a href="{{ route('admin.issues.create', ['project_id' => $project->id]) }}" class="btn">
        <span class="icon icon-sm icon-plus me-2"></span>
        {{ __('New Issue') }}
    </a>
</div>
@include('admin.issue.parts.issues', ['issues' => $project->issuesSorted, 'showProjectColumn' => false, 'showAssignee' => true])
<p class="text-xs opacity-70 mt-3">
    {{ __(':totalIssues total issues • :openIssues open', ['totalIssues' => $project->issues->count(), 'openIssues' => $openIssues]) }}
</p>