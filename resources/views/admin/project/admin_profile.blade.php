@extends('admin.admin_master')
@section('title', 'My Account')
@section('page_title', 'My Account')
@section('maincontent')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                class="rounded-circle avatar-xxl img-thumbnail float-start" alt="image profile">

                            <div class="overflow-hidden ms-4">
                                <h4 class="m-0 text-dark fs-20">{{ $profileData->name }}</h4>
                                <p class="my-1 text-muted fs-16">{{ $profileData->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane pt-4 active show" id="profile_setting" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card border mb-0">

                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Personal Information</h4>
                                    </div>

                                    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="input-group mb-3 row">
                                                <label class="form-label">Name</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <input type="text" class="form-control" value="{{ $profileData->name }}"
                                                        placeholder="Name" name="name">
                                                </div>
                                            </div>

                                            <div class="input-group mb-3 row">
                                                <label class="form-label">Email-Adresse</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <input type="email" class="form-control"
                                                        value="{{ $profileData->email }}" placeholder="Email" name="email">
                                                </div>
                                            </div>

                                            <div class="input-group mb-3 row">
                                                <label class="form-label">Telefonnummer</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <input type="text" class="form-control"
                                                        value="{{ $profileData->phone }}" placeholder="Telefonnummer"
                                                        name="phone">
                                                </div>
                                            </div>

                                            <div class="input-group mb-3 row">
                                                <label class="form-label">Adresse</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <textarea class="form-control" name="address"
                                                        placeholder="Adresse">{{ $profileData->address }}</textarea>
                                                </div>
                                            </div>

                                            <div class="input-group mb-3 row">
                                                <label class="form-label">Profilbild</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" name="photo"
                                                            id="profile_image">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group mb-3 row">
                                                <label class="form-label"></label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <img id="show_profile_image"
                                                        src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                                        class="rounded-circle avatar-xxl img-thumbnail float-start"
                                                        alt="image profile">
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Save Changes</button>

                                        </div><!--end card-body-->
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-6">
                                <div class="card border mb-0">

                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Change Password</h4>
                                    </div>

                                    <form action="{{ route('admin.password.update') }}" method="POST">
                                        @csrf
                                        <div class="card-body mb-0">
                                            <div class="form-group mb-3 row">
                                                <label class="form-label">Old Password</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <input class="form-control @error('old_password') is-invalid @enderror"
                                                        type="password" placeholder="Old Password" name="old_password"
                                                        id="old_password">
                                                    @error('old_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="form-label">New Password</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <input class="form-control @error('new_password') is-invalid @enderror"
                                                        type="password" placeholder="New Password" name="new_password"
                                                        id="new_password">
                                                    @error('new_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="form-label">Confirm Password</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <input class="form-control" type="password"
                                                        placeholder="Confirm Password" name="new_password_confirmation"
                                                        id="new_password_confirmation">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-lg-12 col-xl-12">
                                                    <button type="submit" class="btn btn-primary">Change
                                                        Password</button>
                                                </div>
                                            </div>
                                        </div><!--end card-body-->
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end education -->

                </div>
            </div>
        </div>
    </div>
@endsection