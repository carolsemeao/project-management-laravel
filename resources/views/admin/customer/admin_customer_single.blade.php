@extends('admin.admin_single_template')
@section('title', $customer->company->name . " - " . $customer->name)
@section('page_title')
    <div class="content__header-title">
        <h1>{{ $customer->name }} – {{ $customer->company->name }}</h1>
    </div>
@endsection
@section('back_to_route', route('admin.companies', ))
@section('back_to_text', __('Back to Overview'))

@section('maincontent')
    <div class="md:grid md:grid-cols-12 gap-4">
        <!-- Left Column - Main Content -->
        <div class="md:col-span-8">
            @include('admin.customer.parts.contact-information')
            @include('admin.customer.parts.associated-projects')
        </div>

        <!-- Right Column - Sidebar -->
        <div class="md:col-span-4">
            @include('admin.customer.parts.quick-actions')
            @include('admin.customer.parts.quick-stats')
        </div>
    </div>
@endsection