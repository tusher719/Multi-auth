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
            <li class="breadcrumb-item">Wallet</li>
            <li class="breadcrumb-item active" aria-current="page">Account</li>
        </ol>
    </nav>

    <div class="d-flex justify-around">
        <div class="show d-flex mb-2 px-7">
            <div class="income rounded ml-3 py-1 bg-success" style="margin-right: 10px; padding: 0 100px 0 0px">
                <div class="box d-flex align-items-center justify-content-between">
                    <div class="boxmain px-3">
                        <i data-feather="trending-up"></i>
                    </div>
                    <div class="boxsub d-flex">
                        <div class="main-inc">
                            <strong class="tx-14">Income</strong> <br>
                            <strong style="font-size: 20px" class="incomeAmount"
                                data-actual-income="{{ number_format($income - $expense, 2) }}">{{
                                number_format($income
                                -
                                $expense, 2) }}</strong> <br>
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
                        <i data-feather="trending-down"></i>
                    </div>
                    <div class="boxsub">
                        <strong>Expense</strong> <br>
                        <strong class="incomeAmount" style="font-size: 20px">{{ number_format($expense,2)
                            }}</strong>
                    </div>
                </div>
            </div>

            <div class="income rounded ml-3 py-1 bg-primary" style="margin-right: 10px; padding: 0 100px 0 0px">
                <div class="box d-flex align-items-center justify-content-between">
                    <div class="boxmain px-3">
                        <i data-feather="credit-card"></i>
                    </div>
                    <div class="boxsub">
                        <strong>Saving</strong> <br>
                        <strong class="incomeAmount" style="font-size: 20px">{{ number_format($saving,2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-7">
            @if(Auth::user()->can('admin.add'))
            <div class="mt-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target=".bd-example-modal-lg">
                    <i data-feather="plus"></i> Add Record
                </button>
                <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Wallet</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="btn-close"></button>
                            </div>
                            <form action="{{ route('store.wallet') }}" method="POST">
                                @csrf
                                <div class="modal-body">

                                    <div class="main-content d-flex">
                                        <div class="box d-flex flex-column flex-grow-1">
                                            {{-- Flexblox Box-1 --}}
                                            <div class="flx-1 p-5 flex-fill" id="backgroundContainer"
                                                style="background-color: darkorange">
                                                <div class="select-cat mx-5">
                                                    {{-- <select name="record" id="recordSelect"
                                                        class="form-select form-select-lg">
                                                        <option disabled>Select one</option>
                                                        <option value="income">Income</option>
                                                        <option value="expense">Expense</option>
                                                        <option value="saving">Saving</option>
                                                    </select> --}}
                                                    <div class="grid-container">
                                                        <button id="incomeBtn" class="grid-item"
                                                            data-value="income">Income</button>
                                                        <button id="expenseBtn" class="grid-item"
                                                            data-value="expense">Expense</button>
                                                        <button id="savingBtn" class="grid-item"
                                                            data-value="saving">Saving</button>
                                                    </div>
                                                </div>
                                                <div class="amount mx-5 pt-3">
                                                    <div class="custom-floating">
                                                        <div class="icon-container">
                                                            <i id="amountIcon" class="icon mr-2"></i>
                                                        </div>
                                                        <label for="customAmount"
                                                            class="form-label customAmount">Amount</label>
                                                        <input type="text" name="amount"
                                                            class="form-control form-control-lg"
                                                            data-inputmask="'alias': 'currency', 'prefix':'$'"
                                                            autocomplete="off" placeholder=" ">
                                                    </div>
                                                </div>
                                            </div>



                                            {{-- Flexblox Box-2 --}}
                                            <div class="flx-2 p-2 mt-5 flex-fill">
                                                <div class="date-time d-flex justify-content-around">
                                                    <div class="custom-floating-date">
                                                        <input type="date" name="rdate" id="customDateInput"
                                                            class="custom-form-control" placeholder=" ">
                                                        <label for="customDateInput"
                                                            class="custom-form-label">Date</label>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <div class="custom-floating-time">
                                                            <input type="time" name="rtime" id="customTimeInput"
                                                                class="custom-form-control" placeholder=" " required>
                                                            <label for="customTimeInput"
                                                                class="custom-form-label">Time</label>
                                                        </div>


                                                        {{-- <label class="form-label">Time</label>
                                                        <input type="time" name="rtime" class="form-control"> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Flexblox Box-3 --}}
                                        <div class="box2 p-4 d-flex align-items-stretch">
                                            <div class="flx-3">
                                                <div class="name">
                                                    <div class="custom-floating">
                                                        <input type="text" name="name" id="customNameInput"
                                                            class="form-control custom-form-control" autocomplete="off"
                                                            placeholder=" ">
                                                        <label for="customNameInput"
                                                            class="custom-form-label">Name</label>
                                                    </div>
                                                </div>
                                                <div class="payment-type">
                                                    <select name="payment_type" class="form-select form-select-lg">
                                                        <option selected disabled>Payment type</option>
                                                        <option>Cash</option>
                                                        <option>bKash</option>
                                                        <option>Nagad</option>
                                                        <option>Rocket</option>
                                                    </select>
                                                </div>
                                                <div class="note mt-3">
                                                    <div class="custom-floating-textarea-container">
                                                        <textarea class="custom-floating-textarea form-control"
                                                            name="note" id="customTextarea" rows="4" placeholder=" "
                                                            required></textarea>
                                                        <label for="customTextarea"
                                                            class="custom-floating-textarea-label">Note</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
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


    <div class="alldata px-7 py-2">
        <div class="row">

            <div class="col-md-2">
                <div class="alert alert-secondary d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">Total Amount</p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($total,2) }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">Today </p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($todayIncome,2) }}</h4>

                </div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">Yesterday</p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($yesterdayIncome,2) }}
                    </h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">Last 7 days </p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($lastsevenday,2) }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">This Week </p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($thisWeek,2) }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-light d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">This Month </p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($thismonth,2) }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-secondary d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">Last Month </p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($lastmonth,2) }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">This Year </p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($thisyear,2) }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                    <p class="tx-14">Last Year </p>
                    <h4 class="incomeAmount alert-heading tx-14">{{ number_format($lastYear,2) }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Line chart</h6>
                            <div id="morrisLine"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="box d-flex justify-content-between align-items-center">
                                <h6 class="card-title">Bar chart</h6>
                                <select class="form-select w-25 changeYear" id="exampleFormControlSelect1"
                                    onchange="filterData(this.value)">
                                    @for ($i=2020; $i<=date('Y'); $i++) <option {{ ($year==$i) ? 'selected' : '' }}
                                        value="{{ $i }}">
                                        {{$i}}
                                        </option>
                                        @endfor
                                </select>
                            </div>
                            <div id="morrisBarT"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Area chart</h6>
                            <div id="morrisArea"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Donut chart</h6>
                            <div id="morrisDonut"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="filter">
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Filter</label>
                        <select class="form-select" id="exampleFormControlSelect1" onchange="filterData(this.value)">
                            <option selected="" disabled="">Filter</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7days">Last 7 days</option>
                            <option value="thisweek">This Week</option>
                            <option value="thismonth">This Month</option>
                            <option value="lastmonth">Last Month</option>
                            <option value="thisyear">This Year</option>
                            <option value="lastyear">Last Year</option>
                        </select>
                    </div>
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
            {{-- @if($item->status == 'active')--}}
            {{-- <div class="border rounded-circle border-success text-success"><i style="height: 15px; width: 18px"
                    data-feather="check"></i></div>--}}
            {{-- @else--}}
            {{-- <div class="border rounded-circle border-danger text-danger"><i data-feather="x"></i></div>--}}
            {{-- @endif--}}
            <div><strong>{{ $item->name }}</strong></div>
            <div class="vr"></div>
            <div>{{ $item->payment_type }}</div>
            <div class="vr"></div>

            <div>{{ $item->note }}</div>
            <div class="vr"></div>
            <div>{{ $item->record }}</div>
            <div class="vr"></div>
            {{-- <div>{{ $item->rdate }}</div>--}}
            {{-- <div>{{ $item->rtime->formate("h:i A") }}</div>--}}
            <div>{{ Carbon\Carbon::parse($item->rdate)->format('d-M-Y') }}</div>
            <div class="vr"></div>
            <div>{{ Carbon\Carbon::parse($item->rtime)->format('h:i A') }}</div>
            <div class="vr"></div>


            {{-- {{ \Carbon\Carbon::now()->format("d/m/y h:i A") }}--}}

            <div>
                @if($item->record == 'expense')
                <strong class="text-danger tx-16 incomeAmount"><span>-BDT {{ number_format($item->amount,2)
                        }}</span></strong>
                @elseif($item->record == 'income')
                <strong class="text-success tx-16 incomeAmount"><span>BDT {{ number_format($item->amount,2)
                        }}</span></strong>
                @else
                <strong class="text-info tx-16 incomeAmount"><span>BDT {{ number_format($item->amount,2)
                        }}</span></strong>
                @endif
            </div>
            <div>
                {{-- <i data-feather="more-vertical"></i>--}}

                <div class="dropdown">
                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" class="" aria-haspopup="true"
                        aria-expanded="false">
                        <i data-feather="more-vertical"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if(Auth::user()->can('admin.edit'))
                        <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;"
                            href="{{ route('edit.wallet',$item->id) }}">
                            <i data-feather="edit-2" class="icon-sm" width="24" height="24"></i>
                            <span class="mx-3">Edit</span>
                        </a>
                        @endif
                        @if(Auth::user()->can('admin.delete'))
                        <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" id="delete"
                            href="{{ route('delete.wallet',$item->id) }}">
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            // Get the date and time input elements
            const dateInput = document.getElementById('customDateInput');
            const timeInput = document.getElementById('customTimeInput');
            const now = new Date();
    
            // Format the current date as YYYY-MM-DD
            const year = now.getFullYear();
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
    
            // Format the current time as HH:MM
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const formattedTime = `${hours}:${minutes}`;
    
            // Set the value of the date and time inputs
            dateInput.value = formattedDate;
            timeInput.value = formattedTime;
        });

