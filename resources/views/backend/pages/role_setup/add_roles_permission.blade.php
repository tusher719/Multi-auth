@extends('admin.admin_dashboard')
@section('admin')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Roles in Permission</li>
        </ol>
    </nav>



    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add Roles in Permission</h6>

                    <form id="myForm" action="{{ route('store.roles') }}" method="POST" class="forms-sample">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label">Roles Name</label>
                            <select name="role_id" class="form-select">
                                <option selected="" disabled="">Select Group</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">
                                Permission All
                            </label>
                        </div>

                        <hr>

                        @foreach ($permission_group as $group)
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">
                                        {{ $group->group_name }}
                                    </label>
                                </div>
                            </div> <!-- ==========||End Col-md-3||========== -->

                            <div class="col-md-9">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">
                                        Permission All
                                    </label>
                                </div>
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

</script>
@endsection
