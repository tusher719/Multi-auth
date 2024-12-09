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
            <li class="breadcrumb-item active" aria-current="page">Account</li>
        </ol>
    </nav>

    <div class="all-data">
        <h1>ALL Filter Data</h1>
        <div class="row">
            <div class="col-md-6">
                <h4>Income</h4>
                <div class="row">

                    <div class="col-md-4">
                        <div class="alert alert-success d-flex justify-content-between" role="alert">
                            <p>Total</p>
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($total,2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info d-flex justify-content-between" role="alert">
                            <h4 class="alert-heading px-1 mb-1 tx-16">{{ number_format($todayIncome,2) }}</h4>
                            <p>Today</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-secondary d-flex justify-content-between" role="alert">
                            <h4 class="alert-heading px-1 mb-1 tx-16">{{ number_format($yesterdayIncome,2) }}</h4>
                            <p>Yesterday </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info d-flex justify-content-between" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastsevenday,2) }}</h4>
                            <p>Last 7 days </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info d-flex justify-content-between" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($thisWeek,2) }}</h4>
                            <p>This Week </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info d-flex justify-content-between" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($thismonth,2) }}</h4>
                            <p>This Month </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-secondary d-flex justify-content-between" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastmonth,2) }}</h4>
                            <p>Last Month </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info d-flex justify-content-between" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($thisyear,2) }}</h4>
                            <p>This Year </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-secondary d-flex justify-content-between" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastYear,2) }}</h4>
                            <p>Last Year </p>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 mt-3">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Income</th>
                            <th>Expense</th>
                            <th>Expense - Income</th>
                        </tr>
                        @foreach($incomeExpenseData as $data)
                        <tr>
                            <th>{{ $data->name }}</th>
                            <td class="text-danger">{{ number_format($data->total_income) }}</td>
                            <td class="text-warning">
                                @if(!$data->total_expense == 0)
                                {{ number_format($data->total_expense) }}
                                @else
                                --
                                @endif
                            </td>
                            <td class="text-success">
                                @if($data->total_expense - $data->total_income )
                                {{ number_format($data->total_expense - $data->total_income) }}
                                @else
                                --
                                @endif
                                @php
                                $expense = $data->total_expense;
                                $income = $data->total_income;
                                $expenseIncome = $expense - $income;
                                @endphp
                                {{-- {{ $data->total_expense - $data->total_income }} --}}

                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-2">Income</h4>
                        @foreach($incomeData as $data)
                        <b>{{ $data->name }}</b> - {{ number_format($data->total_income) }} - {{ $data->income_count }}
                        <br>
                        @endforeach
                    </div>
                    <div class="col-md-6">

                        <h4 class="mb-2">Expense</h4>
                        @foreach($expenseData as $data)
                        <b>{{ $data->name }}</b> - {{ number_format($data->total_income) }} - {{ $data->income_count }}
                        <br>
                        @endforeach
                    </div>

                    <div class="col-md-12 mt-3">
                        @foreach($mergedData as $data)
                        <div class="summary">

                            <div class="accordion-wrapper">
                                <div class="accordion">
                                    <input type="radio" name="radio-a" class="accordion-toggle"
                                        id="#details-{{ $loop->index }}" checked>
                                    <div>
                                        <label class="accordion-label" for="#details-{{ $loop->index }}">
                                            <span><b style="color: #fff;">{{ $data->name }}</b></span>
                                            <span class=" btn border-success text-success position-relative"
                                                style="padding: 0px 10px; margin-left: 10px; margin-right: 10px">
                                                {{ number_format($data->total_income) }}
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{ $data->income_count }}
                                                </span>
                                            </span>
                                            <span class=" btn border-danger text-danger position-relative"
                                                style="padding: 0px 10px;">
                                                {{ number_format($data->total_expense) }}
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                    {{ $data->expense_count }}
                                                </span>
                                            </span>
                                            <span>SubTotal</span>
                                        </label>
                                    </div>
                                    <div class="accordion-content">
                                        <p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header custorm-header">
                                                        Income Details:
                                                    </div>
                                                    <div class="card-body">
                                                        @php
                                                        // Fetch individual income details for the current name
                                                        $individualIncomeDetails = \App\Models\Wallet::where('record',
                                                        'income')
                                                        ->where('name', $data->name)
                                                        ->get();
                                                        @endphp
                                                        @php
                                                        // Fetch individual expense details for the current name
                                                        $individualExpenseDetails = \App\Models\Wallet::where('record',
                                                        'expense')
                                                        ->where('name', $data->name)
                                                        ->get();
                                                        @endphp
                                                        <ul class="list-group mt-2">
                                                            <table class="table table-success table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="custom-td">Date</th>
                                                                        <th class="custom-td">Payment Type</th>
                                                                        <th class="custom-td">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-group-divider">
                                                                    @foreach($individualIncomeDetails as $incomeDetail)
                                                                    <tr>
                                                                        <td>{{ $incomeDetail->rdate }}
                                                                        </td>
                                                                        <td>{{ $incomeDetail->payment_type }}
                                                                        </td>
                                                                        <td>{{ number_format($incomeDetail->amount,2) }}
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="2" style="text-align: right">
                                                                            <b>Total Amount:</b>
                                                                        </td>
                                                                        <td><b>{{ number_format($data->total_income,2)
                                                                                }}</b></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Expense Details:
                                                    </div>
                                                    <div class="card-body">
                                                        @php
                                                        // Fetch individual expense details for the current name
                                                        $individualExpenseDetails = \App\Models\Wallet::where('record',
                                                        'expense')
                                                        ->where('name', $data->name)
                                                        ->get();
                                                        @endphp

                                                        <ul class="list-group mt-2">
                                                            <table class="table table-danger table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>Payment Type</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                @foreach($individualExpenseDetails as $expenseDetail)
                                                                <tr>
                                                                    <td>{{ $expenseDetail->rdate }}</td>
                                                                    <td>{{ $expenseDetail->payment_type }}</td>
                                                                    <td>{{ number_format($expenseDetail->amount,2) }}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                <tr class="strong">
                                                                    <td colspan="2" style="text-align: right"> <b>Total
                                                                            Amount:</b> </td>
                                                                    <td> <b>{{ number_format($data->total_expense,2)
                                                                            }}</b> </td>

                                                                </tr>
                                                            </table>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </div>

    <h1>Financial Summary</h1>
    <?php
        // Check if data is available
        if (isset($labels) && isset($data)) {
            echo '<canvas id="myChart" width="800" height="400"></canvas>';
        } else {
            echo '<p>No data available for chart.</p>';
        }
        ?>

    <script>
        <?php
                // Check if data is available again (for script inclusion)
                if (isset($labels) && isset($data)) {
                ?>
            var config = {
                    type: 'combo',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            label: 'Income',
                            backgroundColor: 'green',
                            borderColor: 'green',
                            data: @json($data['income']),
                            fill: false,
                            yAxisID: 'y-axis-1',
                        }, {
                            label: 'Expense',
                            backgroundColor: 'red',
                            borderColor: 'red',
                            data: @json($data['expense']),
                            fill: false,
                            yAxisID: 'y-axis-1',
                        }, {
                            label: 'Savings',
                            backgroundColor: 'blue',
                            borderColor: 'blue',
                            data: @json($data['savings']),
                            fill: false,
                            yAxisID: 'y-axis-2',
                        }]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: 'day' // Change unit as needed (optional)
                                }
                            }],
                            yAxes: [{
                                id: 'y-axis-1',
                                label: 'Income & Expense',
                                position: 'left'
                            }, {
                                id: 'y-axis-2',
                                label: 'Savings',
                                position: 'right'
                            }]
                        }
                    }
                };

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, config);
            <?php } ?>
    </script>



</div>




@endsection