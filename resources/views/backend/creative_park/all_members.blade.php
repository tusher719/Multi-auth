@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Creative Park</li>
                <li class="breadcrumb-item active" aria-current="page">All Members</li>
            </ol>
        </nav>

        <div class="row">
            @if(Auth::user()->can('admin.add'))
                <div class="col-md-12 mt-3 mb-3">
                    <a href="{{ route('add.cp.member') }}" class="btn btn-inverse-info">
                        <i class="btn-icon-prepend" data-feather="user-plus"></i>
                        Add Student
                    </a>
                </div>
            @endif
        </div>


        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Creative Park All Members</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Studend Id</th>
                                    <th>Studend Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Batch</th>
                                    <th>Section</th>
                                    <th>Blood</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            <img class="wd-100 rounded-circle" src="{{ (!empty($item->photo)) ? url('uploads/students_img/'.$item->photo) : url('uploads/no_image.jpg') }}" alt="profile">
                                        </td>
                                        <td>{{ $item->student_id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->batch }}th</td>
                                        <td>{{ $item->section }}</td>
                                        <td>{{ $item->blood }}</td>
                                        <td>
                                            @if($item->status == 'active')
                                                <span class="badge border border-success text-success">{{ $item->status }}</span></td>
                                            @elseif($item->status == 'inactive')
                                            <span class="badge border border-danger text-danger">{{ $item->status }}</span></td>
                                            @endif
                                        </td>
                                        <td>
{{--                                            @if(Auth::user()->can('admin.edit'))--}}
{{--                                                <a href="{{ route('cp.edit.students',$item->id) }}" class="btn btn-inverse-primary">View</a>--}}
{{--                                            @endif--}}
{{--                                            @if(Auth::user()->can('admin.edit'))--}}
{{--                                                <a href="{{ route('cp.edit.students',$item->id) }}" class="btn btn-inverse-warning">Edit</a>--}}
{{--                                            @endif--}}
{{--                                            @if(Auth::user()->can('admin.delete'))--}}
{{--                                                    <a href="{{ route('cp,delete.students',$item->id) }}" class="btn btn-inverse-danger" id="delete">Delete</a>--}}
{{--                                            @endif--}}
                                                <div class="dropdown">
                                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" class="btn" aria-haspopup="true" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings icon-lg text-muted pb-3px">
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                                        </svg>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if(Auth::user()->can('admin.edit'))
                                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.view.details',$item->id) }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye icon-sm me-2">
                                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                    <circle cx="12" cy="12" r="3"></circle>
                                                                </svg>
                                                                <span class="">View Profile</span>
                                                            </a>
                                                        @endif
                                                            @if(Auth::user()->can('admin.edit'))
                                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 icon-sm me-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                    </svg>
                                                                    <span class="">Edit Profile</span>
                                                                </a>
                                                            @endif
                                                            @if(Auth::user()->can('admin.delete'))
                                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 icon-sm me-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                    </svg>
                                                                    <span class="">Delete</span>
                                                                </a>
                                                            @endif
                                                    </div>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection
