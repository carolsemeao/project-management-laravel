@extends('admin.admin_single_template')
@section('title', __('Edit Company: :company', ['company' => $company->name]))
@section('page_title')
    <div class="content__header-title">
        <h1>{{ __('Edit Company: :company', ['company' => $company->name]) }}</h1>
        <p class="text-sm opacity-60">{{ __('Update customer contact information and details') }}</p>
    </div>
@endsection
@section('back_to_route', route('admin.company', $company->id))
@section('back_to_text', __('Back to Overview'))

@section('maincontent')
    <div class="md:grid md:grid-cols-12 gap-4">
        <!-- Left Column - Main Content -->
        <div class="md:col-span-8">
            @if($errors->any())
                <div class="alert alert-error alert-soft mb-8 items-start" role="alert">
                    <i class="icon icon-sm icon-alert-triangle mt-[0.1em]"></i>
                    <span>{{ __('Please mind the highlighted fields.') }}</span>
                </div>
            @endif
            <form action="{{ route('admin.company.update', $company->id) }}" method="POST" id="companyEditForm">
                @method('PUT')
                @csrf
                <!-- Contact Information Card -->
                <div class="card mb-6">
                    <div class="card-body">
                        <h2 class="card-title mb-4">{{ __('Contact Information') }}</h2>
                        <div class="grid md:grid-cols-2 gap-x-3 gap-y-5">
                            <fieldset class="fieldset mb-4">
                                <legend class="fieldset-legend">{{ __('Email') }}</legend>
                                <input type="text" class="input w-full @error('email') input-error @enderror" id="email"
                                    name="email" value="{{ old('email', $company->email) }}">
                                @error('email')
                                    <div class="text-error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </fieldset>
                            <div class="flex items-start gap-2">
                                <i class="icon icon-sm icon-globe"></i>
                                <div class="info-box">
                                    <p class="font-medium opacity-70 mb-1">{{ __('Website') }}</p>
                                    <span>{{ $company->website ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="icon icon-sm icon-phone"></i>
                                <div class="info-box">
                                    <p class="font-medium opacity-70 mb-1">{{ __('Phone') }}</p>
                                    <span>{{ $company->phone ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="icon icon-sm icon-buildings"></i>
                                <div class="info-box">
                                    <p class="font-medium opacity-70 mb-1">{{ __('Address') }}</p>
                                    <address class="not-italic">
                                        {{ $company->address }}<br>
                                        {{ $company->zip }}
                                        {{ $company->city }}{{ $company->state ? ", $company->state" : '' }}<br>
                                        {{ $company->country }}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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