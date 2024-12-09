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
            <li class="breadcrumb-item active" aria-current="page">Record</li>
        </ol>
    </nav>



    <!-- Your Blade Template -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Hello World</div>
                    <div class="card-body">

                        <form action="{{ route('add-more.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            @if($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif

                            <h5>Create Category:</h5>
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter name"
                                    value="{{ request()->old('name') }}" />

                                @error('name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>

                            <table class="table table-bordered mt-2 table-add-more">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h5>Add Stocks</h5>
                                        </th>
                                        <th><button class="btn btn-primary btn-sm btn-add-more"><i
                                                    class="fa fa-plus"></i>Add More</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $key = 0;
                                    @endphp

                                    @if(request()->old('stocks'))
                                    @foreach (request()->old('stocks') as $key => $stock)

                                    <tr>
                                        <td>
                                            <input type="text" name="stocks[{{$key}}][quantity]" class="form-control"
                                                placeholder="Name" value="{{ $stock['quantity'] ?? '' }}">
                                            @error("stocks.$key.quantity")
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror


                                        </td>
                                        <td>
                                            <input type="number" name="stocks[{{$key}}][price]" class="form-control"
                                                placeholder="Price" value="{{ $stock['price'] ?? '' }}">
                                            @error("stocks.$key.price")
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror


                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm btn-add-more-rm"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach

                                    {{-- Else Part --}}

                                    @else
                                    <tr>
                                        <td>
                                            <input type="text" name="stocks[0][quantity]" class="form-control"
                                                placeholder="Name">
                                        </td>
                                        <td>
                                            <input type="number" name="stocks[0][price]" class="form-control"
                                                placeholder="Price">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm btn-add-more-rm"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="form-control mt-2">
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i>
                                    Submit</button>
                            </div>
                        </form>

                        <h5 class="mt-5 mb-3">Category List</h5>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Stock Details</th>
                                    <th>Total Quantity</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item->stocks as $stock)
                                                <tr>
                                                    <td>{{ $stock->quantity }}</td>
                                                    <td>
                                                        {{ $stock->price }}
                                                        @if ($item->stocks->count() > 1)
                                                        , - {{ number_format($item->stocks->avg('price'),2) }} = {{
                                                        number_format($stock->price -
                                                        $item->stocks->avg('price'),2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        @foreach ($item->stocks as $stock)
                                        {{ $stock->quantity }} {{ !$loop->last ? ' + ' : '' }}
                                        @endforeach
                                        = {{ $item->stocks->sum('quantity') }}
                                        @if ($item->stocks->count() > 1)
                                        <br>
                                        max = {{ $item->stocks->max('quantity') }} <br>
                                        Avg = {{ $item->stocks->avg('quantity') }} <br>
                                        min = {{ $item->stocks->min('quantity') }}
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($item->stocks as $stock)
                                        {{ $stock->price }} {{ !$loop->last ? ' + ' : '' }}
                                        @endforeach
                                        = {{ $item->stocks->sum('price') }}
                                        @if ($item->stocks->count() > 1)
                                        <br>
                                        max = {{ $item->stocks->max('price') }} <br>
                                        Avg = {{ $item->stocks->avg('price') }} <br>
                                        min = {{ $item->stocks->min('price') }}
                                        @endif
                                    </td>
                                    <td>
                                        Action
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        i = "{{ $key}}";

        $('.btn-add-more').click(function(e){
            e.preventDefault();
            i++;
            $('.table-add-more').append('<tr><td><input type="text" name="stocks['+i+'][quantity]" class="form-control" placeholder="Quantity"></td><td><input type="number" name="stocks['+i+'][price]" class="form-control" placeholder="Price"></td><td><button class="btn btn-danger btn-sm btn-add-more-rm"><i class="fa fa-trash"></i></button></td></tr>');

        });

        $(document).on('click','.btn-add-more-rm',function() {
            $(this).parents('tr').remove();
        });
    });
</script>




@endsection