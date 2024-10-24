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
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($total,2) }}</h4>
                            <p>Total</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info" role="alert">
                            <div class="d-flex">
                                <h4 class="alert-heading px-1 mb-1 tx-16">{{ number_format($todayIncome,2) }}</h4>
                            </div>
                            <p>Today</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-secondary" role="alert">
                            <div class="d-flex">
                                <h4 class="alert-heading px-1 mb-1 tx-16">{{ number_format($yesterdayIncome,2) }}</h4>
                            </div>
                            <p>Yesterday </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastsevenday,2) }}</h4>
                            <p>Last 7 days </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($thisWeek,2) }}</h4>
                            <p>This Week </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($thismonth,2) }}</h4>
                            <p>This Month </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-secondary" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastmonth,2) }}</h4>
                            <p>Last Month </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($thisyear,2) }}</h4>
                            <p>This Year </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-secondary" role="alert">
                            <h4 class="alert-heading mb-1 tx-16">{{ number_format($lastYear,2) }}</h4>
                            <p>Last Year </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <h4>Expense</h4>
                <div class="row">
                    <div class="col-md-12">
                        @foreach($incomeData as $data)
                        <b>{{ $data->name }}</b> - {{ $data->total_income }} - {{ $data->income_count }} <br>
                        @endforeach
                    </div>
                    <div class="col-md-12 mt-3">
                        @foreach($expenseData as $data)
                        <b>{{ $data->name }}</b> - {{ $data->total_income }} - {{ $data->income_count }} <br>
                        @endforeach
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
                                <td class="text-danger">{{ $data->total_income }}</td>
                                <td class="text-warning">
                                    @if(!$data->total_expense == 0)
                                    {{ $data->total_expense }}
                                    @else
                                    --
                                    @endif
                                </td>
                                <td class="text-success">
                                    @if($data->total_expense - $data->total_income )
                                    {{ $data->total_expense - $data->total_income }}
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