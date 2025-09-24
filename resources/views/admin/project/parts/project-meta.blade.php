<div class="card-grid card-grid--sm">
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
        'title' => __('Project Value'),
        'icon' => 'trending-up',
        'text' => App\Http\Controllers\OfferController::calculateTotal($project->id), // TODO: umsetzung
        'subtitle' => __(':acceptedOffers accepted offers', ['acceptedOffers' => App\Http\Controllers\OfferController::getOffersForProject($project->id)->where('status', 'accepted')->count()])
    ])
</div>