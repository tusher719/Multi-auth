@extends('admin.admin_dashboard')
@section('admin')

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">Creative Park</a></li>
                <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">All Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">Import</li>
            </ol>
        </nav>



        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('all.cp.members') }}" class="btn btn-inverse-success">
                    <i class="btn-icon-prepend mx-1" data-feather="users" width="18" height="18"></i>
                    All Students
                </a>
                <a href="{{ route('add.cp.member') }}" class="btn btn-inverse-info">
                    <i class="btn-icon-prepend mx-1" data-feather="user-plus" width="18" height="18"></i>
                    Add Manual Students
                </a>
            </div>

            <div class="col-md-6 grid-margin align-center">
                <a href="{{ route('export.student') }}" class="btn btn-inverse-danger">
                    <i class="btn-icon-prepend mx-1" data-feather="arrow-down" width="18" height="18"></i> Download Xlsx</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Import Students</h6>

                        <form id="myForm" action="{{ route('import.student') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                            @csrf

                            <div class="form-group mb-3">
                                <label class="form-label">Xlsx File Import</label>
                                <input type="file" name="import_file" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-inverse-success">Upload</button>

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
                    import_file: {
                        required : true,
                    },

                },
                messages :{
                    import_file: {
                        required : 'Please Enter Xles file!',
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
