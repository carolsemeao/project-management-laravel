<x-custom-modal :modalId="'confirm-issue-deletion'" :title="__('Delete Issue')" :formID="'deleteIssueForm'"
    :action="route('admin.issues.destroy', $issue->id)" :method="'POST'" :methodType="'DELETE'">
    <p class="text-lg font-medium">
        {{ __('Are you sure you want to delete this issue?') }}
    </p>
    <p class="opacity-70">
        {{ __('Once this issue is deleted, all of its data will be permanently deleted.') }}
    </p>
</x-custom-modal>