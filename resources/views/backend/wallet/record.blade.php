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
            <div class="col-md-10">
                <form id="myForm" method="POST" action="{{ route('submit.form') }}">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2">
                                <button id="add_field_button" class="btn btn-info mb-3">Add More Fields</button>
                            </div>
                            <div class="col-md-2">
                                <!-- Main amount field outside the form -->
                                <input type="number" class="form-control" id="main_amount" name="main_amount"
                                    placeholder="Main Amount" value="100">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <label class="form-label">Average Amount:</label>
                                <input type="text" class="alert alert-secondary" disabled id="average_amount"
                                    name="average_amount" readonly placeholder="Average Amount" />
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Total Amount:</label>
                                <input type="text" class="alert alert-light" disabled id="total_amount"
                                    name="total_amount" readonly placeholder="Total Amount" />
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Total Due:</label>
                                <input type="text" class="alert alert-danger" disabled id="total_due" name="total_due"
                                    readonly placeholder="Total Due" />
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Total Extra:</label>
                                <input type="text" class="alert alert-success" disabled id="total_extra"
                                    name="total_extra" readonly placeholder="Total Extra" />
                            </div>
                        </div>

                        <div id="input_fields_wrap">
                            <!-- First input field (active by default) -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="text" class="form-control row_number" name="row_number[]"
                                            style="width: 40px" readonly placeholder="Row Number" />
                                        <input type="text" class="form-control name" name="name[]" placeholder="Name"
                                            style="margin-left: 5px" />
                                        <input type="number" class="form-control amount" name="amount[]"
                                            placeholder="Amount" style="margin-left: 5px" />
                                        <input type="text" class="form-control due" disabled name="due[]" readonly
                                            placeholder="Due" style="margin-left: 5px" />
                                        <input type="text" class="form-control extra" disabled name="extra[]"
                                            placeholder="Extra" style="margin-left: 5px" />
                                        <a href="#" class="remove_field btn btn-danger btn-sm"
                                            style="margin-left: 5px"><i data-feather="x"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </form>
            </div>
            {{-- <div class="col-md-6">

            </div> --}}
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
                var wrapper = $("#input_fields_wrap");
                var add_button = $("#add_field_button");
                var mainAmount = parseInt($("#main_amount").val());

                // Function to calculate the due amount
                function calculateDue() {
                    var totalAmount = 0;
                    $(".amount").each(function(index) {
                        totalAmount += parseFloat($(this).val()) || 0;
                    });
                    var averageAmount = mainAmount / $(".name").length;
                    $("#average_amount").val(averageAmount.toFixed(2));
                    $(".amount").each(function(index) {
                        var amount = parseFloat($(this).val()) || 0;
                        var due = averageAmount - amount;
                        // Set due to 0.00 if negative
                        if (due < 0) {
                            due = 0.00;
                        }
                        $(".due").eq(index).val(due.toFixed(2));
                    });
                }

                // Function to calculate the extra amount
                function calculateExtra() {
                    var totalAmount = 0;
                    $(".amount").each(function(index) {
                        totalAmount += parseFloat($(this).val()) || 0;
                    });
                    var averageAmount = mainAmount / $(".name").length;
                    $("#average_amount").val(averageAmount.toFixed(2));
                    $(".amount").each(function(index) {
                        var amount = parseFloat($(this).val()) || 0;
                        var extra = amount - averageAmount;
                        // Show only positive values in extra field
                        if (extra > 0) {
                            $(".extra").eq(index).val(extra.toFixed(2));
                        } else {
                            $(".extra").eq(index).val('');
                        }
                    });
                }

                // Function to update row numbers
                function updateRowNumbers() {
                    $(".row_number").each(function(index) {
                        $(this).val(index + 1);
                    });
                }

                // Function to calculate total amount
                function calculateTotalAmount() {
                    var totalAmount = 0;
                    $(".amount").each(function() {
                        totalAmount += parseFloat($(this).val()) || 0;
                    });
                    $("#total_amount").val(totalAmount.toFixed(2));
                }

                // Function to calculate the total sum of due
                function calculateTotalDue() {
                    var totalDue = 0;
                    $(".due").each(function(index) {
                        totalDue += parseFloat($(this).val()) || 0;
                    });
                    return totalDue.toFixed(2);
                }

                // Function to update the total sum of due
                function updateTotalDue() {
                    var totalDue = calculateTotalDue();
                    $("#total_due").val(totalDue);
                }

                // Function to calculate the total sum of extra
                function calculateTotalExtra() {
                    var totalExtra = 0;
                    $(".extra").each(function(index) {
                        totalExtra += parseFloat($(this).val()) || 0;
                    });
                    return totalExtra.toFixed(2);
                }

                // Function to update the total sum of extra
                function updateTotalExtra() {
                    var totalExtra = calculateTotalExtra();
                    $("#total_extra").val(totalExtra);
                }

                // Initial calculation
                calculateDue();
                calculateExtra();
                updateRowNumbers();
                calculateTotalAmount();
                updateTotalDue();
                updateTotalExtra();

                // Add button click event
                $(add_button).click(function(e){
                    e.preventDefault();
                    var max_fields = 10; // Change the maximum number of fields if needed
                    if($(".name").length < max_fields){
                        $(wrapper).append('<div class="col-md-6">\n' +
                            '                        <div class="mb-3 d-flex align-items-center">\n' +
                            '                            <input type="text" class="form-control row_number" name="row_number[]" style="width: 40px" readonly placeholder="Row Number"/>\n' +
                            '                            <input type="text" class="form-control name" name="name[]" placeholder="Name" style="margin-left: 5px" />\n' +
                            '                            <input type="number" class="form-control amount" name="amount[]" placeholder="Amount" style="margin-left: 5px" />\n' +
                            '                            <input type="text" class="form-control due" disabled name="due[]" readonly placeholder="Due" style="margin-left: 5px" />\n' +
                            '                            <input type="text" class="form-control extra" disabled name="extra[]" placeholder="Extra" style="margin-left: 5px" />\n' +
                            '                            <a href="#" class="remove_field btn btn-danger btn-sm" style="margin-left: 5px" ><i data-feather="x"></i></a></div>'); // Add input field
                        calculateDue();
                        calculateExtra();
                        updateRowNumbers();
                        calculateTotalAmount();
                        updateTotalDue();
                        updateTotalExtra();
                    }
                });

                // Remove button click event
                $(wrapper).on("click",".remove_field", function(e){
                    e.preventDefault();
                    $(this).parent('div').remove(); // Remove the input field
                    calculateDue();
                    calculateExtra();
                    updateRowNumbers();
                    calculateTotalAmount();
                    updateTotalDue();
                    updateTotalExtra();
                });

                // Event listener for changes in amount and due fields
                $(wrapper).on("input", ".amount, .due", function() {
                    calculateDue();
                    calculateExtra();
                    calculateTotalAmount();
                    updateTotalDue();
                    updateTotalExtra();
                });

                // Event listener for changes in main amount field
                $("#main_amount").on("input", function() {
                    mainAmount = parseInt($(this).val());
                    calculateDue();
                    calculateExtra();
                    calculateTotalAmount();
                    updateTotalDue();
                    updateTotalExtra();
                });

                // Ajax submission
                $('#myForm').submit(function(e){
                    e.preventDefault(); // Prevent form submission
                    // Perform Ajax call to submit form data
                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: $(this).serialize(),
                        success: function(response) {
                            // Handle success response
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                        }
                    });
                });
            });
    </script>


</div>

@endsection