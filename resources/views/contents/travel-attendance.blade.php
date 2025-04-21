@extends('layouts.app-layout')

@section('content')
    <div class="container mt-4 ">
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <h2>Travel Attendance</h2>
                <p class="text-muted">| Monitor travel attendance of each employee</p>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn text-white add-user" style="background-color: #55acee;" href="#!"
                    role="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fas fa-file-alt me-2"></i>
                    Generate Attendance
                </a>
            </div>
        </div>

        <form action="{{ route('travel-attendance') }}" method="GET" class="d-flex col-6 mb-3 gap-2">
            <input type="search" class="form-control" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" name="search" value="{{ request('search') }}" />
            <select class="form-select py-1" aria-label="Filter by department" name="department_id">
                <option value="" {{ request('department_id') == '' ? 'selected' : '' }}>Filter by department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->department_id }}"
                        {{ request('department_id') == $department->department_id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            <select class="form-select py-1" aria-label="Filter by travel" name="travel_id">
                <option value="" {{ request('travel_id') == '' ? 'selected' : '' }}>Filter by travel</option>
                @foreach ($travels as $travel)
                    <option value="{{ $travel->travel_id }}"
                        {{ request('travel_id') == $travel->travel_id ? 'selected' : '' }}>
                        {{ $travel->purpose }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
            </button>
        </form>

        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Travel Purpose</th>
                    <th>Date Recorded</th>
                    <th>Time Recorded</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($travelUsers->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No employees found</td>
                    </tr>
                @else
                    @foreach ($travelUsers as $travelUser)
                        <tr>
                            <td>
                                <p class="fw-bold mb-1">{{ $travelUser->user->name }}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">{{ $travelUser->user->department->name }}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">{{ $travelUser->travel->purpose }}</p>
                            </td>

                            </td>
                            <td>
                                <p class="text-muted mb-1">
                                    {{ $travelUser->date_recorded ? \Carbon\Carbon::parse($travelUser->date_recorded)->format('F j, Y') : 'No attendance recorded' }}
                                </p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">
                                    {{ $travelUser->time_recorded ? \Carbon\Carbon::parse($travelUser->time_recorded)->format('h:i A') : 'No attendance recorded' }}
                            </td>
                            <td>
                                @if ($travelUser->status === 'pending')
                                    <span class="badge bg-warning text-white">No Attendance</span>
                                @elseif ($travelUser->status === 'present')
                                    <span class="badge bg-success text-white">Present</span>
                                @else
                                    <span class="badge bg-secondary text-white">Unknown</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-link btn-sm btn-rounded view-location"
                                    data-traveluserid="{{ $travelUser->id }}" data-status="{{ $travelUser->status }}">
                                    View Attendance Location
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $travelUsers->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <div class="modal fade" id="show-location-modal" tabindex="-1" role="dialog" aria-labelledby="routeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Attendance Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="routeForm">
                        <div id="view_map" style="height: 700px;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @livewire('attendance-location')
@endsection
