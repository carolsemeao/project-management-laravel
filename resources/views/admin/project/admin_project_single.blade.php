@extends('admin.admin_single_template')
@section('title', 'Project / ' . $project->name)
@section('content_header')
    @include('admin.project.parts.header', ['project' => $project])
@endsection
@section('page_title', 'test')
@section('page_subtitle', 'test')
@section('back_to_route', route('admin.projects'))
@section('back_to_text', __('Back'))
{{--
@extends('admin.project.admin_project_single_template')
@section('title', 'Project / ' . $project->name)
@section('page_title')
<div class="d-flex align-items-center">
    <span class="me-2 rounded-circle d-inline-block"
        style="width: 20px; height: 20px; background-color: {{ $project->color }};"></span>
    <span>{{ $project->name }}</span>
</div>
@if ($project->isOverdue())
<x-badge :label="__('Overdue')" textColor="text-danger" classes="ms-1 small" />
@elseif($project->isDueSoon())
<x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1 small" />
@endif
@endsection
@section('page_subtitle', $project->description)
@section('back_to_route', route('admin.projects'))
@section('back_to_text', __('Back to Projects'))

@section('header_actions')
<div class="btn-group">
    <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center" isLink="true"
        href="{{ route('admin.projects.edit', $project->id) }}">
        <span class="icon icon-sm icon-edit me-2"></span>
        {{ __('Edit') }}
    </x-button-primary>
    <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center">
        <span class="icon icon-sm icon-settings me-2"></span>
        {{ __('Settings') }}
    </x-button-primary>
</div>
@endsection

@section('project-header')
@include('admin.project.parts.header', ['project' => $project])
@endsection



@section('maincontent')
@include('admin.project.parts.project-meta', ['project' => $project])
@include('admin.project.parts.tabs')
@endsection --}}