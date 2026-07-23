@extends('admin.admin_master')
@section('title', __('Customers'))
@section('page_title', __('Customers'))
@section('page_subtitle', __('Manage your customer contacts and relationships'))
@section('header_actions')
    <a class="btn" href="{{ route('admin.company.create') }}">
        <span class="icon icon-sm icon-plus me-2"></span>
        {{ __('New Customer') }}
    </a>
@endsection
@section('maincontent')
    {{-- @var $companies \Illuminate\Pagination\LengthAwarePaginator --}}
    @include('admin.company.parts.stats')
    <div class="card mt-6">
        <div class="card-body">
            <div class="card-header mb-4">
                <h2 class="card-title">{{ __('Customer Directory') }}</h2>
                <p class="text-xs opacity-70">{{ __('Search and manage your customer contacts') }}</p>
            </div>
            @php
                /** @var \Illuminate\Pagination\LengthAwarePaginator $companies */
            @endphp
            @include('admin.company.parts.search')
            @include('admin.company.parts.search-results')
            @if($companies->hasPages())
                <div class="mt-6">
                    {{ $companies->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection