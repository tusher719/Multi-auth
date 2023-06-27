@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('all.permission') }}">All Permission</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Permission</li>
        </ol>
    </nav>



    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add Permission</h6>

                    <form id="myForm" action="{{ route('store.permission') }}" method="POST" class="forms-sample">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label">Permission Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Group Name</label>
                            <select name="group_name" class="form-select">
                                <option selected="" disabled="">Select Group</option>
                                <option value="type">Property Type</option>
                                <option value="state">State</option>
                                <option value="amenities">Amenities</option>
                                <option value="property">Property</option>
                                <option value="history">Package History</option>
                                <option value="message">Property Message</option>
                                <option value="testimonials">Testimonials</option>
                                <option value="category">Blog Category</option>
                                <option value="post">Blog Post</option>
                                <option value="setting">Site Setting</option>
                                <option value="role">Role & Permission</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>

                    </form>

                </div>
            </div>
        </div>
    </div>



</div>

@endsection
