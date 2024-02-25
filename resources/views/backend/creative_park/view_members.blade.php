@extends('admin.admin_dashboard')
@section('admin')

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">Creative Park</a></li>
                <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">All Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">Student Info</li>
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

        <div class="row">

                <div class="col-md-9 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3 justify-content-between">
                                <h6 class="card-title">Student Info</h6>
                                <div>Added by : {{ $details->user->name }}</div>
                                <div class="d-flex align-items-center">
                                    Account:
                                    <div class="px-2">
                                        @if($details->status == 'active')
                                            <span class="badge border border-success text-success">
                                                <i data-feather="check"></i>
                                                Active
                                            </span></td>
                                        @elseif($details->status == 'inactive')
                                            <span class="badge border border-danger text-danger">
                                                <i data-feather="lock"></i>
                                                inactive
                                            </span></td>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <div class="row">
                                            <div class="col-md-2 px-4">
                                                <h4>Name :</h4>
                                            </div>
                                            <div class="col-md-10 px-1 border-bottom border-info">
                                                <h5>{{ $details->name }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="row">
                                            <div class="col-md-2 px-4">
                                                <h4>ID :</h4>
                                            </div>
                                            <div class="col-md-10 px-1 border-bottom border-info">
                                                <h5>{{ $details->student_id }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="row">
                                            <div class="col-md-2 px-4">
                                                <h4>Email :</h4>
                                            </div>
                                            <div class="col-md-10 px-1 border-bottom border-info">
                                                <h5>{{ $details->email }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="row">
                                            <div class="col-md-2 px-4">
                                                <h4>Phone 1 :</h4>
                                            </div>
                                            <div class="col-md-4 px-1 border-bottom border-info">
                                                <h5>{{ $details->phone }}</h5>
                                            </div>
                                            <div class="col-md-2 px-4">
                                                <h4>Phone 2 :</h4>
                                            </div>
                                            <div class="col-md-4 px-1 border-bottom border-info">
                                                <h5>{{ $details->phone_2 }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="row">
                                            <div class="col-md-2 px-4">
                                                <h4>Date of birth :</h4>
                                            </div>
                                            <div class="col-md-10 px-1 border-bottom border-info">
                                                <h5>
                                                    {{ Carbon\Carbon::parse($details->date)->format('d-M-Y') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="row">
                                            <div class="col-md-2 px-4">
                                                <h4>Gender :</h4>
                                            </div>
                                            <div class="col-md-10 px-1 border-bottom border-info">
                                                <h5>
                                                    @if($details->gender == 1)
                                                        Male
                                                    @elseif($details->gender == 2)
                                                        Female
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="row">
                                            <div class="col-md-2 px-4">
                                                <h4>Batch :</h4>
                                            </div>
                                            <div class="col-md-4 px-1 border-bottom border-info">
                                                <h5>{{ $details->batch }}th</h5>
                                            </div>

                                            <div class="col-md-2 px-4">
                                                <h4>Section :</h4>
                                            </div>
                                            <div class="col-md-4 px-1 border-bottom border-info">
                                                <h5>{{ $details->section }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="row">
                                            <div class="col-md-2 px-4">
                                                <h4>Blood :</h4>
                                            </div>
                                            <div class="col-md-10 px-1 border-bottom border-info">
                                                <h5>{{ $details->blood }}</h5>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>




                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <img id="showImage" class="wd-300 rounded" src="{{ (!empty($details->photo)) ? url('uploads/students_img/'.$details->photo) : url('uploads/no_image.jpg') }}" alt="profile">
                            </div>

                        </div>
                    </div>
                </div>

            </div>



    </div>

@endsection
