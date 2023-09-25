@extends('admin.admin_dashboard')
@section('admin')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('all.admin') }}">All Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Roles</li>
        </ol>
    </nav>



    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Roles</h6>

                    <form id="myForm" action="{{ route('update.admin',$user->id) }}" method="POST" class="forms-sample">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Admin Username</label>
                                    <input type="text" name="usernames" class="form-control" placeholder="Usernames" value="{{$user->usernames}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Admin Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Admin Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Admin Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{$user->phone}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Admin Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Address" value="{{$user->address}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Roles Name</label>
                                    <select name="roles" class="form-select">
                                        <option selected="" disabled="">Select Role</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>

                    </form>

                </div>
            </div>
        </div>
    </div>



</div>


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                usernames: {
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
                address: {
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
@endsection
