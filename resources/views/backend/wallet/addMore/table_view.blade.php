<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Amount</th>
            {{-- <th>Description</th> --}}
            <th>Stock Details</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        @foreach ($records as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }} - ({{ $item->stocks->count() }})</td>
            <td>
                <i data-feather="dollar-sign" class="icon-sm" width="24" height="24"></i>
                {{ number_format($item->amount,0) }}
            </td>
            {{-- <td class="text-muted"><i>{{ $item->description }}</i></td> --}}
            <td>
                <table class="table table-sm table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item->stocks as $stock)
                        <tr>
                            <td> {{ $stock->name }} </td>
                            <td>
                                {{ number_format($stock->price,1) }}
                                @if ($item->stocks->count() > 1)
                                - {{ number_format($item->amount / $item->stocks->count(),1) }}
                                @endif
                            </td>
                            <td>
                                @if($stock->price - $item->amount / $item->stocks->count() <= 0) --- @else <p class="text-success">
                                    {{ number_format( $stock->price - $item->amount / $item->stocks->count(),1) }}
                                    </p>
                                    @endif
                            </td>
                            <td>
                                @if($stock->price - $item->amount / $item->stocks->count() < 0) <p class="text-danger">
                                    {{ number_format( $stock->price - $item->amount / $item->stocks->count(),1) }}
                                    </p>
                                    @else
                                    ---
                                    @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td>
                {{-- @foreach ($item->stocks as $stock)
                {{ $stock->price }} {{ !$loop->last ? ' + ' : '' }}
                @endforeach --}}

                <p class="text-success mt-2">Paid = {{ $item->stocks->sum('price') }}
                    <br> (Names) =
                    @if($item->stocks->where('price', '>', 0)->isNotEmpty())
                    @foreach ($item->stocks->where('price', '>', 0) as $stock)
                    {{ $stock->name}}{{!$loop->last ? ',' : '' }}
                    @endforeach
                    @endif
                </p>
                <p class="text-danger">Due = {{ $item->amount - $item->stocks->sum('price') }}
                    <br> (Names) =
                    @if($item->stocks->where('price', 0)->isNotEmpty())
                    @foreach ($item->stocks->where('price', 0) as $stock)
                    {{ $stock->name }} {{ !$loop->last ? ' , ' : '' }}
                    @endforeach
                    @endif
                </p>

                {{-- <p class="text-success mt-5">Credit = {{ $item->stocks->sum('price') }}</p>
                <p class="text-danger">Debit = {{ $item->amount - $item->stocks->sum('price') }}
                </p>

                <!-- Stocks with zero price -->
                @if($item->stocks->where('price', 0)->isNotEmpty())
                <p class="text-warning">Stocks with zero price:</p>
                <ul>
                    @foreach ($item->stocks->where('price', 0) as $stock)
                    <li>{{ $stock->name }}</li>
                    @endforeach
                </ul>
                @endif

                <!-- Stocks with price greater than zero -->
                @if($item->stocks->where('price', '>', 0)->isNotEmpty())
                <p class="text-info">Stocks with price greater than 0:</p>
                <ul>
                    @foreach ($item->stocks->where('price', '>', 0) as $stock)
                    <li>{{ $stock->name }}: {{ $stock->price }}</li>
                    @endforeach
                </ul>
                @else
                <p class="text-warning">No stocks with price greater than 0.</p>
                @endif --}}

                @if ($item->stocks->count() > 1)
                {{-- max = {{ number_format($item->stocks->max('price'),2) }} <br> --}}
                <p class="text-info mt-3">
                    Avg = {{ number_format($item->amount / $item->stocks->count(),2) }}
                </p>
                {{-- min = {{ number_format($item->stocks->min('price'),2) }} --}}
                @endif
            </td>
            <td class="d-flex justify-content-around">
                {{-- <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" href="{{ route('view.wallet',$item->id) }}">
                <i data-feather="eye" class="icon-sm" width="24" height="24"></i>
                <span class="mx-3">View</span>
                </a> --}}


                <div>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                        <i data-feather="eye" class="icon-sm" width="24" height="24"></i>
                        <span class="mx-3">View</span>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal
                                        title
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">


                                    <h2>{{ $item->name }} ({{ $item->id }} )</h2>
                                    <h6 class="mt-1 text-secondary">{{ $item->description }}
                                    </h6>
                                    <div class="d-flex justify-content-between">
                                        <h4 class="mt-2 text-warning">
                                            Bill Amount: $ {{ number_format($item->amount,2)}}
                                        </h4>
                                        <h4 class="mt-2 text-danger">
                                            Due Amount: $ {{ number_format($item->amount -
                                            $item->stocks->sum('price'),2) }}
                                        </h4>
                                    </div>

                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>Stock Details</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Amount</th>
                                                                <th>Paid</th>
                                                                <th>Due</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($item->stocks as $stock)
                                                            <tr>
                                                                <td> {{ $stock->name }} </td>
                                                                <td>
                                                                    $ {{ number_format($stock->price,1) }}
                                                                    @if ($item->stocks->count() > 1)
                                                                    - {{ number_format($item->amount / $item->stocks->count(),1) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($stock->price - $item->amount / $item->stocks->count() <= 0) --- @else <p class="text-success">
                                                                        {{ number_format( $stock->price - $item->amount / $item->stocks->count(),1) }}
                                                                        </p>
                                                                        @endif
                                                                </td>
                                                                <td>
                                                                    @if($stock->price -
                                                                    $item->amount /
                                                                    $item->stocks->count() < 0) <p class="text-danger">
                                                                        {{ number_format( $stock->price - $item->amount / $item->stocks->count(),1) }}
                                                                        </p>
                                                                        @else
                                                                        ---
                                                                        @endif
                                                                </td>
                                                                <td>
                                                                    <i class="text-muted">
                                                                        @if($stock->description == !null)
                                                                        {{ $stock->description }}
                                                                        @else
                                                                        --
                                                                        @endif
                                                                    </i>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>
                                                    <p class="text-success mt-2">Paid = $ {{ $item->stocks->sum('price') }}
                                                        <br> (Names) =
                                                        @if($item->stocks->where('price', '>', 0)->isNotEmpty())
                                                        @foreach ($item->stocks->where('price', '>', 0) as $stock)
                                                        {{ $stock->name}}{{!$loop->last ? ',' : '' }}
                                                        @endforeach
                                                        @endif
                                                    </p>
                                                    <br>
                                                    <p class="text-danger">Due = $ {{ $item->amount - $item->stocks->sum('price') }}
                                                        <br> (Names) =
                                                        @if($item->stocks->where('price', 0)->isNotEmpty())
                                                        @foreach ($item->stocks->where('price', 0) as $stock)
                                                        {{ $stock->name }} {{ !$loop->last ? ' , ' : '' }}
                                                        @endforeach
                                                        @endif
                                                    </p>

                                                    @if ($item->stocks->count() > 1)
                                                    <p class="text-info mt-3">Avg = {{ number_format($item->amount / $item->stocks->count(),2) }}</p>

                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save
                                        changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="dropdown-item d-flex align-items-center bg-success" style="font-size: 14px; width: 100px; margin-top: 10px;" href="{{ route('add-more.edit',$item->id) }}">
                    <i data-feather="edit-2" class="icon-sm text-white" width="24" height="24"></i>
                    <span class="mx-3">Edit</span>
                </a>




                <a class="dropdown-item d-flex align-items-center" style="font-size: 14px; background-color: rgb(202, 12, 12); width: 100px; margin-top: 10px;" href="{{ route('delete.addmore',$item->id) }}" id="delete">
                    <i data-feather="trash-2" class="icon-sm text-white" width="24" height="24"></i>
                    <span class="mx-3">Delete</span>
                </a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
