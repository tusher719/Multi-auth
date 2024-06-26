@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Permission</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 mt-3 mb-3">
            <a href="{{ route('add.permission') }}" class="btn btn-inverse-info">Add Permission</a>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <a href="{{ route('import.permission') }}" class="btn btn-inverse-success mr-5">Import</a>
            &nbsp;
            <a href="{{ route('export') }}" class="btn btn-inverse-danger">Export</a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 mx-auto grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Permission All</h6>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Permission Name</th>
                                    <th>Group Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->group_name }}</td>
                                    <td>
                                        <a href="{{ route('edit.permission',$item->id) }}" class="btn btn-inverse-warning">Edit</a>
                                        <a href="{{ route('delete.permission',$item->id) }}" class="btn btn-inverse-danger" id="delete">Delete</a>
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
