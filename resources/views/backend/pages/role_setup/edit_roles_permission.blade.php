@extends('admin.admin_dashboard')
@section('admin')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<style type="text/css">
    .form-check-label {
        text-transform: capitalize;
    }
</style>

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('all.roles.permission') }}">All Roles Permission</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Roles in Permission</li>
        </ol>
    </nav>



    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Roles in Permission</h6>

                    <form id="myForm" action="{{ route('role.permission.store') }}" method="POST" class="forms-sample">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label">Roles Name</label>
                            <select name="role_id" class="form-select bg-primary" disabled="">
                                {{-- <option selected="" disabled="">Select Group</option> --}}
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            </select>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="mainSelect">
                            <label class="form-check-label" for="mainSelect">
                                Permission All
                            </label>
                        </div>

                        <hr>

                        @foreach ($permission_group as $group)
                        <div class="row">

                            <div class="col-md-3">

                                @php
                                $permissions = App\Models\User::getPermissionByGroupName($group->group_name)
                                @endphp

                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" {{ App\Models\User::roleHashPermissions($role,$permissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">
                                        {{ $group->group_name }}
                                    </label>
                                </div>
                            </div> <!-- ==========||End Col-md-3||========== -->

                            <div class="col-md-9">

                                @foreach ($permissions as $permission)
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" name="permission[]" id="permission{{ $permission->id }}" value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                                @endforeach
                                <br>

                            </div>  <!-- ==========||End Col-md-9||========== -->
                        </div> <!-- ==========||End Row||========== -->
                        @endforeach

                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>

                    </form>

                </div>
            </div><!-- ==========||End Card||========== -->
        </div>
    </div> <!-- ==========||End Row||========== -->



</div>


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                role_id: {
                    required : true,
                },

            },
            messages :{
                role_id: {
                    required : 'Please Select Role Option!',
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



    // Select All Role
    $('#mainSelect').click(function() {
        if ($(this).is(':checked')) {
            $('input[type=checkbox]').prop('checked',true);
        } else {
            $('input[type=checkbox]').prop('checked',false);
        }
    });

</script>
@endsection
