<x-custom-modal :modalId="'confirm-log-time'" :title="__('Log Time')" :formID="'logTimeForm'"
    :action="route('admin.issues.log-time', $issue->id)" :method="'POST'">
    <fieldset class="fieldset mb-4">
        <legend class="fieldset-legend" for="time_input">{{ __('Time Spent') }}</legend>
        <input type="text" class="input w-full" id="time_input" name="time_input" required />
        <p class="label">{{ __('Supported formats: 1h 30m, 90m, 1.5h, 1:30') }}</p>
    </fieldset>
    <fieldset class="fieldset mb-4">
        <legend class="fieldset-legend" for="work_date">{{ __('Work Date') }}</legend>
        <x-cally-calendar :popoverTarget="'work_date-popover'" :popoverAnchor="'work_date'" />
    </fieldset>
    <fieldset class="fieldset">
        <legend class="fieldset-legend" for="description">{{ __('Description') }}</legend>
        <textarea class="textarea w-full resize-none" id="description" name="description" rows="3"
            placeholder="{{ __('What did you work on?') }}"></textarea>
    </fieldset>
</x-custom-modal>