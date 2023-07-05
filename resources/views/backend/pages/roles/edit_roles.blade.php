@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('all.roles') }}">All Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Roles</li>
        </ol>
    </nav>



    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Role</h6>

                    <form action="{{ route('update.roles') }}" method="POST" class="forms-sample">
                        @csrf

                        <input type="hidden" name="id" value="{{ $roles->id }}">

                        <div class="form-group mb-3">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $roles->name }}">
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Update</button>

                    </form>

                </div>
            </div>
        </div>
    </div>



</div>

@endsection
