@extends('admin.admin_master')
@section('title', 'Issues')
@section('page_title', 'Issues')
@section('page_subtitle', 'Track and manage project issues')
@section('header_actions')
    <div class="content__header-actions">
        <form method="GET" action="{{ route('admin.issues') }}" id="project-filter">
            <select class="select w-60" id="project_id" name="project_id" onchange="handleProjectFilter(this)">
                <option value="">{{ __('All Projects') }}</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ $projectId == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('admin.issues.create') }}" class="btn btn-neutral text-nowrap">
            <span class="icon icon-sm icon-plus"></span>
            {{ __('New Issue') }}
        </a>
    </div>
@endsection

@section('maincontent')
    {{-- @var $issues \Illuminate\Pagination\LengthAwarePaginator --}}
    <div class="card">
        <div class="card-body">
            <div class="card-header mb-4">
                <h2 class="card-title">
                    @php
                        /** @var \Illuminate\Pagination\LengthAwarePaginator $issues */
                    @endphp
                    {{ $issues->total() }} {{ __('open issues') }}
                </h2>
            </div>
            @include('admin.issue.parts.issues', ['issues' => $issues])

            @if($issues->hasPages())
                <div class="mt-6">
                    {{ $issues->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function handleProjectFilter(selectElement) {
            const form = document.getElementById('project-filter');
            const selectedValue = selectElement.value;

            if (selectedValue === '') {
                window.location.href = '{{ route('admin.issues') }}';
            } else {
                form.submit();
            }
        }
    </script>
@endpush