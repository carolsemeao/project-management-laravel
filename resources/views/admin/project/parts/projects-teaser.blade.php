<div>
    @foreach ($userProjects as $project)
        <a href="{{ route('admin.projects.show', $project->id) }}"
            class="card card-sm group mb-4 transition-all duration-200 border-1 border-dashed border-base-300/60 hover:border-base-content dark:border-base-content/10 bg-white/50 hover:bg-base-300/60 hover:text-base-content dark:hover:text-neutral-content dark:bg-base-200 dark:hover:bg-neutral dark:hover:bg-neutral dark:hover:text-neutral-content">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="card-title mb-1.5">{{ $project->name }}</h3>
                        <p>{{ Str::limit($project->description, 100) }}</p>
                    </div>
                    <span class="badge badge-sm badge-dash">
                        {{ $project->getFormattedStatusName() }}
                    </span>
                </div>
                <div class="mt-1 flex justify-between items-center">
                    <p
                        class="transition-all duration-200 group-hover:text-base-content text-neutral/70 dark:text-neutral-content/70 dark:group-hover:text-neutral-content/90">
                        {{ __('Last Updated') }}: {{ $project->updated_at->format('d/m/Y') }}</p>
                    <p
                        class="transition-all duration-200 group-hover:text-base-content text-neutral/70 dark:text-neutral-content/70 dark:group-hover:text-neutral-content/90 text-end">
                        {{ $project->getOpenIssuesCount() }} {{ __('open issue(s)') }}</p>
                </div>
            </div>
        </a>
    @endforeach
</div>