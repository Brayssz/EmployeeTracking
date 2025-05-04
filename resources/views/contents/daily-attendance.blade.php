@extends('layouts.app-layout')

@section('content')
    <div class="container mt-4">
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <h2>Daily Attendance</h2>
                <p class="text-muted">| Monitor daily attendance of each employee</p>
            </div>
        </div>

        <form action="{{ route('daily-attendance') }}" method="GET" class="d-flex col-12 mb-3 gap-2">
            <input type="search" class="form-control col-3" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" name="search" value="{{ request('search') }}" />
            <input type="date" class="form-control col-3" name="date"
                value="{{ request('date', now()->toDateString()) }}" />
            <select class="form-control col-3" name="department">
                <option value="">All Departments</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->department_id }}"
                        {{ request('department') == $department->department_id ? 'selected' : '' }}>
                        {{ $department->name }}
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
                    <th>Date</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($dailyAttendances->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No attendance records found</td>
                    </tr>
                @else
                    @foreach ($dailyAttendances as $attendance)
                        <tr>
                            <td>
                                <p class="fw-bold mb-1">{{ $attendance->user->name }}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('F j, Y') }}
                                </p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">
                                    {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'Not recorded' }}
                                </p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">
                                    {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'Not recorded' }}
                                </p>
                            </td>
                            <td>
                                @if ($attendance->status === 'present')
                                    <span class="badge bg-success text-white">Present</span>
                                @elseif ($attendance->status === 'absent')
                                    <span class="badge bg-danger text-white">Absent</span>
                                @elseif ($attendance->status === 'ontravel')
                                    <span class="badge bg-info text-white">On Travel</span>
                                @elseif ($attendance->status === 'onleave')
                                    <span class="badge bg-warning text-white">On Leave</span>
                                @else
                                    <span class="badge bg-secondary text-white">Unknown</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $dailyAttendances->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection
