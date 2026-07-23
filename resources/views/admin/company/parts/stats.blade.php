<div
    class="stats stats-vertical border-1 border-base-300/60 dark:border-base-content/10 border-dashed lg:stats-horizontal w-full">
    @include('components.card', [
        'title' => __('Total Customers'),
        'icon' => 'user',
        'text' => 4, // TODO: $totalCustomers
        'subtitle' => __('Active customer relationships')
    ])
    
    @include('components.card', [
        'title' => __('Active Projects'),
        'icon' => 'buildings',
        'text' => 1, // TODO: $activeProjects
        'subtitle' => __('Projects with assigned customers')
    ])

    @include('components.card', [
        'title' => __('Companies'),
        'icon' => 'buildings',
        'text' => 4, // TODO: $totalCompanies
        'subtitle' => __('Unique organizations')
    ])
</div>