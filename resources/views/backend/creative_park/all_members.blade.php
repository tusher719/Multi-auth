@extends('admin.admin_dashboard')
@section('admin')

    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        @if ($message = Session::get('success'))
            <div class="alert alert-info">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title d-flex">
                            <div>Creative Park All Members <span class="badge bg-primary mx-1">{{ $total }}</span></div>
                            <div class="mx-4">Active <span class="badge bg-success mx-1">{{ $activeUser }}</span></div>
                            <div>Banned <span class="badge bg-danger mx-1">{{ $inactiveUser }}</span></div>
                            <button style="margin-left: 80px;" class="btn btn-danger btn-xs removeAll">Remove All Selected Data</button>
                        </h6>

{{--                        <div class="table-responsive">--}}
                        {{-- <div class="">
                            <table id="dataTableExample" class="table table-hover">
                                <thead>
                                <tr class="bg-dark text-white-50 ">
                                    <th><input type="checkbox" class="form-check-input" id="checkboxesMain"></th>
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
                                @if($students->count())
                                    @foreach ($students as $key => $item)
                                        <tr id="tr_{{$item->id}}">
                                            <td><input type="checkbox" class="checkbox form-check-input" data-id="{{$item->id}}"></td>
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
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="badge border border-danger text-danger">
                                                        <i data-feather="user-x" class="icon-sm" width="24" height="24" ></i>
                                                        Banned
                                                    </span>
                                                @endif
                                            <td>
                                                <div class="dropdown">
                                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" class="btn" aria-haspopup="true" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-lg text-muted pb-3px"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if(Auth::user()->can('admin.edit'))
                                                            <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" href="{{ route('cp.view.details',$item->id) }}">
                                                                <i data-feather="eye" class="icon-sm" width="24" height="24" ></i>
                                                                <span class="mx-3">View Profile</span>
                                                            </a>
                                                        @endif
                                                        @if(Auth::user()->can('admin.delete'))
                                                            <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" href="{{ route('cp.clone.students',$item->id) }}">
                                                                <i data-feather="copy" class="icon-sm" width="24" height="24" ></i>
                                                                <span class="mx-3">Clone Data</span>
                                                            </a>
                                                        @endif
                                                        @if(Auth::user()->can('admin.edit'))
                                                            <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" href="{{ route('cp.edit.students',$item->id) }}">
                                                                <i data-feather="edit-2" class="icon-sm" width="24" height="24" ></i>
                                                                <span class="mx-3">Edit Profile</span>
                                                            </a>
                                                        @endif
                                                        @if(Auth::user()->can('admin.delete'))
                                                            <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" id="delete" href="{{ route('cp.delete.students',$item->id) }}">
                                                                <i data-feather="trash-2" class="icon-sm" width="24" height="24"></i>
                                                                <span class="mx-3">Delete</span>
                                                            </a>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <div class="d-flex align-items-center">
                                                            @if($item->status == 'active')
                                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.inactive.students',$item->id) }}">
                                                                    <i data-feather="user-x" class="icon-sm text-danger" width="24" height="24" ></i>
                                                                    <span class="mx-3 text-danger">Banned</span>
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.active.students',$item->id) }}">
                                                                    <i data-feather="user-check" class="icon-sm text-success" width="24" height="24" ></i>
                                                                    <span class="mx-3 text-success">Active</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            @foreach ($students as $key => $item)
                                <div class="col-md-3 mb-4">

                                <div class="card">
                                    <div class="card-body">
                                        <div style="position: absolute; top: 10px; right: 10px">
                                            @if($item->status == 'active')
                                                <span class="badge text-success">
                                                    <i data-feather="user-check" class="icon-sm" width="24" height="24" ></i>
                                                        Active
                                                    </span>
                                            @else
                                                <span class="badge text-danger">
                                                        <i data-feather="user-x" class="icon-sm" width="24" height="24" ></i>
                                                        Banned
                                                    </span>
                                            @endif
                                        </div>
                                        <div class="d-flex mt-2">
                                            <div style="margin-right: 20px;">
                                                <img src="{{ (!empty($item->photo)) ? url('uploads/students_img/'.$item->photo) : url('uploads/no_image.jpg') }}" width="100px" class="rounded img-fluid" alt="...">
                                            </div>
                                            <div>
                                                <h5 class="card-title mb-3">{{ $item->name }}</h5>
                                                <h6 class="card-subtitle mb-3 text-body-secondary">{{ $item->student_id }}</h6>
                                                <h6 class="card-subtitle mb-3 text-body-secondary">{{ $item->phone }}</h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">{{ $item->email }}</h6>
                                                <div class="d-flex">

                                                    @if(Auth::user()->can('admin.edit'))
                                                        <a class="dropdown-item d-flex align-items-center text-sm" style="font-size: 12px;" href="{{ route('cp.view.details',$item->id) }}">
                                                            <i data-feather="eye" class="icon-sm" width="24" height="24" ></i>
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->can('admin.delete'))
                                                        <a class="dropdown-item d-flex align-items-center" style="font-size: 12px;" href="{{ route('cp.clone.students',$item->id) }}">
                                                            <i data-feather="copy" class="icon-sm" width="24" height="24" ></i>
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->can('admin.edit'))
                                                        <a class="dropdown-item d-flex align-items-center" style="font-size: 12px;" href="{{ route('cp.edit.students',$item->id) }}">
                                                            <i data-feather="edit-2" class="icon-sm" width="24" height="24" ></i>
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->can('admin.delete'))
                                                        <a class="dropdown-item d-flex align-items-center" style="font-size: 12px;" id="delete" href="{{ route('cp.delete.students',$item->id) }}">
                                                            <i data-feather="trash-2" class="icon-sm" width="24" height="24"></i>
                                                        </a>
                                                    @endif
                                                        @if($item->status == 'active')
                                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.inactive.students',$item->id) }}">
                                                                <i data-feather="user-x" class="icon-sm text-danger" width="24" height="24" ></i>
                                                            </a>
                                                        @else
                                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('cp.active.students',$item->id) }}">
                                                                <i data-feather="user-check" class="icon-sm text-success" width="24" height="24" ></i>
                                                            </a>
                                                        @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script type = "text/javascript" >
        $(document).ready(function() {
            $('#checkboxesMain').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked', false);
                }
            });
            $('.checkbox').on('click', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#checkboxesMain').prop('checked', true);
                } else {
                    $('#checkboxesMain').prop('checked', false);
                }
            });
            $('.removeAll').on('click', function(e) {
                var userIdArr = [];
                $(".checkbox:checked").each(function() {
                    userIdArr.push($(this).attr('data-id'));
                });
                if (userIdArr.length <= 0) {
                    alert("Choose min one item to remove.");
                } else {
                    if (confirm("Are you sure you want to delete")) {
                        var stuId = userIdArr.join(",");
                        $.ajax({
                            url: "{{url('creative-park/students/delete-all')}}",
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'ids=' + stuId,
                            success: function(data) {
                                if (data['status'] == true) {
                                    $(".checkbox:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['message']);
                                } else {
                                    alert('Error occured.');
                                }
                            },
                            error: function(data) {
                                alert(data.responseText);
                            }
                        });
                    }
                }
            });
        });
    </script>

@endsection
