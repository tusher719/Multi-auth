@extends('admin.admin_dashboard')
@section('admin')

    <!-- cdn link -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Wallet</li>
                <li class="breadcrumb-item active" aria-current="page">Account</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-4 px-7">
                @if(Auth::user()->can('admin.add'))
                    <div class="col-md-12 mt-3 mb-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                            <i data-feather="plus"></i> Add Record
                        </button>
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Wallet</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                    </div>
                                    <form action="{{ route('store.wallet') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">

                                            <div class="row p-3">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label class="form-label">Amount</label>
                                                    <input type="text" name="amount" class="form-control form-control-lg" autocomplete="off" placeholder="Amount">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Select One</label>
                                                    <select name="record" class="form-select form-select-lg">
                                                        <option selected disabled>Select one</option>
                                                        <option value="income">Income</option>
                                                        <option value="expense">Expense</option>
                                                        <option value="saving">Saving</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control form-control-lg" autocomplete="off" placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Payment type</label>
                                                    <select name="payment_type" class="form-select form-select-lg">
                                                        <option selected disabled>Payment type</option>
                                                        <option>Cash</option>
                                                        <option>bKash</option>
                                                        <option>Nagad</option>
                                                        <option>Rocket</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Date</label>
                                                    <input type="date" name="rdate" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Time</label>
                                                    <input type="time" name="rtime" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Note</label>
                                                <textarea class="form-control" name="note" rows="4" placeholder="Note"></textarea>
                                            </div>
                                            <div class="form-check mb-4 my-3">
                                                <input type="checkbox" class="form-check-input" name="status" id="checkChecked" value="active">
                                                <label class="form-check-label" for="checkChecked">
                                                    Active
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>


        <div class="show d-flex mb-2 px-7">
            <div class="income rounded ml-3 py-1 bg-success" style="margin-right: 10px; padding: 0 100px 0 0px">
                <div class="box d-flex align-items-center justify-content-between">
                    <div class="boxmain px-3">
                        <i data-feather="trending-up" ></i>
                    </div>
                    <div class="boxsub d-flex">
                        <div class="main-inc">
                            <strong class="tx-14">Income</strong> <br>
                            <strong style="font-size: 20px" class="incomeAmount" data-actual-income="{{ number_format($income - $expense, 2) }}">{{ number_format($income - $expense, 2) }}</strong> <br>
                            <strong class="tx-14">Total Income: {{ number_format($income,2) }}</strong>
                        </div>
                        <div class="hide-inc">
                            <button class="btn" onclick="toggleIncomeVisibility()">
                                <i id="eyeIcon" data-feather="eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="income rounded ml-3 py-1 bg-danger" style="margin-right: 10px; padding: 0 100px 0 0px">
                <div class="box d-flex align-items-center justify-content-between">
                    <div class="boxmain px-3">
                        <i data-feather="trending-down" ></i>
                    </div>
                    <div class="boxsub">
                        <strong>Expense</strong> <br>
                        <strong class="incomeAmount" style="font-size: 20px">{{ number_format($expense,2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="income rounded ml-3 py-1 bg-primary" style="margin-right: 10px; padding: 0 100px 0 0px">
                <div class="box d-flex align-items-center justify-content-between">
                    <div class="boxmain px-3">
                        <i data-feather="credit-card" ></i>
                    </div>
                    <div class="boxsub">
                        <strong>Saving</strong> <br>
                        <strong class="incomeAmount" style="font-size: 20px">{{ number_format($saving,2) }}</strong>
                    </div>
                </div>
            </div>
        </div>




        <div class="alldata px-7 py-2">
            <div class="row">

                <div class="col-md-2">
                    <div class="alert alert-secondary" role="alert">
                        <h4 class="alert-heading mb-1 tx-16">{{ number_format($total,2) }}</h4>
                        <p>Total</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-info" role="alert">
                        <div class="d-flex">
                            <h4 class="alert-heading px-1 mb-1 tx-16">{{ number_format($todayIncome,2) }}</h4>
                        </div>
                        <p>Today ( <span class="tx-12">{{ \Carbon\Carbon::parse($today)->format("D, d-M") }}</span> ) </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-info" role="alert">
                        <div class="d-flex">
                            <h4 class="alert-heading px-1 mb-1 tx-16">{{ number_format($yesterdayIncome,2) }}</h4>
                        </div>
                        <p>Yesterday ( <span class="tx-12">{{ \Carbon\Carbon::parse($yesterday)->format("D, d-M") }}</span> ) </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastsevenday,2) }}</h4>
                        <p>Last 7 days ( <span class="tx-12">{{ Carbon\Carbon::parse($sevenDaysAgo)->format('D,d M')  }} - {{ Carbon\Carbon::parse($currentDate)->format('D,d M')  }}</span> )</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading mb-1 tx-16">{{ number_format($thisWeek,2) }}</h4>
                        <p>This Week ( <span class="tx-12">{{ Carbon\Carbon::parse($startOfWeek)->format('D, d M')  }} - {{ Carbon\Carbon::parse($endOfWeek)->format('D d M')  }}</span> )</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-light" role="alert">
                        <h4 class="alert-heading mb-1 tx-16">{{ number_format($thismonth,2) }}</h4>
                        <p>This Month ( <span class="tx-12">{{ $monthe }}</span> )</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-secondary" role="alert">
                        <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastmonth,2) }}</h4>
                        <p>Last Month ( <span class="tx-12">{{ $lastMonthName }}</span> ) </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading mb-1 tx-16">{{ number_format($thisyear,2) }}</h4>
                        <p>This Year ( <span class="tx-12">{{ $year }}</span> ) </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastYear,2) }}</h4>
                        <p>Last Year ( <span class="tx-12">{{ $lastYearName }}</span> ) </p>
                    </div>
                </div>

            </div>
        </div>

        @foreach ($alldata as $key => $item)
            @if($item->rdate != false)
            <div class="px-7">
                <strong>{{ Carbon\Carbon::parse($item->rdate)->format('d-M-Y') }}</strong> -


                @php
                    // Parse the date string to a Carbon instance
                    $rdate = \Carbon\Carbon::parse($item->rdate);

                    // Calculate the difference from now
                    $diff = $rdate->diff(\Carbon\Carbon::now());

                    // Extract years, months, and days from the difference
                    $years = $diff->y;
                    $months = $diff->m;
                    $days = $diff->d;

                    // Initialize an empty string to hold the output
                    $output = "";

                    // Append years to the output if it's greater than 0
                    if ($years > 0) {
                        $output .= "$years Year" . ($years > 1 ? "s" : "") . " ";
                    }

                    // Append months to the output if it's greater than 0
                    if ($months > 0) {
                        $output .= "$months Month" . ($months > 1 ? "s" : "") . " ";
                    }

                    // Append days to the output if it's greater than 0
                    if ($days > 0) {
                        $output .= "$days Day" . ($days > 1 ? "s" : "") . " ";
                    }

                    // If output is still empty, means the date is either today or in the future
                    // So, set output as "today"
                    if (empty($output)) {
                        $output = "Today";
                    }
                @endphp

                @if($output == 'Today')
                    {{ $output }}
                @else
                    {{ $output }} ago
                @endif


            </div>
            @endif

                <div class="main px-7">
                    <div class="single rounded bg-white text-dark px-5 py-3 mb-3 d-flex justify-content-between">
{{--                        @if($item->status == 'active')--}}
{{--                            <div class="border rounded-circle border-success text-success" ><i style="height: 15px; width: 18px" data-feather="check" ></i></div>--}}
{{--                        @else--}}
{{--                            <div class="border rounded-circle border-danger text-danger"><i data-feather="x" ></i></div>--}}
{{--                        @endif--}}
                        <div><strong>{{ $item->name }}</strong></div> <div class="vr"></div>
                        <div>{{ $item->payment_type }}</div> <div class="vr"></div>

                        <div>{{ $item->note }}</div> <div class="vr"></div>
                        <div>{{ $item->record }}</div> <div class="vr"></div>
{{--                        <div>{{ $item->rdate }}</div>--}}
{{--                        <div>{{ $item->rtime->formate("h:i A") }}</div>--}}
                        <div>{{ Carbon\Carbon::parse($item->rdate)->format('d-M-Y') }}</div> <div class="vr"></div>
                        <div>{{ Carbon\Carbon::parse($item->rtime)->format('h:i A') }}</div> <div class="vr"></div>


