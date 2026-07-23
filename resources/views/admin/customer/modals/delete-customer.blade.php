<x-custom-modal :modalId="'confirm-customer-delete'" :title="__('Delete Customer')" :formID="'deleteCustomerForm'"
    :action="route('admin.customer.delete', $customer->id)" :method="'POST'" :methodType="'DELETE'">
    <p>{{ __('Are you sure you want to delete this customer?') }}</p>
</x-custom-modal>