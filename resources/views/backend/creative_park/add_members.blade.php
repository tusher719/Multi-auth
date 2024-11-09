@extends('admin.admin_dashboard')
@section('admin')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">Creative Park</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Student</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-2 mt-3 mb-3">
            <a href="{{ route('all.cp.members') }}" class="btn btn-inverse-info">
                <i class="btn-icon-prepend mx-1" data-feather="users" width="18" height="18"></i>
                All Students
            </a>
        </div>
        <div class="col-md-10 mt-3 mb-3 float-end">
            <a href="{{ route('import.students') }}" class="btn btn-inverse-success mx-2">
                <i class="btn-icon-prepend" data-feather="arrow-up" width="18" height="18"></i>
                Import
            </a>

            <a href="{{ route('export.student') }}" class="btn btn-inverse-danger">
                <i class="btn-icon-prepend" data-feather="arrow-down" width="18" height="18"></i>
                Export
            </a>
        </div>
    </div>


    <form id="myForm" action="{{ route('cp.store.members') }}" method="POST" enctype="multipart/form-data"
        class="forms-sample">
        @csrf
        <div class="row">

            <div class="col-md-9 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4">
                            <i class="btn-icon-prepend mx-1" data-feather="user-plus" width="18" height="18"></i>
                            Create a new user
                        </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Student ID</label>
                                    <input type="text" name="student_id" class="form-control" placeholder="Student id">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Student Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Student name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Diu Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone 2</label>
                                    <input type="text" name="phone_2" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Batch</label>
                                    <input type="text" name="batch" class="form-control" placeholder="Batch">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Section</label>
                                    <select name="section" class="form-select">
                                        <option selected="" disabled="">Select section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option selected="" disabled="">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="ageSelect" class="form-label">Panel</label>
                                    <select class="form-select" name="panel_position">
                                        <option selected disabled>Select Position</option>
                                        @foreach ($panel as $item)
                                        <option value="{{ $item->id }}">{{ $item->position }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Blood Group</label>
                                    <select name="blood" class="form-select">
                                        <option selected="" disabled="">Select Blood</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tags</label>
                                    <select class="js-example-basic-multiple form-select" name="tags[]"
                                        multiple="multiple" data-width="100%">
                                        @foreach($tags as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="form-check mb-4 my-3">
                            <input type="checkbox" class="form-check-input" name="status" id="checkChecked"
                                value="active">
                            <label class="form-check-label" for="checkChecked">
                                Active
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary me-3">Add Student</button>
                        <a href="{{ route('all.cp.members') }}" class="btn btn-inverse-secondary">
                            Back
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 mt-4">
                            <label for="address" class="form-label mt-5">Photo</label>
                            <input type="file" name="photo" class="form-control" id="image">
                        </div>
                        <div class="mb-3">
                            <img id="showImage" class="wd-200 "
                                src="{{ (!empty($profileData->photo)) ? url('uploads/admin_images/'.$profileData->photo) : url('uploads/no_image.jpg') }}"
                                alt="profile">
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>



</div>


<script type="text/javascript">
    $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    student_id: {
                        required : true,
                    },
                    name: {
                        required : true,
                    },
                    email: {
                        required : true,
                    },
                    phone: {
                        required : true,
                    },
                    batch: {
                        required : true,
                    },
                    section: {
                        required : true,
                    },
                    gender: {
                        required : true,
                    },
                    dob: {
                        required : true,
                    },
                    blood: {
                        required : true,
                    },

                },
                messages :{
                    student_id: {
                        required : 'Please Enter Student ID!',
                    },
                    name: {
                        required : 'Please Enter Name!',
                    },
                    email: {
                        required : 'Please Enter Email!',
                    },
                    phone: {
                        required : 'Please Enter Phone!',
                    },
                    batch: {
                        required : 'Please Enter Batch!',
                    },
                    section: {
                        required : 'Please Enter Section!',
                    },
                    gender: {
                        required : 'Please Select Gender!',
                    },
                    dob: {
                        required : 'Please Select Date of Birth!',
                    },
                    blood: {
                        required : 'Please Select Blood!',
                    },


                },
                errorElement : 'span',
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });

</script>

<script type="text/javascript">
    $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
</script>
@endsection