// ======================= //
document.addEventListener('DOMContentLoaded', function() {
    const backgroundContainer = document.getElementById('backgroundContainer');
    const amountIcon = document.getElementById('amountIcon');
    const buttons = document.querySelectorAll('.grid-item');

    // Function to update the background color and icon based on selection
    function updateUI(value) {
        let iconClass = '';
        let bgColor = 'darkorange'; // Default color

        switch (value) {
            case 'income':
                iconClass = 'fa-solid fa-plus'; // Font Awesome icon for income
                bgColor = '#97D3CB';
                break;
            case 'expense':
                iconClass = 'fa-solid fa-minus'; // Font Awesome icon for expense
                bgColor = '#F19761';
                break;
            case 'saving':
                iconClass = 'fas fa-piggy-bank'; // Font Awesome icon for saving
                bgColor = '#7c8c97';
                break;
            default:
                iconClass = '';
                break;
        }

        backgroundContainer.style.backgroundColor = bgColor;
        amountIcon.className = `icon ${iconClass}`;
    }

    // Load the last selected value from localStorage, if it exists
    const lastSelectedValue = localStorage.getItem('selectedRecord');
    if (lastSelectedValue) {
        updateUI(lastSelectedValue);
        document.querySelector(`[data-value="${lastSelectedValue}"]`).classList.add('selected');
    }

    // Event listener for each button
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedValue = this.getAttribute('data-value');
            updateUI(selectedValue);

            // Remove the 'selected' class from all buttons, then add it to the clicked one
            buttons.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');

            // Save the selection in localStorage
            localStorage.setItem('selectedRecord', selectedValue);
        });
    });
});




