<div class="card mb-6">
    <div class="card-body">
        <div class="card-header mb-4">
            <h2 class="card-title">{{ __('Registered Employees') }}</h2>
            @if (count($employees) > 0)
                <ul class="list mt-6 gap-4">
                    @foreach ($employees as $employee)
                        <li
                            class="list-row relative items-start md:items-center bg-base-300/15 dark:bg-base-300/30 border-1 border-dashed border-base-300/60 dark:border-base-content/10">
                            <div class="md:list-col-grow">
                                <h3>{{ $employee->name }}</h3>
                                <div class="flex items-start gap-2 mb-1">
                                    <i class="icon icon-sm icon-mail"></i>
                                    <span>{{ $company->email ?? '-' }}</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="icon icon-sm icon-phone"></i>
                                    <span>{{ $company->phone ?? '-' }}</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.customer.show', $employee->id) }}"
                                class="btn btn-square btn-neutral btn-outline btn-sm ml-auto after:inset-0 after:absolute after:z-10">
                                <i class="icon icon-eye icon-sm"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty">
                    <i class="icon icon-lg icon-user mb-2 block"></i>
                    <p class="text-sm">{{ __('No registered employees for this company') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>