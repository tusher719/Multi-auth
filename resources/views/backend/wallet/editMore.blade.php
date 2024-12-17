@extends('admin.admin_dashboard')
@section('admin')

<!-- cdn link -->
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Wallet</li>
            <li class="breadcrumb-item active" aria-current="page">Add More</li>
            <li class="breadcrumb-item active" aria-current="page">Edit - ({{ $record->id }} - {{ $record->name }})</li>
        </ol>
    </nav>



    <!-- Your Blade Template -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create Category</div>
                    <div class="card-body">
                        <div class="form-control mt-2">

                            <form action="{{ route('add-more.update', $record->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Name and Amount -->
                                    <div class="col-md-5">
                                        <div class="form-group mt-3">
                                            <label>Name:</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $record->name) }}">
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>Amount:</label>
                                            <input type="number" name="amount" class="form-control" value="{{ old('amount', $record->amount) }}">
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>Description:</label>
                                            {{-- <input type="number" name="description" class="form-control" value="{{ old('amount', $record->description) }}"> --}}
                                            <textarea class="form-control" name="description" placeholder="Enter description">{{ old('description', $record->description) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Stocks Table -->
                                    <div class="col-md-7">
                                        <table class="table table-bordered table-add-more">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Description</th>
                                                    <th>
                                                        <button type="button" class="btn btn-primary btn-sm btn-add-more"><i class="fa fa-plus"></i></button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($record->stocks as $key => $stock)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="stocks[{{ $key }}][name]" class="form-control" value="{{ old('stocks.'.$key.'.name', $stock->name) }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="stocks[{{ $key }}][price]" class="form-control" value="{{ old('stocks.'.$key.'.price', $stock->price) }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="stocks[{{ $key }}][description]" class="form-control" value="{{ old('stocks.'.$key.'.description', $stock->description) }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm btn-add-more-rm"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-success mt-3">Update</button>
                            </form>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        let i = "{{ count($record->stocks) - 1 }}";

        $('.btn-add-more').click(function(e) {
            e.preventDefault();
            i++;
            $('.table-add-more tbody').append(`
            <tr>
                <td><input type="text" name="stocks[${i}][name]" class="form-control" placeholder="Name"></td>
                <td><input type="number" name="stocks[${i}][price]" class="form-control" placeholder="Price"></td>
                <td><input type="text" name="stocks[${i}][description]" class="form-control" placeholder="Description"></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-add-more-rm"><i class="fa fa-trash"></i></button></td>
            </tr>
        `);
        });

        $(document).on('click', '.btn-add-more-rm', function() {
            $(this).closest('tr').remove();
        });
    });

</script>

@endsection
