<x-custom-modal :modalId="'confirm-project-hold'" :title="__('Please Confirm')" :formID="'projectOnHoldForm'"
    :action="route('admin.projects.hold', $project->id)" :method="'POST'" :methodType="'PUT'">
    <p>{{ __('Are you sure you want to put this project on hold?') }}</p>
</x-custom-modal>