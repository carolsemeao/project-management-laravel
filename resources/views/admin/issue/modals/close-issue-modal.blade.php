<x-custom-modal :modalId="'confirm-issue-close'" :title="__('Close Issue')" :formID="'closeIssueForm'"
    :action="route('admin.issues.close', $issue->id)" :method="'POST'" :methodType="'PUT'">
    <p>{{ __('Are you sure you want to close this issue?') }}</p>
</x-custom-modal>