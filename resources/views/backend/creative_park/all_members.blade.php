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
                        <button style="margin-left: 80px;" class="btn btn-danger btn-xs removeAll">Remove All Selected
                            Data</button>
                    </h6>

                    <div class="filter-form" style="margin-top: 30px;">
                        <form action="">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="group">
                                        <input type="text" class="inputGgle">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label class="labelGgle">Id</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="group">
                                        <input type="text" class="inputGgle">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label class="labelGgle">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="group">
                                        <input type="text" class="inputGgle">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label class="labelGgle">Student Id</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="group">
                                        <input type="text" class="inputGgle">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label class="labelGgle">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="group">
                                        <input type="text" class="inputGgle">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label class="labelGgle">Phone</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="group">
                                        <input type="text" class="inputGgle">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label class="labelGgle">Batch</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <select class="form-select" id="validationCustom04">
                                            <option selected disabled value="">Blood Group</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <select class="form-select" id="validationCustom04">
                                            <option selected disabled value="">Status</option>
                                        </select>
                                    </div>
                                </div>


                            </div>

                            <button type="submit" class="btn btn-success px-5">Search</button>
                            <a href="" class="btn btn-danger">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4">
            <!-- Student ID Input -->
            <input type="text" id="student_id" class="form-control" placeholder="student id">
            <img id="studentPhoto" src="{{ url('uploads/no-image2.jpg') }}" width="150px" class="rounded mt-3 img-fluid"
                alt="...">
        </div>
        <div class="col-md-8">
            <!-- Other fields that will be auto-filled -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Id" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="name" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="email" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="phone" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="phone_2" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="batch" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="section" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="gender" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="date" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="blood group" readonly>
                    </div>
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
                                            <i data-feather="user-check" class="icon-sm" width="24" height="24"></i>
                                            Active
                                        </span>
                                        @else
                                        <span class="badge text-danger">
                                            <i data-feather="user-x" class="icon-sm" width="24" height="24"></i>
                                            Banned
                                        </span>
                                        @endif
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div style="margin-right: 20px;">
                                            <img src="{{ (!empty($item->photo)) ? url('uploads/students_img/'.$item->photo) : url('uploads/no_image.jpg') }}"
                                                width="100px" class="rounded img-fluid" alt="...">
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-3">{{ $item->name }}</h5>
                                            <h6 class="card-subtitle mb-3 text-body-secondary">{{ $item->student_id }}
                                            </h6>
                                            <h6 class="card-subtitle mb-3 text-body-secondary">{{ $item->phone }}</h6>
                                            <h6 class="card-subtitle mb-2 text-body-secondary">{{ $item->email }}</h6>
                                            <div class="d-flex">

                                                @if(Auth::user()->can('admin.edit'))
                                                <a class="dropdown-item d-flex align-items-center text-sm"
                                                    style="font-size: 12px;"
                                                    href="{{ route('cp.view.details',$item->id) }}">
                                                    <i data-feather="eye" class="icon-sm" width="24" height="24"></i>
                                                </a>
                                                @endif
                                                @if(Auth::user()->can('admin.delete'))
                                                <a class="dropdown-item d-flex align-items-center"
                                                    style="font-size: 12px;"
                                                    href="{{ route('cp.clone.students',$item->id) }}">
                                                    <i data-feather="copy" class="icon-sm" width="24" height="24"></i>
                                                </a>
                                                @endif
                                                @if(Auth::user()->can('admin.edit'))
                                                <a class="dropdown-item d-flex align-items-center"
                                                    style="font-size: 12px;"
                                                    href="{{ route('cp.edit.students',$item->id) }}">
                                                    <i data-feather="edit-2" class="icon-sm" width="24" height="24"></i>
                                                </a>
                                                @endif
                                                @if(Auth::user()->can('admin.delete'))
                                                <a class="dropdown-item d-flex align-items-center"
                                                    style="font-size: 12px;" id="delete"
                                                    href="{{ route('cp.delete.students',$item->id) }}">
                                                    <i data-feather="trash-2" class="icon-sm" width="24"
                                                        height="24"></i>
                                                </a>
                                                @endif
                                                @if($item->status == 'active')
                                                <a class="dropdown-item d-flex align-items-center"
                                                    href="{{ route('cp.inactive.students',$item->id) }}">
                                                    <i data-feather="user-x" class="icon-sm text-danger" width="24"
                                                        height="24"></i>
                                                </a>
                                                @else
                                                <a class="dropdown-item d-flex align-items-center"
                                                    href="{{ route('cp.active.students',$item->id) }}">
                                                    <i data-feather="user-check" class="icon-sm text-success" width="24"
                                                        height="24"></i>
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
<script type="text/javascript">
    $('#student_id').on('blur', function() {
    var studentId = $(this).val();
    
    if(studentId !== '') {
        $.ajax({
            url: '/get-student-details',
            method: 'GET',
            data: { student_id: studentId },
            success: function(response) {
                if(response && !response.error) {
                    // Fill in the fields based on response
                    $('input[placeholder="Id"]').val(response.id);
                    $('input[placeholder="name"]').val(response.name);
                    $('input[placeholder="email"]').val(response.email);
                    $('input[placeholder="phone"]').val(response.phone);
                    $('input[placeholder="phone_2"]').val(response.phone_2);
                    $('input[placeholder="batch"]').val(response.batch);
                    $('input[placeholder="section"]').val(response.section);
                    $('input[placeholder="date"]').val(response.date);
                    $('input[placeholder="blood group"]').val(response.blood);

                    // Log the gender value to ensure we're getting the correct value
                    console.log('Gender value from response:', response.gender);

                    // Update gender field based on the gender value
                    if (response.gender === '1' || response.gender == 1) {
                        $('input[placeholder="gender"]').val('Male');
                    } else if (response.gender === '2' || response.gender == 2) {
                        $('input[placeholder="gender"]').val('Female');
                    } else {
                        $('input[placeholder="gender"]').val('Not Specified');
                    }

                    // Update image
                    if(response.photo) {
                        $('#studentPhoto').attr('src', '/uploads/students_img/' + response.photo);
                    } else {
                        $('#studentPhoto').attr('src', '/uploads/no_image.jpg');
                    }
                } else {
                    alert('Student not found');
                }
            },
            error: function(xhr) {
                alert('Error fetching student details');
            }
        });
    }
});


</script>

<!-- Include jQuery in your Blade template if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>


</script>



@endsection