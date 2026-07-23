@extends('admin.admin_single_template')
@section('title', $company->name)
@section('page_title')
    <div class="content__header-title">
        <h1>
            <i class="icon icon-buildings icon-lg"></i>
            {{ $company->name }}
        </h1>
    </div>
@endsection
@section('back_to_route', route('admin.companies'))
@section('back_to_text', __('Back to Overview'))
@section('header_actions')
    <a href="{{ route('admin.company.edit', $company->id) }}" class="btn btn-soft join-item">
        <span class="icon icon-sm icon-edit me-2"></span>
        {{ __('Edit') }}
    </a>
@endsection

@section('maincontent')
    <div class="md:grid md:grid-cols-12 gap-4">
        <!-- Left Column - Main Content -->
        <div class="md:col-span-8">
            @include('admin.company.parts.contact-information')
            @include('admin.company.parts.registered-employees')
            @include('admin.company.parts.associated-projects')
        </div>

        <!-- Right Column - Sidebar -->
        <div class="md:col-span-4">
            @include('admin.company.parts.quick-stats')
            @include('admin.company.parts.quick-actions')
        </div>
    </div>
@endsection