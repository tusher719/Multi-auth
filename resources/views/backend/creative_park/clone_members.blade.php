@extends('admin.admin_dashboard')
@section('admin')

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">Creative Park</a></li>
                <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">All Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clone Student</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $info->name }} - {{ $info->student_id }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 mt-3 mb-3">
                <a href="{{ route('all.cp.members') }}" class="btn btn-inverse-info">
                    <i class="btn-icon-prepend" data-feather="chevron-left"></i>
                    Back
                </a>
            </div>
        </div>


        <form id="myForm" action="{{ route('cp.store.members') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
            @csrf
            <div class="row">

                <div class="col-md-9 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Add Admin</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Student ID</label>
                                        <input type="text" name="student_id" class="form-control" placeholder="Student id" value="{{ $info->student_id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Student Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Student name" value="{{ $info->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Diu Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $info->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ $info->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Phone 2</label>
                                        <input type="text" name="phone_2" class="form-control" placeholder="Phone" value="{{ $info->phone_2 }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Batch</label>
                                        <input type="text" name="batch" class="form-control" placeholder="Batch" value="{{ $info->batch }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Section</label>
                                        <select name="section" class="form-select">
                                            <option selected="" disabled="">Select section</option>
                                            <option value="A" {{ $info->section == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ $info->section == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="C" {{ $info->section == 'C' ? 'selected' : '' }}>C</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option selected="" disabled="">Select Gender</option>
                                            <option value="1" {{ $info->gender == '1' ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ $info->gender == '2' ? 'selected' : '' }}>Female</option>
                                            <option value="3" {{ $info->gender == '3' ? 'selected' : '' }}>others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="dob" class="form-control" value="{{ $info->date }}">
                                    </div>
                                </div>





                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Blood Group</label>
                                        <select name="blood" class="form-select">
                                            <option selected="" disabled="">Select Blood</option>
                                            <option value="A+" {{ $info->blood == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ $info->blood == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ $info->blood == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ $info->blood == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="O+" {{ $info->blood == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ $info->blood == 'O-' ? 'selected' : '' }}>O-</option>
                                            <option value="AB+" {{ $info->blood == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ $info->blood == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-4 my-3">
                                <input type="checkbox" class="form-check-input" name="status" id="checkChecked" value="active"  {{ $info->status == 'active' ? 'checked': '' }}>
                                <label class="form-check-label" for="checkChecked">
                                    Active
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary my-3">Clone Data</button>
                            <a href="{{ route('all.cp.members') }}" class="btn btn-inverse-light mx-3">Back </a>



                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="address" class="form-label">Student Photo</label>
                                <input type="file" name="photo" class="form-control" id="image">
                            </div>
                            <div class="mb-3">
                                <img id="showImage" class="wd-200 rounded" src="{{ (!empty($info->photo)) ? url('uploads/students_img/'.$info->photo) : url('uploads/no_image.jpg') }}" alt="{{ $info->name }}">
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
                    usernames: {
                        required : true,
                    },
                    names: {
                        required : true,
                    },
                    email: {
                        required : true,
                    },
                    phone: {
                        required : true,
                    },
                    address: {
                        required : true,
                    },
                    password: {
                        required : true,
                    },
                    roles: {
                        required : true,
                    },

                },
                messages :{
                    usernames: {
                        required : 'Please Enter Username!',
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
                    address: {
                        required : 'Please Enter Addres!',
                    },
                    password: {
                        required : 'Please Enter password!',
                    },
                    roles: {
                        required : 'Please Select Roles!',
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
