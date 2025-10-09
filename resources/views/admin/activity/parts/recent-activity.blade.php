@if($recentActivities && $recentActivities->count() > 0)
    <div class="activity-list">
        @foreach($recentActivities as $activityGroup)
            <div class="activity-date-group mb-4 last-of-type:mb-0">
                <h4 class="opacity-70 mb-2">
                    {{ $activityGroup['formatted_date'] }}
                </h4>
                <div>
                    @foreach($activityGroup['activities'] as $activity)
                        <article class="activity-list__item">
                            @switch($activity->type)
                                @case('user_assigned')
                                    <div class="activity-list__item-icon activity-list__item-icon--user bg-base-200 text-base-content dark:bg-neutral-content dark:text-neutral"></div>
                                    @break
                                @case('time_logged')
                                    <div class="activity-list__item-icon activity-list__item-icon--time bg-info/40 text-info-content"></div>
                                    @break
                                @case('issue_created')
                                    <div class="activity-list__item-icon activity-list__item-icon--created bg-success/40 text-success-content"></div>
                                    @break
                                @case('status_changed')
                                @case('priority_changed')
                                    <div class="activity-list__item-icon activity-list__item-icon--status bg-warning/40 text-warning-content"></div>
                                    @break
                                @default
                                    <div class="activity-list__item-icon activity-list__item-icon--default bg-base-300 text-base-content"></div>
                            @endswitch

                            <div class="activity-list__item-content">
                                <div class="activity-list__item-content-title">
                                    {{ $activity->description }}
                                </div>
                                <div class="activity-list__item-content-subtitle">
                                    <span>
                                        {{ $activity->time_ago }} - {{ $activity->created_at->format('H:i') }}
                                    </span>
                                    @if($activity->project)
                                        <span>•</span>
                                        <span>
                                            {{ $activity->project->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($activity->issue)
                                <a href="{{ route('admin.issues.show', $activity->issue->id) }}"
                                    class="activity-list__item-link">
                                    <span class="icon icon-md icon-arrow-right"></span>
                                </a>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty">
        <span class="icon icon-lg icon-activity mb-2 block"></span>
        <p class="text-sm">{{ __('No recent activity yet') }}</p>
        <p class="text-xs mt-1">{{ __('Start logging time or creating issues to see your activity here') }}</p>
    </div>
@endif