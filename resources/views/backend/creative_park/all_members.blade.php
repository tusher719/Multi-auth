@extends('admin.admin_dashboard')
@section('admin')
<style>
    .alert {
        margin-bottom: 20px;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .btn-close {
        font-size: 0.875rem;
        padding: 0.5rem;
    }


    #loader-overlay {
        backdrop-filter: blur(3px);
        transition: all 0.3s ease-in-out;
    }

    .input-group .btn-outline-secondary {
        border-color: #ced4da;
    }

    .input-group .btn-outline-secondary:hover {
        background-color: #e9ecef;
    }

    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    /* Shimmer effect for loading state */
    .shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    /* Fade animation for form reset */
    .fade-transition {
        transition: all 0.3s ease-in-out;
    }

    .fade-out {
        opacity: 0;
    }

    .fade-in {
        opacity: 0.3;
    }
</style>

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


    <!-- Add this HTML for the loader right after the container div -->
    <div class="position-relative">
        <!-- Loader Overlay -->
        <div id="loader-overlay" class="position-absolute w-100 h-100 top-0 start-0 d-none"
            style="background: rgba(184, 183, 183, 0.8); z-index: 1000;">
            <div class="position-absolute top-50 start-50 translate-middle text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 text-primary">Loading student data...</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <div class="input-group mb-3">
                        <input type="text" id="student_id" class="form-control" placeholder="Enter student ID">
                        <button class="btn btn-outline-secondary" type="button" id="resetBtn">
                            <i class="fas fa-undo-alt"></i> Reset
                        </button>
                    </div>
                </div>
                <div class="mt-3">
                    <img id="studentPhoto" src="{{ asset('uploads/no-image2.jpg') }}" class="rounded img-fluid"
                        style="max-width: 150px" alt="Student photo">
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>ID</label>
                            <input type="text" class="form-control" data-field="id" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" data-field="name" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" data-field="email" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Phone</label>
                            <input type="tel" class="form-control" data-field="phone" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Alternative Phone</label>
                            <input type="tel" class="form-control" data-field="phone_2" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Batch</label>
                            <input type="text" class="form-control" data-field="batch" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Section</label>
                            <input type="text" class="form-control" data-field="section" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Gender</label>
                            <input type="text" class="form-control" data-field="gender" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Date</label>
                            <input type="text" class="form-control" data-field="date" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Blood Group</label>
                            <input type="text" class="form-control" data-field="blood" readonly>
                        </div>
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
                                        {{-- {{ $item->panel->id}} --}}
                                        {{ $item->panel ? $item->panel->position : '' }}
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
                                            <h6 class="card-subtitle mb-3 text-body-secondary">{{ $item->student_id
                                                }}
                                            </h6>
                                            <h6 class="card-subtitle mb-3 text-body-secondary">{{ $item->phone }}
                                            </h6>
                                            <h6 class="card-subtitle mb-2 text-body-secondary">{{ $item->email }}
                                            </h6>
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
<script>
    $(document).ready(function() {
        const studentForm = {
            init: function() {
                this.studentId = $('#student_id');
                this.photo = $('#studentPhoto');
                this.messageContainer = this.createMessageContainer();
                this.loaderOverlay = $('#loader-overlay');
                this.resetBtn = $('#resetBtn');
                this.bindEvents();
            },
    
            createMessageContainer: function() {
                if (!$('#message-container').length) {
                    $('<div>')
                        .attr('id', 'message-container')
                        .addClass('alert d-none')
                        .prependTo('.container');
                }
                return $('#message-container');
            },
    
            bindEvents: function() {
                // Changed from blur to change event for better control
                this.studentId.on('change', this.fetchStudentDetails.bind(this));
                this.resetBtn.on('click', this.handleReset.bind(this));
                
                // Enter key handler
                this.studentId.on('keypress', (e) => {
                    if (e.which === 13) {
                        e.preventDefault();
                        this.fetchStudentDetails();
                    }
                });
            },
    
            fetchStudentDetails: function() {
                const studentId = this.studentId.val().trim();
                
                if (!studentId) {
                    this.showMessage('Please enter a student ID', 'warning');
                    this.resetForm();
                    return;
                }
    
                // Show loading state
                this.showLoading(true);
    
                $.ajax({
                    url: '/get-student-details',
                    method: 'GET',
                    data: { student_id: studentId },
                    success: (response) => {
                        this.handleSuccess(response);
                    },
                    error: (xhr) => {
                        this.handleError(xhr);
                    },
                    complete: () => {
                        // Ensure loading overlay is hidden
                        this.showLoading(false);
                    }
                });
            },
    
            handleSuccess: function(response) {
                // Hide loading state first
                this.showLoading(false);
    
                if (!response || response.error) {
                    this.showMessage(`Student not found: ${response?.error || 'No data available'}`, 'warning');
                    this.resetForm();
                    return;
                }
    
                try {
                    // Fill form data
                    this.fillFormData(response);
                    this.updatePhoto(response.photo);
                    this.updateGender(response.gender);
                    this.messageContainer.addClass('d-none');
                } catch (error) {
                    console.error('Error processing response:', error);
                    this.showMessage('Error processing student data', 'danger');
                }
            },
    
            handleError: function(xhr) {
                // Hide loading state
                this.showLoading(false);
    
                let errorMessage = 'Error fetching student details. ';
                
                switch(xhr.status) {
                    case 404:
                        errorMessage += 'Student not found.';
                        break;
                    case 500:
                        errorMessage += 'Internal server error. Please try again later.';
                        break;
                    case 0:
                        errorMessage += 'Network error. Please check your connection.';
                        break;
                    default:
                        errorMessage += 'Please try again or contact support.';
                }
    
                this.showMessage(errorMessage, 'danger');
                this.resetForm();
            },
    
            showLoading: function(show) {
                if (show) {
                    this.loaderOverlay.removeClass('d-none');
                    this.studentId.prop('disabled', true);
                    this.resetBtn.prop('disabled', true);
                } else {
                    this.loaderOverlay.addClass('d-none');
                    this.studentId.prop('disabled', false);
                    this.resetBtn.prop('disabled', false);
                }
            },
    
            fillFormData: function(data) {
                $('input[data-field]').each(function() {
                    const field = $(this).data('field');
                    if (data[field] !== undefined) {
                        $(this).val(data[field]).trigger('change');
                    }
                });
            },
    
            updatePhoto: function(photo) {
                const photoUrl = photo 
                    ? `/uploads/students_img/${photo}`
                    : '/uploads/no_image.jpg';
                this.photo.attr('src', photoUrl);
            },
    
            updateGender: function(gender) {
                const genderMap = {
                    '1': 'Male',
                    '2': 'Female',
                    1: 'Male',
                    2: 'Female'
                };
                $('input[data-field="gender"]').val(genderMap[gender] || 'Not Specified');
            },
    
            resetForm: function() {
                $('input[data-field]').val('');
                this.photo.attr('src', '/uploads/no-image2.jpg');
            },
    
            showMessage: function(message, type) {
                this.messageContainer
                    .removeClass('d-none alert-success alert-danger alert-warning')
                    .addClass(`alert-${type}`)
                    .html(`
                        <div class="d-flex align-items-center">
                            <span>${message}</span>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
            }
        };
    
        studentForm.init();
    });
</script>



@endsection