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
        <div class="col-md-7">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header"> 
                        <h5 class="modal-title" id="exampleModalLabel">Wallet</h5>
                    </div>
                    <form action="{{ route('update.wallet',$info->id) }}" method="POST">
                        @csrf
                        <input type="text" name="id" value="{{ $info->id }}">
                        <div class="modal-body">

                            <div class="row p-3">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <input type="text" name="amount" class="form-control form-control-lg" value="{{ $info->amount }}" placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Select One</label>
                                    <select name="record" class="form-select form-select-lg">
                                        <option selected disabled>Select one</option>
                                        <option value="income" {{ $info->record == 'income' ? 'selected' : '' }}>Income</option>
                                        <option value="expense" {{ $info->record == 'expense' ? 'selected' : '' }}>Expense</option>
                                        <option value="saving" {{ $info->record == 'saving' ? 'selected' : '' }}>Saving</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg" value="{{ $info->name }}" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Payment type</label>
                                    <select name="payment_type" class="form-select form-select-lg">
                                        <option selected disabled>Payment type</option>
                                        <option {{ $info->payment_type == 'Cash' ? 'selected' : '' }}>Cash</option>
                                        <option {{ $info->payment_type == 'bKash' ? 'selected' : '' }}>bKash</option>
                                        <option {{ $info->payment_type == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                        <option {{ $info->payment_type == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="rdate" value="{{ $info->rdate }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Time</label>
                                    <input type="time" name="rtime" value="{{ $info->rtime }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Note</label>
                                <textarea class="form-control" name="note" rows="4" placeholder="Note">{{ $info->note }}</textarea>
                            </div>
                            <div class="form-check mb-4 my-3">
                                <input type="checkbox" class="form-check-input" name="status" id="checkChecked" value="active" {{ $info->status == 'active' ? 'checked': '' }}>
                                <label class="form-check-label" for="checkChecked">
                                    Active
                                </label>
                            </div>
                        </div>

                    </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection