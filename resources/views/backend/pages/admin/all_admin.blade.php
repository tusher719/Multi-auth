@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Manage Admin User</li>
            <li class="breadcrumb-item active" aria-current="page">All Admin</li>
        </ol>
    </nav>

    <div class="row">
        @if(Auth::user()->can('admin.add'))
            <div class="col-md-12 mt-3 mb-3">
                <a href="{{ route('add.admin') }}" class="btn btn-inverse-info"> Add Admin </a>
            </div>
        @endif
    </div>


    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Admin All</h6>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alladmin as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <img class="wd-100 rounded-circle" src="{{ (!empty($item->photo)) ? url('uploads/admin_images/'.$item->photo) : url('uploads/no_image.jpg') }}" alt="profile">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        @foreach ($item->roles as $role)
                                        <span class="badge badge-pill bg-danger">{{ $role->name }}</span>

                                        @endforeach
                                    </td>
                                    <td>
                                        @if(Auth::user()->can('admin.edit'))
                                            <a href="{{ route('edit.admin',$item->id) }}" class="btn btn-inverse-warning">Edit</a>
                                        @endif
                                        @if(Auth::user()->can('admin.delete'))
                                                <a href="{{ route('delete.admin',$item->id) }}" class="btn btn-inverse-danger" id="delete">Delete</a>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>



</div>

@endsection
