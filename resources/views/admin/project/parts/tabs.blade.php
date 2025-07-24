<div class="row mt-5">
    <div class="col-12">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-bs-target="#pills-overview"
                    data-bs-toggle="pill">{{ __('Overview') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-target="#pills-issues"
                    data-bs-toggle="pill">{{ __('Issues (:issuesCount)', ['issuesCount' => $project->issues()->count()]) }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-target="#pills-offers"
                    data-bs-toggle="pill">{{ __('Offers (:offersCount)', ['offersCount' => App\Http\Controllers\OfferController::getOffersForProject($project->id)->count()]) }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-target="#pills-analytics"
                    data-bs-toggle="pill">{{ __('Analytics') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-target="#pills-activity"
                    data-bs-toggle="pill">{{ __('Activity') }}</a>
            </li>
        </ul>
        <div class="tab-content pt-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-overview" role="tabpanel"
                aria-labelledby="pills-overview-tab" tabindex="0">
                @include('admin.project.parts.tab-overview')
            </div>
            <div class="tab-pane fade" id="pills-issues" role="tabpanel" aria-labelledby="pills-issues-tab"
                tabindex="0">
                @include('admin.project.parts.tab-issues')
            </div>
            <div class="tab-pane fade" id="pills-offers" role="tabpanel" aria-labelledby="pills-offers-tab"
                tabindex="0">
                @include('admin.project.parts.tab-offers')
            </div>
            <div class="tab-pane fade" id="pills-analytics" role="tabpanel" aria-labelledby="pills-analytics-tab"
                tabindex="0">
                @include('admin.project.parts.tab-analytics')
            </div>
            <div class="tab-pane fade" id="pills-activity" role="tabpanel" aria-labelledby="pills-activity-tab"
                tabindex="0">
                @include('admin.project.parts.tab-activity')
            </div>
        </div>
    </div>
</div>