@extends('admin.admin_master')
@section('title', __('Settings'))
@section('page_title', __('Settings'))
@section('maincontent')
    <div class="card">
        <div class="card-body">
            <div class="flex items-center gap-4">
                <div class="avatar">
                    <div class="w-25 rounded-full border-3 border-base-content/10 dark:border-base-content/20">
                        <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                            alt="image profile">
                    </div>
                </div>
                <div>
                    <h2>{{ $profileData->name }}</h2>
                    <p class="opacity-70">{{ $profileData->email }}</p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <div class="card-header">
                        <h2 class="card-title">{{ __('Personal Information') }}</h2>
                    </div>

                    <form action="{{ route('admin.edit.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <fieldset class="fieldset mb-3">
                            <legend class="fieldset-legend">{{ __('Name') }}</legend>
                            <input type="text" class="input w-full" value="{{ $profileData->name }}"
                                placeholder="{{ __('Enter Name') }}" name="name">
                        </fieldset>

                        <fieldset class="fieldset mb-3">
                            <legend class="fieldset-legend">{{ __('Email Address') }}</legend>
                            <input type="email" class="input w-full" value="{{ $profileData->email }}"
                                placeholder="{{ __('Enter Email Address') }}" name="email">
                        </fieldset>

                        <fieldset class="fieldset mb-3">
                            <legend class="fieldset-legend">{{ __('Profile Image') }}</legend>
                            <input type="file" class="file-input" name="photo" id="profile_image">
                        </fieldset>

                        <div class="flex items-center gap-4 justify-end">
                            <button type="submit" class="btn btn-neutral">
                                <span class="icon icon-sm icon-save me-2"></span>
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div>
                    <div class="card-header">
                        <h2 class="card-title">{{ __('Change Password') }}</h2>
                    </div>

                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        <fieldset class="fieldset mb-3">
                            <legend class="fieldset-legend">{{ __('Old Password') }}</legend>
                            <input type="password" class="input w-full @error('old_password') is-invalid @enderror"
                                placeholder="{{ __('Enter Old Password') }}" name="old_password" id="old_password">
                            @error('old_password')
                                <div class="validator-hint hidden">{{ $message }}</div>
                            @enderror
                        </fieldset>

                        <fieldset class="fieldset mb-3">
                            <legend class="fieldset-legend">{{ __('New Password') }}</legend>
                            <input type="password" class="input w-full @error('new_password') is-invalid @enderror"
                                placeholder="{{ __('Enter New Password') }}" name="new_password" id="new_password">
                            @error('new_password')
                                <div class="validator-hint hidden">{{ $message }}</div>
                            @enderror
                        </fieldset>

                        <fieldset class="fieldset mb-3">
                            <legend class="fieldset-legend">{{ __('Confirm Password') }}</legend>
                            <input type="password" class="input w-full" placeholder="{{ __('Confirm Password') }}"
                                name="new_password_confirmation" id="new_password_confirmation">
                        </fieldset>

                        <div class="flex items-center gap-4 justify-end">
                            <button type="submit" class="btn btn-neutral">
                                <span class="icon icon-sm icon-save me-2"></span>
                                {{ __('Change Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection