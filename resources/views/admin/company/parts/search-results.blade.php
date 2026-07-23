<div class="mt-6">
    <div class="overflow-x-auto mt-4">
        <table class="table table-fixed">
            <thead>
                <tr>
                    <th>{{ __('Customer') }}</th>
                    <th>{{ __('Contact Info') }}</th>
                    <th class="text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr class="hover:bg-base-200/80 transition-colors">
                        <td>
                            <a href="{{ route('admin.company', $company->id) }}" class="font-semibold">
                                {{ $company->name }}
                            </a>
                        </td>
                        <td>
                            @if ($company->email)
                                <p class="text-sm flex items-center gap-2">
                                    <i class="icon icon-sm icon-mail text-primary/30"></i>
                                    {{ $company->email }}
                                </p>
                            @endif
                            @if ($company->phone)
                                <p class="text-sm flex items-center gap-2">
                                    <i class="icon icon-sm icon-phone text-primary/30"></i>
                                    {{ $company->phone }}
                                </p>
                            @endif
                        </td>
                        <td>
                            <div class="flex gap-3 justify-end">
                                <a href="{{ route('admin.company.edit', $company->id) }}" title="{{ __('Edit') }}"
                                    class="btn btn-square btn-outline btn-neutral dark:btn-secondary">
                                    <i class="icon icon-sm icon-edit"></i>
                                </a>
                                {{-- <button class="btn btn-square btn-outline btn-error" type="button"
                                    data-modal-target="confirm-customer-delete">
                                    <i class="icon icon-sm icon-trash"></i>
                                </button>
                                @include('admin.customer.modals.delete-customer') --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>