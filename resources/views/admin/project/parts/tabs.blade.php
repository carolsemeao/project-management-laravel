<div class="tabs tabs-lift mt-6">
    <input type="radio" name="project_information" class="tab" aria-label="{{ __('Overview') }}" checked="checked" />
    <div class="tab-content bg-base-100 border-base-300/60 dark:border-base-content/10 border-dashed p-6">
        @include('admin.project.parts.tab-overview')
    </div>

    <input type="radio" name="project_information" class="tab"
        aria-label="{{ __('Issues (:issuesCount)', ['issuesCount' => $project->issues()->count()]) }}" />
    <div class="tab-content bg-base-100 border-base-300/60 dark:border-base-content/10 border-dashed p-6">
        @include('admin.project.parts.tab-issues')
    </div>

    <input type="radio" name="project_information" class="tab"
        aria-label="{{ __('Offers (:offersCount)', ['offersCount' => $offers->count()]) }}" />
    <div class="tab-content bg-base-100 border-base-300/60 dark:border-base-content/10 border-dashed p-6">
        @include('admin.project.parts.tab-offers')
    </div>

    <input type="radio" name="project_information" class="tab" aria-label="{{ __('Analytics') }}" />
    <div class="tab-content bg-base-100 border-base-300/60 dark:border-base-content/10 border-dashed p-6">
        @include('admin.project.parts.tab-analytics')
    </div>

    <input type="radio" name="project_information" class="tab" aria-label="{{ __('Activity') }}" />
    <div class="tab-content bg-base-100 border-base-300/60 dark:border-base-content/10 border-dashed p-6">
        @include('admin.project.parts.tab-activity')
    </div>
</div>