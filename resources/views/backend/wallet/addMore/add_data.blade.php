<form action="{{ route('add-more.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    {{-- @if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
    @endif --}}

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{ request()->old('name') }}" />

                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Amount:</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter amount" value="{{ request()->old('amount') }}" />

                        @error('amount')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label>Description:</label>
                        <textarea class="form-control" name="description" placeholder="Enter description">{{ request()->old('description') }}</textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <table class="table table-bordered mt-2 table-add-more">
                <thead>
                <tr>
                    <th colspan="3">
                        <h5>Add Stocks</h5>
                    </th>
                    <th>
                        <button class="btn btn-primary btn-sm btn-add-more">
                            <i class="fa fa-plus"></i>Add More
                        </button>
                    </th>
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
                                <input type="text" name="stocks[{{$key}}][name]" class="form-control" placeholder="Name" value="{{ $stock['name'] ?? '' }}">
                                @error("stocks.$key.name")
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <input type="number" name="stocks[{{$key}}][price]" class="form-control" placeholder="Price" value="{{ $stock['price'] ?? '' }}">
                                @error("stocks.$key.price")
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <input type="text" name="stocks[{{$key}}][description]" class="form-control" placeholder="Price" value="{{ $stock['description'] ?? '' }}">
                                @error("stocks.$key.description")
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-add-more-rm"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach

                    {{-- Else Part --}}

                @else
                    <tr>
                        <td>
                            <input type="text" name="stocks[0][name]" class="form-control" placeholder="Name">
                        </td>
                        <td>
                            <input type="number" name="stocks[0][price]" class="form-control" placeholder="Price">
                        </td>
                        <td>
                            <input type="text" name="stocks[0][description]" class="form-control" placeholder="Description">
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-add-more-rm"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-center mt-3 mx-auto">
        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i>
            Submit
        </button>
    </div>

</form>
