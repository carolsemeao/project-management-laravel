<div
    class="stats stats-vertical border-1 border-base-300/60 dark:border-base-content/10 border-dashed lg:stats-horizontal w-full">
    @include('components.card', [
        'title' => __('Total Issues'),
        'icon' => 'target',
        'text' => $totalIssues,
        'subtitle' => __(':numberOfCompletedIssues completed', ['numberOfCompletedIssues' => $project->getIssuesByStatus(6)])
    ])
    
    @include('components.card', [
        'title' => __('Open Issues'),
        'icon' => 'alert-triangle',
        'text' => $openIssues,
        'subtitle' => __(':issuesInProgress in progress', ['issuesInProgress' => $issuesInProgress])
    ])

    @include('components.card', [
        'title' => __('Time Logged'),
        'icon' => 'clock',
        'text' => $project->getFormattedTotalLoggedTime(),
        'subtitle' => 'of ' . $timeProgress['issue_estimated'] . ' estimated (' . $timeProgress['offer_hours'] . ' from offers)'
    ])

    @include('components.card', [
        'title' => __('Budget'),
        'icon' => 'dollar-sign',
        'text' => __('CHF :projectBudget', ['projectBudget' => $project->budget]),
        'subtitle' => __(':budgetPercentage% of budget from offers', ['budgetPercentage' => $budget])
    ])
</div>