@extends('admin.admin_master')
@section('title', __('My Account'))
@section('page_title', __('My Account'))
@section('maincontent')
    <div class="card">
        <div class="card-body">
            <ul class="list">
                <li class="list-row items-center p-0 gap-y-2">
                    <div class="avatar">
                        <div class="w-15 rounded-full border-3 border-base-content/10 dark:border-base-content/20">
                            <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                alt="image profile">
                        </div>
                    </div>
                    <div>
                        <h2>{{ $profileData->name }}</h2>
                        <p class="opacity-70">{{ $profileData->email }}</p>
                    </div>
                    <ul class="list-col-wrap">
                        <li><span class="font-medium">{{ __('Registered on:') }}</span>
                            {{ $profileData->created_at->format('d.m.Y') }}</li>
                        <li><span class="font-medium">{{ __('Last updated on:') }}</span>
                            {{ $profileData->updated_at->format('d.m.Y') }}</li>
                    </ul>
                </li>
            </ul>

            <div class="divider"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <div class="card-header mb-2">
                        <h3 class="card-title">{{ __('Issues') }}</h3>
                    </div>

                    <div class="overflow-x-auto mb-10">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-end">{{ __('Open') }}</th>
                                    <th class="text-end">{{ __('Closed') }}</th>
                                    <th class="text-end">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-semibold">{{__('Assigned')}}</td>
                                    <td class="text-end">{{$profileData->openIssuesCount()}}</td>
                                    <td class="text-end">{{$profileData->closedIssuesCount()}}</td>
                                    <td class="text-end">{{$profileData->assignedIssues()->count()}}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">{{__('Created')}}</td>
                                    <td class="text-end">{{$profileData->openCreatedIssuesCount()}}</td>
                                    <td class="text-end">{{$profileData->closedCreatedIssuesCount()}}</td>
                                    <td class="text-end">{{$profileData->createdIssues()->count()}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-header mb-2">
                        <h3 class="card-title">{{ __('Projects') }}</h3>
                    </div>

                    @if ($profileData->getGroupedProjectAssignments()->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('Role') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($profileData->getGroupedProjectAssignments() as $groupedAssignment)
                                        <tr>
                                            <td class="w-3/5">
                                                <a href="{{ route('admin.projects.show', $groupedAssignment->project->id) }}"
                                                    class="text-base-content hover:underline font-semibold text-nowrap p-0 h-fit">
                                                    {{ $groupedAssignment->project->name }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($groupedAssignment->roles->count() > 1)
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach ($groupedAssignment->roles as $role)
                                                            <x-badge :label="$role->name" />
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <x-badge :label="$groupedAssignment->roles->first()->name" />
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-5 opacity-70">
                            <span class="icon icon-huge icon-folder me-2"></span>
                            <p class="mb-0">{{ __('No project assigned to this user') }}</p>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="card-header mb-2">
                        <h3 class="card-title">{{ __('Activity') }}</h3>
                    </div>

                    @include('admin.activity.parts.recent-activity')
                </div>
            </div>
        </div>
    </div>
@endsection