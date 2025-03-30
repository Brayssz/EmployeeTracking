@extends('layouts.app-layout')

@section('content')
    <div class="container mt-4">
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <h2>Travel Participants</h2>
                <p class="text-muted">| Manage participants for travel records</p>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn text-white add-participant" data-mdb-ripple-init style="background-color: #55acee;"
                    href="#!" role="button" data-mdb-toggle="modal" data-mdb-target="#addParticipantModal">
                    <i class="fab fa-plus me-2"></i>
                    Add Participant
                </a>
            </div>
        </div>

        <form action="{{ route('travel-users') }}" method="GET" class="d-flex col-6 mb-3 gap-2">
            <input type="search" class="form-control" placeholder="Search by remarks, status, or user name"
                aria-label="Search" aria-describedby="search-addon" name="search" value="{{ request('search') }}" />
            <select class="form-control" name="travel_id">
                <option value="">Filter by Travel</option>
                @foreach ($travels as $travel)
                    <option value="{{ $travel->travel_id }}" {{ request('travel_id') == $travel->travel_id ? 'selected' : '' }}>
                        {{ $travel->purpose }}
                    </option>
                @endforeach
            </select>
            <select class="form-control" name="department_id">
                <option value="">Filter by Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->department_id }}"
                        {{ request('department_id') == $department->department_id ? 'selected' : '' }}>
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
                    <th>Travel Purpose</th>
                    <th>Participant Name</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($travelUsers->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No participants found</td>
                    </tr>
                @else
                    @foreach ($travelUsers as $travelUser)
                        <tr>
                            <td>
                                <p class="fw-bold mb-1">{{ $travelUser->travel->purpose }}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">{{ $travelUser->user->name }}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">{{ $travelUser->user->department->name }}</p>
                            </td>
                            </td>
                            <td>
                                <p class="text-muted mb-1">{{ $travelUser->status }}</p>
                            </td>
                            <td>
                                <button type="button" class="btn btn-link btn-sm btn-rounded edit-participant"
                                    data-traveluserid="{{ $travelUser->id }}">
                                    Edit
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
    @livewire('travel-users-management')
@endsection
