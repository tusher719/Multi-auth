@extends('admin.admin_dashboard')
@section('admin')

<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* gap: 5px; */
        margin-bottom: 20px;
    }

    .grid-item {
        padding: 6px 12px;
        background-color: transparent;
        /* Default button color */
        color: #354052;
        border: 1px solid #ffffff;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .grid-item.selected {
        background-color: #354052;
        color: #fff;
        font-weight: bold;
    }
</style>

<!-- cdn link -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Creative Park</li>
            <li class="breadcrumb-item active" aria-current="page">Panel</li>
        </ol>
    </nav>

    <div class="modal fade" id="editPanelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editPanelForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Panel</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_panel_id">
                        <div class="form-group">
                            <label>Position Name</label>
                            <input type="text" name="position" id="edit_position" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position Roll</label>
                            <input type="text" name="position_roll" id="edit_position_roll" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                {{-- <div>All Tags <span class="badge bg-primary mx-1">{{ $total }}</span></div> --}}
                                {{-- <div class="mx-4">Active <span class="badge bg-success mx-1">{{ $activeUser
                                        }}</span></div>--}}
                                {{-- <div>Banned <span class="badge bg-danger mx-1">{{ $inactiveUser }}</span></div>--}}
                            </h6>

                            {{-- <div class="table-responsive">--}}
                                <form action="{{ route('Mark.delete') }}" method="post">
                                    @csrf
                                    <button type="button" class="btn btn-inverse-danger btn-sm checkbox-toggle">
                                        <input type="checkbox" class="form-check-input" id="checkChecked" checked>
                                        <label class="form-check-label" for="checkChecked">
                                            Select All
                                        </label>
                                    </button>
                                    <button type="submit" id="mark_delete" class="btn btn-outline-danger btn-sm">
                                        <i data-feather="trash" class="icon-sm" width="24" height="24"></i>
                                    </button>
                                    <div class="mailbox-messages">
                                        <table id="dataTableExample" class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Sl</th>
                                                    <th>Name</th>
                                                    <th>Added By</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($panel as $key => $item)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input" id="check"
                                                            name="mark[]" value="{{ $item->id }}"
                                                            id="check{{ $item->id }}">
                                                    </td>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $item->position }}</td>
                                                    <td>{{ $item->user ? $item->user->name : 'No User' }}</td>
                                                    <td class="text-center">
                                                        @if(Auth::user()->can('admin.edit'))
                                                        <button type="button" data-id="{{ $item->id }}"
                                                            class="btn btn-inverse-primary edit-panel">
                                                            <i data-feather="edit-2" class="icon-sm" width="24"
                                                                height="24"></i>
                                                        </button>
                                                        @endif
                                                        @if(Auth::user()->can('admin.edit'))
                                                        <form action="{{ route('delete.panel', $item->id) }}"
                                                            method="post" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-inverse-danger">
                                                                <i data-feather="trash" class="icon-sm" width="24"
                                                                    height="24"></i>
                                                            </button>
                                                        </form>
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
                                    <div>Create New Position</div>

                                </h6>

                                <form id="createPositionForm" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Position Name</label>
                                                <input type="text" name="position" class="form-control"
                                                    placeholder="position">
                                                <small class="text-danger text-sm error" data-error="position"></small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Position Roll</label>
                                                <input type="text" name="position_roll" class="form-control mt-2"
                                                    placeholder="position roll">
                                                <small class="text-danger text-sm error"
                                                    data-error="position_roll"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-3">Add Position</button>
                                </form>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>


    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>

    <script>
        $('#createPositionForm').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ route('store.panel') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload(); // Reload to see new data or append dynamically
                }
            },
            error: function(response) {
                // Display errors
                $.each(response.responseJSON.errors, function(key, value) {
                    $('[data-error="'+key+'"]').text(value[0]);
                });
            }
        });
    });
    </script>

    <script>
        $(document).on('click', '.delete-panel', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to delete this panel?')) {
            $.ajax({
                url: "{{ url('panel/delete') }}/" + id,
                type: 'DELETE',
                success: function(response) {
                    alert(response.message);
                    location.reload();
                }
            });
        }
    });
    </script>

    <script>
        $(document).on('click', '.edit-panel', function() {
        let id = $(this).data('id');
        $.get("{{ url('panel/edit') }}/" + id, function(data) {
            $('#edit_panel_id').val(data.id);
            $('#edit_position').val(data.position);
            $('#edit_position_roll').val(data.position_roll);
            $('#editPanelModal').modal('show');
        });
    });

    $('#editPanelForm').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ route('update.panel') }}",
            type: 'PUT',
            data: formData,
            success: function(response) {
                alert(response.message);
                $('#editPanelModal').modal('hide');
                location.reload();
            }
        });
    });
    </script>

    <script>
        $(document).on('click', '.edit-panel', function() {
        let id = $(this).data('id');
        
        $.get("{{ url('panel/edit') }}/" + id, function(data) {
            $('#edit_panel_id').val(data.id);
            $('#edit_position').val(data.position);
            $('#edit_position_roll').val(data.position_roll);
            $('#editPanelModal').modal('show');
        });
    });
    </script>
    <script>
        $('#editPanelForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            
            $.ajax({
                url: "{{ route('update.panel') }}",
                type: 'PUT',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    $('#editPanelModal').modal('hide');
                    location.reload();
                },
                error: function(response) {
                    alert('Error occurred while updating panel');
                }
            });
        });
    </script>




    @endsection