{{--                        {{ \Carbon\Carbon::now()->format("d/m/y h:i A") }}--}}

                        <div>
                            @if($item->record == 'expense')
                                <strong class="text-danger tx-16 incomeAmount"><span>-BDT {{ number_format($item->amount,2) }}</span></strong>
                            @elseif($item->record == 'income')
                                <strong class="text-success tx-16 incomeAmount"><span>BDT {{ number_format($item->amount,2) }}</span></strong>
                            @else
                                <strong class="text-info tx-16 incomeAmount"><span>BDT {{ number_format($item->amount,2) }}</span></strong>
                            @endif
                        </div>
                        <div>
{{--                            <i data-feather="more-vertical" ></i>--}}

                            <div class="dropdown">
                                <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" ></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if(Auth::user()->can('admin.edit'))
                                        <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" href="{{ route('cp.edit.students',$item->id) }}">
                                            <i data-feather="edit-2" class="icon-sm" width="24" height="24" ></i>
                                            <span class="mx-3">Edit</span>
                                        </a>
                                    @endif
                                    @if(Auth::user()->can('admin.delete'))
                                        <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" id="delete" href="{{ route('delete.wallet',$item->id) }}">
                                            <i data-feather="trash-2" class="icon-sm" width="24" height="24"></i>
                                            <span class="mx-3">Delete</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




        @endforeach


    </div>


    <script>
        // Check local storage for saved visibility state on page load
        window.onload = function() {
            var isHidden = localStorage.getItem('incomeVisibility');
            if (isHidden === 'hidden') {
                toggleIncomeVisibility();
            }
        };

        function toggleIncomeVisibility() {
            var incomeElements = document.querySelectorAll('.incomeAmount');
            var eyeIcon = document.getElementById('eyeIcon');

            // Loop through all elements with class 'incomeAmount'
            incomeElements.forEach(function(element) {
                // Check if the income value is currently hidden
                if (element.innerText.includes("******")) {
                    // If hidden, show the actual income value
                    var actualIncome = element.dataset.actualIncome;
                    element.innerText = actualIncome;
                    // Change the icon to "eye"
                    eyeIcon.setAttribute("data-feather", "eye");
                    // Update local storage
                    localStorage.setItem('incomeVisibility', 'visible');
                } else {
                    // If not hidden, hide the income value and store the actual income value
                    var incomeValue = element.innerText;
                    element.dataset.actualIncome = incomeValue;
                    // Replace the income value with "***"
                    element.innerText = "******";
                    // Change the icon to "eye-off"
                    eyeIcon.setAttribute("data-feather", "eye-off");
                    // Update local storage
                    localStorage.setItem('incomeVisibility', 'hidden');
                }
            });

            // Update Feather icons
            feather.replace();
        }
    </script>

@endsection
