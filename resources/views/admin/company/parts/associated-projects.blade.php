<div class="card">
    <div class="card-body">
        <div class="card-header mb-4">
            <h2 class="card-title">{{ __('Associated Projects') }}</h2>
            @if ($projects->count() > 0)
                <ul class="list mt-6 gap-4">
                    @foreach ($projects as $project)
                        <li
                            class="list-row relative items-start md:items-center bg-base-300/15 dark:bg-base-300/30 border-1 border-dashed border-base-300/60 dark:border-base-content/10">
                            <div class="flex gap-3 md:list-col-grow">
                                <x-project-status size="lg" :type="$project->status->name" />
                                <div>
                                    <h3>{{ $project->name }}</h3>
                                    <p>{{ $project->description }}</p>
                                    @if (!empty($project->due_date))
                                        <p class="flex items-baseline gap-1 mt-2">
                                            <i class="icon icon-xs icon-calendar"></i>
                                            <span
                                                class="text-xs opacity-70">{{ __('Due :dueDate', ['dueDate' => $project->due_date->format('d.m.Y')]) }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('admin.projects.show', $project->id) }}"
                                class="btn btn-square btn-neutral btn-outline btn-sm ml-auto before:inset-0 before:absolute before:z-10">
                                <i class="icon icon-eye icon-sm"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty">
                    <i class="icon icon-lg icon-folder mb-2 block"></i>
                    <p class="text-sm">{{ __('No projects associated with this company') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>