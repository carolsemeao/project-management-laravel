@php
    $totalIssues = $project->issues()->count();
    $openIssues = $project->issues()->where('issue_status', '!=', 'closed')->count();
    $issuesInProgress = $project->issues()->where('issue_status', 'in_progress')->count();
    $totalLoggedTime = $project->getTotalLoggedTimeMinutes();
@endphp
<div class="row gy-0 gx-4">
    <div class="col-6 col-md-4 col-lg-3">
        @include('components.card', [
            'title' => __('Total Issues'),
            'icon' => 'target',
            'text' => $totalIssues,
            'subtitle' => __(':numberOfCompletedIssues completed', ['numberOfCompletedIssues' => $project->getIssuesByStatus('closed')])
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
            'subtitle' => 'of ' . $project->getTotalEstimatedHours() . 'h estimated (' . $project->getTotalOfferHours() . 'h from offers)'
        ])
    </div>

    <div class="col-6 col-md-4 col-lg-3">
        @include('components.card', [
            'title' => __('Project Value'),
            'icon' => 'trending-up',
            'text' => App\Http\Controllers\OfferController::calculateTotal($project->id),
            'subtitle' => __(':acceptedOffers accepted offers', ['acceptedOffers' => App\Http\Controllers\OfferController::getOffersForProject($project->id)->where('status', 'accepted')->count()])
        ])
    </div>
</div>