@php
    $colorClasses = "w-8 h-8 rounded-full flex items-center justify-center";
    $iconClasses = "icon icon-sm icon-";
@endphp
@if($recentActivities && $recentActivities->count() > 0)
    <div>
        @foreach($recentActivities as $activity)
            <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-base-200/80 transition-colors duration-200 relative">
                <div class="flex-shrink-0">
                    @switch($activity->type)
                        @case('time_logged')
                            <div class="bg-info/40 {{ $colorClasses }}">
                                <span class="{{ $iconClasses }}clock text-info-content"></span>
                            </div>
                            @break
                        @case('issue_created')
                            <div class="bg-success/40 {{ $colorClasses }}">
                                <span class="{{ $iconClasses }}plus text-success-content"></span>
                            </div>
                            @break
                        @case('status_changed')
                        @case('priority_changed')
                            <div class="bg-warning/40 {{ $colorClasses }}">
                                <span class="{{ $iconClasses }}refresh-cw text-warning-content"></span>
                            </div>
                            @break
                        @default
                            <div class="bg-base-300 {{ $colorClasses }}">
                                <span class="{{ $iconClasses }}activity text-base-content/70"></span>
                            </div>
                    @endswitch
                </div>

                <div class="flex-1 min-w-0">
                    <div class="text-sm">
                        {{ $activity->description }}
                    </div>
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="text-xs text-base-content/70">
                            {{ $activity->time_ago }}
                        </span>
                        @if($activity->project)
                            <span class="text-xs text-base-content/50">•</span>
                            <span class="text-xs text-base-content/70">
                                {{ $activity->project->name }}
                            </span>
                        @endif
                    </div>
                </div>

                @if($activity->issue)
                    <a href="{{ route('admin.issues.show', $activity->issue->id) }}" 
                        class="text-primary self-center hover:text-primary-focus transition-colors shrink-0 before:absolute before:inset-0">
                        <span class="icon icon-md icon-arrow-right"></span>
                    </a>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-8 text-base-content/60">
        <span class="icon icon-lg icon-activity mb-2 block"></span>
        <p class="text-sm">{{ __('No recent activity yet') }}</p>
        <p class="text-xs mt-1">{{ __('Start logging time or creating issues to see your activity here') }}</p>
    </div>
@endif