</script>

<script>
    $('.changeYear').change(function() {
        var year = $(this).val();
        window.location.href = "{{ url('wallet?year=') }}"+year;
    });


    $(function() {
        'use strict';

        var colors = {
            primary        : "#6571ff",
            secondary      : "#7987a1",
            success        : "#05a34a",
            info           : "#66d1d1",
            warning        : "#fbbc06",
            danger         : "#ff3366",
            light          : "#e9ecef",
            dark           : "#060c17",
            muted          : "#7987a1",
            gridBorder     : "rgba(77, 138, 240, .15)",
            bodyColor      : "#b8c3d9",
            cardBg         : "#0c1427",
        }
        

        var fontFamily = "'Roboto', Helvetica, sans-serif"
        

        // Line Chart
        new Morris.Line({
            element: 'morrisLine',
            data: [
                { year: '2008', value: 2 },
                { year: '2009', value: 9 },
                { year: '2010', value: 5 },
                { year: '2011', value: 12 },
                { year: '2012', value: 5 }
            ],
            xkey: 'year',
            ykeys: ['value'],
            labels: ['value'],
            lineColors: [colors.danger],
            gridLineColor: [colors.gridBorder],
            gridTextColor: colors.bodyColor,
            gridTextFamily: fontFamily,
        });
        
        
        // Area Chart
        Morris.Area({
            element: 'morrisArea',
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75,  b: 65 },
                { y: '2008', a: 50,  b: 40 },
                { y: '2009', a: 75,  b: 65 },
                { y: '2010', a: 50,  b: 40 },
                { y: '2011', a: 75,  b: 65 },
                { y: '2012', a: 100, b: 90 }
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Series A', 'Series B'],
            lineColors: [colors.danger, colors.info],
            fillOpacity: 0.1,
            gridLineColor: [colors.gridBorder],
            gridTextColor: colors.bodyColor,
            gridTextFamily: fontFamily,
        });
        

        // Pass the data from the controller to the Blade file
        var chartData = @json($data['getTotalCustomerMonth']);

        // Morris Bar Chart
        Morris.Bar({
            element: 'morrisBarT',
            data: chartData.map(function(monthData) {
                return {
                    y: monthData.month,         // Month abbreviation (e.g., 'Jan')
                    b: monthData.totalIncome,   // Total Income
                    c: monthData.totalExpense   // Total Expense
                };
            }),
            xkey: 'y',                                  // This is the x-axis key (Month)
            ykeys: ['b', 'c'],                          // The data keys for Customers, Income, Expense
            labels: ['Total Income', 'Total Expense'],  // Labels for the bar chart
            barColors: ['#5bc0de', '#d9534f'],          // Colors for each series
            gridLineColor: '#e4e4e4',
            gridTextColor: '#333',
            gridTextFamily: 'Arial, sans-serif',
        });


        // Donut Chart
        Morris.Donut({
            element: 'morrisDonut',
            data: [
            {label: "Members", value: {{ $totalMbrs ?? 0 }}},
            {label: "Income", value: {{ $income ?? 0 }}},
            {label: "Expense", value: {{ $expense ?? 0 }}}
            ],
            colors: [colors.danger, colors.info, colors.primary],
            labelColor: colors.bodyColor,
        });

    });
    
</script>
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