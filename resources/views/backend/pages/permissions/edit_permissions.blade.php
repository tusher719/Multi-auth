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
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add Permission</h6>

                    <form action="{{ route('update.permission') }}" method="POST" class="forms-sample">
                        @csrf

                        <input type="hidden" name="id" value="{{ $permission->id }}">

                        <div class="form-group mb-3">
                            <label class="form-label">Permission Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $permission->name }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Group Name</label>
                            <select name="group_name" class="form-select">
                                <option selected="" disabled="">Select Group</option>
                                <option value="type" {{ $permission->group_name == 'type' ? 'selected' : '' }}>Property Type</option>
                                <option value="state" {{ $permission->group_name == 'state' ? 'selected' : '' }}>State</option>
                                <option value="amenities" {{ $permission->group_name == 'amenities' ? 'selected' : '' }}>Amenities</option>
                                <option value="property" {{ $permission->group_name == 'property' ? 'selected' : '' }}>Property</option>
                                <option value="history" {{ $permission->group_name == 'history' ? 'selected' : '' }}>Package History</option>
                                <option value="message" {{ $permission->group_name == 'message' ? 'selected' : '' }}>Property Message</option>
                                <option value="testimonials" {{ $permission->group_name == 'testimonials' ? 'selected' : '' }}>Testimonials</option>
                                <option value="category" {{ $permission->group_name == 'category' ? 'selected' : '' }}>Blog Category</option>
                                <option value="post" {{ $permission->group_name == 'post' ? 'selected' : '' }}>Blog Post</option>
                                <option value="setting" {{ $permission->group_name == 'setting' ? 'selected' : '' }}>Site Setting</option>
                                <option value="role" {{ $permission->group_name == 'role' ? 'selected' : '' }}>Role & Permission</option>
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
