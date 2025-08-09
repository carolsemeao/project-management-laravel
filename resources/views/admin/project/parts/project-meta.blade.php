<div class="row gy-0 gx-4">
    <div class="col-6 col-md-4 col-lg-3">
        @include('components.card', [
            'title' => __('Total Issues'),
            'icon' => 'target',
            'text' => $totalIssues,
            'subtitle' => __(':numberOfCompletedIssues completed', ['numberOfCompletedIssues' => $project->getIssuesByStatus(6)])
        ])
    </div>

    <div class="col-6 col-md-4 col-lg-3">
        @include('components.card', [
            'title' => __('Open Issues'),
            'icon' => 'alert-triangle',
            'text' => $openIssues,
            'subtitle' => __(':issuesInProgress in progress', ['issuesInProgress' => $issuesInProgress])
        ])
    </div>

    <div class="col-6 col-md-4 col-lg-3">
        @include('components.card', [
            'title' => __('Time Logged'),
            'icon' => 'clock',
            'text' => $project->getFormattedTotalLoggedTime(),
            'subtitle' => 'of ' . $timeProgress['issue_estimated'] . ' estimated (' . $timeProgress['offer_hours'] . ' from offers)'
        ])
    </div>

    <div class="col-6 col-md-4 col-lg-3">
        @include('components.card', [
            'title' => __('Project Value'),
            'icon' => 'trending-up',
            'text' => App\Http\Controllers\OfferController::calculateTotal($project->id), // TODO: umsetzung
            'subtitle' => __(':acceptedOffers accepted offers', ['acceptedOffers' => App\Http\Controllers\OfferController::getOffersForProject($project->id)->where('status', 'accepted')->count()])
        ])
    </div>
</div>