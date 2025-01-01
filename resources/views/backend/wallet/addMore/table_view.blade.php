<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name (Stocks)</th>
            <th>Amount</th>
            <th>Stock Details</th>
            <th>Total Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $key => $item)
        <tr>
            <!-- Category Basic Details -->
            <td>{{ $key+1 }}</td>
            <td>{{ $item->name }} ({{ $item->stocks->count() }})</td>
            <td>${{ number_format($item->amount, 2) }}</td>

            <!-- Stock Details (Collapsible Table for Clarity) -->
            <td>
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Paid</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item->stocks as $stock)
                        <tr>
                            <td>{{ $stock->name }}</td>
                            <td>${{ number_format($stock->price, 2) }}</td>
                            <td class="text-success">
                                {{ $stock->price >= ($item->amount / $item->stocks->count()) ? number_format($stock->price - $item->amount / $item->stocks->count(), 2) : '---' }}
                            </td>
                            <td class="text-danger">
                                {{ $stock->price < ($item->amount / $item->stocks->count()) ? number_format($item->amount / $item->stocks->count() - $stock->price, 2) : '---' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>

            <!-- Total Price Section -->
            <td>
                <p class="text-success">Paid: ${{ number_format($item->stocks->sum('price'), 2) }}</p>
                @if($item->stocks->sum('price') >= $item->amount)
                <p class="text-success">Extra: ${{ number_format($item->stocks->sum('price') - $item->amount, 2) }}</p>

                @else
                <p class="text-danger">Due: ${{ number_format($item->amount - $item->stocks->sum('price'), 2) }}</p>

                @endif
                {{-- <p class="text-danger">Due: ${{ number_format($item->amount - $item->stocks->sum('price'), 2) }}</p> --}}
            </td>

            <!-- Actions -->
            <td class="d-flex gap-2">

                <div class="option">
                    {{-- <i data-feather="more-vertical"></i>--}}

                    <div class="dropdown">
                        <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="settings"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <!-- View Button -->
                            @if(Auth::user()->can('admin.edit'))
                            <button class="dropdown-item d-flex align-items-center" style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#viewModal{{ $item->id }}">
                                {{-- <i data-feather="eye"></i> View --}}
                                <i data-feather="eye" class="icon-sm" width="24" height="24"></i>
                                <span class="mx-3">View</span>
                            </button>
                            @endif
                            <!-- Edit Button -->
                            @if(Auth::user()->can('admin.edit'))
                            <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" href="{{ route('add-more.edit', $item->id) }}">
                                <i data-feather="edit-2" class="icon-sm" width="24" height="24"></i>
                                <span class="mx-3">Edit</span>
                            </a>
                            @endif
                            <!-- Delete Button -->
                            @if(Auth::user()->can('admin.delete'))
                            <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" id="delete" href="{{ route('delete.addmore', $item->id) }}">
                                <i data-feather="trash-2" class="icon-sm" width="24" height="24"></i>
                                <span class="mx-3">Delete</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal Template -->
                <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel">{{ $item->name }} (ID: {{ $item->id }})</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <h6 class="text-muted">{{ $item->description ?? 'No description available.' }}</h6>

                                <div class="d-flex justify-content-between my-3">
                                    <h4 class="text-warning">Bill Amount: ${{ number_format($item->amount, 2) }}</h4>
                                    <h4 class="text-danger">Due: ${{ number_format($item->amount - $item->stocks->sum('price'), 2) }}</h4>
                                </div>

                                <!-- Stock Details -->
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->stocks as $stock)
                                        <tr>
                                            <td>{{ $stock->name }}</td>
                                            <td>${{ number_format($stock->price, 2) }}</td>
                                            <td class="text-success">
                                                {{ $stock->price >= ($item->amount / $item->stocks->count()) ? number_format($stock->price - $item->amount / $item->stocks->count(), 2) : '---' }}
                                            </td>
                                            <td class="text-danger">
                                                {{ $stock->price < ($item->amount / $item->stocks->count()) ? number_format($item->amount / $item->stocks->count() - $stock->price, 2) : '---' }}
                                            </td>
                                            <td>{{ $stock->description ?? 'No description available.' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>
