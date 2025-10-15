@extends('admin.admin_single_template')
@section('title', 'Project / ' . $project->name)
@section('page_title')
    <div class="content__header-title">
        <h1>{{ $project->name }}</h1>
        @if ($project->description)
            <p class="text-sm opacity-60">{{ $project->description }}</p>
        @endif
    </div>
@endsection
@section('back_to_route', route('admin.projects'))
@section('back_to_text', __('Back'))
@section('header_actions')
    <div class="join">
        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-soft join-item">
            <span class="icon icon-sm icon-edit me-2"></span>
            {{ __('Edit Project') }}
        </a>
        <a class="btn btn-soft join-item" href="#">
            <span class="icon icon-sm icon-settings me-2"></span>
            {{ __('Settings') }}
        </a>
    </div>
@endsection

@section('maincontent')
    @include('admin.project.parts.project-meta', ['project' => $project])
    @include('admin.project.parts.tabs')
@endsection
@push('scripts')
    @include('components.chart-script')
@endpush