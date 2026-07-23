@extends('admin.admin_master')
@section('title', 'Customers')
@section('page_title', 'Customers')
@section('page_subtitle', 'Manage your customer contacts and relationships')
@section('header_actions')
    <div class="join">
        <a class="btn join-item" href="{{ route('admin.customer.create') }}"> <!-- TODO: Create Company -->
            <span class="icon icon-sm icon-plus me-2"></span>
            {{ __('New Company') }}
        </a>
        <a class="btn join-item" href="{{ route('admin.customer.create') }}">
            <span class="icon icon-sm icon-plus me-2"></span>
            {{ __('New Customer') }}
        </a>
    </div>
@endsection
@section('maincontent')
    {{-- @var $customers \Illuminate\Pagination\LengthAwarePaginator --}}
    @include('admin.customer.parts.stats')
    <div class="card mt-6">
        <div class="card-body">
            <div class="card-header mb-4">
                <h2 class="card-title">{{ __('Customer Directory') }}</h2>
                <p class="text-xs opacity-70">{{ __('Search and manage your customer contacts') }}</p>
            </div>
            @php
                /** @var \Illuminate\Pagination\LengthAwarePaginator $customers */
            @endphp
            @include('admin.customer.parts.search')
            @include('admin.customer.parts.search-results')
            @if($customers->hasPages())
                <div class="mt-6">
                    {{ $customers->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection