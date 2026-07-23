<x-custom-modal :modalId="'confirm-project-complete'" :title="__('Please Confirm')" :formID="'completeProjectForm'"
    :action="route('admin.projects.complete', $project->id)" :method="'POST'" :methodType="'PUT'">
    <p>{{ __('Are you sure you want to mark this project as completed?') }}</p>
</x-custom-modal>