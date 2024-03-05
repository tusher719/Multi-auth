@extends('admin.admin_dashboard')
@section('admin')

    <!-- cdn link -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                {{--                <li class="breadcrumb-item">Creative Park</li>--}}
                <li class="breadcrumb-item active" aria-current="page">Tag</li>
            </ol>
        </nav>


        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <div>All Tags <span class="badge bg-primary mx-1">{{ $total }}</span></div>
                                    {{--                            <div class="mx-4">Active <span class="badge bg-success mx-1">{{ $activeUser }}</span></div>--}}
                                    {{--                            <div>Banned <span class="badge bg-danger mx-1">{{ $inactiveUser }}</span></div>--}}
                                </h6>

                                {{--                        <div class="table-responsive">--}}
                                <form action="{{ route('Mark.delete') }}" method="post">
                                    @csrf
                                    <button type="button" class="btn btn-inverse-danger btn-sm checkbox-toggle">
                                        <input type="checkbox" class="form-check-input" id="checkChecked" checked>
                                        <label class="form-check-label" for="checkChecked">
                                            Select All
                                        </label>
                                    </button>
                                    <button type="submit" id="mark_delete" class="btn btn-outline-danger btn-sm">
                                        <i data-feather="trash" class="icon-sm" width="24" height="24" ></i>
                                    </button>
                                    <div class="mailbox-messages">
                                        <table id="dataTableExample" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Sl</th>
                                                <th>Name</th>
                                                <th>Created at</th>
                                                <th>Added By</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($tags as $key => $item)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"  class="form-check-input" id="check" name="mark[]" value="{{ $item->id }}" id="check{{ $item->id }}">
                                                    </td>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>{{ $item->created_at->diffForHumans(['options' => \Carbon\Carbon::JUST_NOW | \Carbon\Carbon::ONE_DAY_WORDS | \Carbon\Carbon::TWO_DAY_WORDS]) }}</td>
                                                    <td class="text-center">
                                                        @if(Auth::user()->can('admin.edit'))
                                                            <a href="{{ route('edit.tag',$item->id) }}" class="btn btn-inverse-primary">
                                                                <i data-feather="edit-2" class="icon-sm" width="24" height="24" ></i>
                                                                Edit
                                                            </a>
                                                        @endif
                                                        @if(Auth::user()->can('admin.edit'))
                                                            <a href="{{ route('delete.tag',$item->id) }}" id="delete" class="btn btn-inverse-danger">
                                                                <i data-feather="trash" class="icon-sm" width="24" height="24" ></i>
                                                                Delete
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </form>

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

                                <form action="{{ route('update.tag',$data->id) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Tag Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Tag Name" value="{{ $data->name }}">
                                                @error('name')
                                                <small class="text-danger text-sm">
                                                    {{ $message }}
                                                </small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-3">Update Tag</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <script>
        $(function () {
            //Enable check and uncheck all functionality
            $('.checkbox-toggle').click(function () {
                var clicks = $(this).data('clicks')
                if (clicks) {
                    //Uncheck all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                    // $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
                } else {
                    //Check all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                    // $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
                }
                $(this).data('clicks', !clicks)
            })
        })
    </script>

@endsection
