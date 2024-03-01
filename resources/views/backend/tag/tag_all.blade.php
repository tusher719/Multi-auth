@extends('admin.admin_dashboard')
@section('admin')

    <!-- cdn link -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Creative Park</li>
                <li class="breadcrumb-item active" aria-current="page">All Members</li>
            </ol>
        </nav>


        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title d-flex">
                                    <div>All Tags <span class="badge bg-primary mx-1">{{ $total }}</span></div>
                                    {{--                            <div class="mx-4">Active <span class="badge bg-success mx-1">{{ $activeUser }}</span></div>--}}
                                    {{--                            <div>Banned <span class="badge bg-danger mx-1">{{ $inactiveUser }}</span></div>--}}
                                </h6>

                                {{--                        <div class="table-responsive">--}}
                                <div class="">
                                    <table id="dataTableExample" class="table">
                                        <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($tags as $key => $item)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td class="mx-auto">
                                                    @if(Auth::user()->can('admin.edit'))
                                                        <a href="{{ route('edit.tag',$item->id) }}" class="btn btn-inverse-primary">
                                                            <i data-feather="edit-2" class="icon-sm" width="24" height="24" ></i>
                                                            Edit
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->can('admin.edit'))
                                                        <a href="{{ route('delete.tag',$item->id) }}" id="delete" class="btn btn-inverse-danger">
                                                            <i data-feather="edit-2" class="icon-sm" width="24" height="24" ></i>
                                                            Delete
                                                        </a>
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
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title d-flex">
                                    <div>Create New Tag</div>
                                    {{--                            <div class="mx-4">Active <span class="badge bg-success mx-1">{{ $activeUser }}</span></div>--}}
                                    {{--                            <div>Banned <span class="badge bg-danger mx-1">{{ $inactiveUser }}</span></div>--}}
                                </h6>

                                <form action="{{ route('store.tag') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Tag Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Tag Name">

                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-3">Add Tag</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection
