@extends('admin.admin_dashboard')
@section('admin')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">Creative Park</a></li>
            <li class="breadcrumb-item"><a href="{{ route('all.cp.members') }}">All Students</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student Info</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 mt-1 mb-2">
            <a href="{{ route('all.cp.members') }}" class="btn btn-inverse-info">
                <i class="btn-icon-prepend" data-feather="chevron-left"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="student-photo">
                            <img id="showImage" class="rounded" style="height: 80px; width: 80px; object-fit: cover;"
                                src="{{ (!empty($details->photo)) ? url('uploads/students_img/'.$details->photo) : url('uploads/no_image.jpg') }}"
                                alt="profile">
                        </div>
                        <div class="student-info px-4">
                            <h4>{{ $details->name }} ({{ $details->student_id }})</h4>
                            <h5 class="mt-2">Multimedia & Creative Technology</h5>
                            <div class="d-flex mt-1">
                                <div class="contact" style="margin-right: 20px">
                                    <h5>
                                        <i class="fa-solid fa-phone" style="margin-right: 2px"></i>
                                        {{ $details->phone }}
                                    </h5>
                                </div>
                                <div class="contact">
                                    <h5>
                                        <i class="fa-solid fa-envelope" style="margin-right: 2px"></i>
                                        {{ $details->email }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 justify-content-between">
                        <h6 class="card-title">Personal Information</h6>
                        {{-- <div>Added by : {{ $details->user->name }}</div> --}}
                        {{-- <div class="d-flex align-items-center">
                            Account:
                            <div class="px-2">
                                @if($details->status == 'active')
                                <span class="badge border border-success text-success">
                                    <i data-feather="user-check" class="icon-sm" width="24" height="24"></i>
                                    Active
                                </span></td>
                                @elseif($details->status == 'inactive')
                                <span class="badge border border-danger text-danger">
                                    <i data-feather="user-x" class="icon-sm" width="24" height="24"></i>
                                    Banned
                                </span></td>
                                @endif
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <table class="table">
                                <tr>
                                    <td class="studentInfo" width="160px">Student Roll</td>
                                    <td>: {{ $details->student_id }}</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Student Name</td>
                                    <td>: {{ $details->name }}</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Batch</td>
                                    <td>: {{ $details->batch }}</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Class Section</td>
                                    <td>: {{ $details->section }}</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Mobile Number</td>
                                    <td>: {{ $details->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Blood Group</td>
                                    <td>: {{ $details->blood }}</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Email</td>
                                    <td>: {{ $details->email }}</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Date Of Birth</td>
                                    <td>: {{ Carbon\Carbon::parse($details->date)->format('d-M-Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Gender</td>
                                    <td>:
                                        @if($details->gender == 1)
                                        Male
                                        @elseif($details->gender == 2)
                                        Female
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Department Name</td>
                                    <td>: Multimedia and Creative Technology</td>
                                </tr>
                                <tr>
                                    <td class="studentInfo">Active Status</td>
                                    <td>: {{ $details->status }}</td>
                                </tr>
                            </table>




                        </div>
                    </div>




                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Creative Park Panel</h6>

                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Student Name(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($panels as $panel)
                            {{-- Check if there are any students associated with the current panel --}}
                            @php
                            $matchingStudents = $all_students->filter(function($student) use ($panel) {
                            return $student->panel_id == $panel->id;
                            });
                            @endphp

                            @if ($matchingStudents->isNotEmpty())
                            {{-- Display the panel name and student names if there are matching students --}}
                            @foreach ($matchingStudents as $student)
                            <tr>
                                <td>{{ $panel->position }}</td> {{-- Panel position --}}
                                <td>{{ $student->name }}</td> {{-- Student name --}}
                            </tr>
                            @endforeach
                            @else
                            {{-- If no students match this panel, display the panel name with "--" --}}
                            <tr>
                                <td>{{ $panel->position }}</td> {{-- Panel position --}}
                                <td>--</td> {{-- Placeholder for no students --}}
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>






                    {{-- <option value="{{ $item->id }}">{{ $item->position }}</option> --}}
                </div>
            </div>
        </div>
    </div>



</div>

@endsection