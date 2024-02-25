@extends('admin.admin_dashboard')
@section('admin')

    <!-- cdn link -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Creative Park</li>
                <li class="breadcrumb-item active" aria-current="page">All Members</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-2">
                @if(Auth::user()->can('admin.add'))
                    <div class="col-md-12 mt-3 mb-3">
                        <a href="{{ route('add.cp.member') }}" class="btn btn-inverse-info">
                            <i class="btn-icon-prepend mx-1" data-feather="user-plus" width="18" height="18"></i>
                            Add New Student
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-md-2">
                <div class="col-md-12 mt-3 mb-3">
                    <a href="{{ route('import.students') }}" class="btn btn-inverse-success">
                        <i class="btn-icon-prepend" data-feather="arrow-up" width="18" height="18"></i>
                        Import
                    </a>

                    <a href="{{ route('export.student') }}" class="btn btn-inverse-danger">
                        <i class="btn-icon-prepend" data-feather="arrow-down" width="18" height="18"></i>
                        Export
                    </a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title d-flex">
                            <div>Creative Park All Members <span class="badge border border-primary text-secondary mx-1">{{ $total }}</span></div>
                            <div class="mx-4">Active Students : <span class="badge border border-success text-success mx-1">{{ $activeUser }}</span></div>
                            <div>InActive Students : <span class="badge border border-danger text-danger mx-1">{{ $inactiveUser }}</span></div>
                        </h6>

{{--                        <div class="table-responsive">--}}
                        <div class="">
                            <table id="dataTableExample" class="table">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Student Id</th>
                                    <th>Student Name</th>
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
                                                <span class="badge border border-success text-success">
                                                    <i data-feather="user-check" class="icon-sm" width="24" height="24" ></i>
                                                    {{$item->status}}
                                                </span></td>
                                            @else
                                            <span class="badge border border-danger text-danger">
                                                <i data-feather="user-x" class="icon-sm" width="24" height="24" ></i>
                                                {{$item->status}}
                                            </span>
                                            @endif
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
                                                                <i data-feather="eye" class="icon-sm" width="24" height="24" ></i>
                                                                <span class="mx-3">View Profile</span>
                                                            </a>
                                                        @endif
                                                            @if(Auth::user()->can('admin.delete'))
                                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.clone.students',$item->id) }}">
                                                                    <i data-feather="copy" class="icon-sm" width="24" height="24" ></i>
                                                                    <span class="mx-3">Clone Data</span>
                                                                </a>
                                                            @endif
                                                            @if(Auth::user()->can('admin.edit'))
                                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.edit.students',$item->id) }}">
                                                                    <i data-feather="edit-2" class="icon-sm" width="24" height="24" ></i>
                                                                    <span class="mx-3">Edit Profile</span>
                                                                </a>
                                                            @endif
                                                            @if(Auth::user()->can('admin.delete'))
                                                                <a class="dropdown-item d-flex align-items-center" id="delete" href="{{ route('cp.delete.students',$item->id) }}">
                                                                    <i data-feather="trash-2" class="icon-sm" width="24" height="24"></i>
                                                                    <span class="mx-3">Delete</span>
                                                                </a>
                                                            @endif
                                                            <div class="dropdown-divider"></div>
                                                            <div class="d-flex align-items-center">
                                                                @if($item->status == 'active')
                                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.inactive.students',$item->id) }}">
                                                                        <i data-feather="user-x" class="icon-sm text-danger" width="24" height="24" ></i>
                                                                        <span class="mx-3 text-danger">Inactive {{ $item->id }}</span>
                                                                    </a>
                                                                @else
                                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.active.students',$item->id) }}">
                                                                        <i data-feather="user-check" class="icon-sm text-success" width="24" height="24" ></i>
                                                                        <span class="mx-3 text-success">Active {{ $item->id }}</span>
                                                                    </a>
                                                                @endif
                                                            </div>
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
