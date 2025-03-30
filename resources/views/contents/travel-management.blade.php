@extends('layouts.app-layout')

@section('content')
    <div class="container mt-4 ">
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <h2>Travel Management</h2>
                <p class="text-muted">| Manage your travel records</p>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn text-white add-travel" data-mdb-ripple-init style="background-color: #55acee;" href="#!"
                    role="button" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                    <i class="fab fa-plus me-2"></i>
                    Add Travel
                </a>
            </div>
        </div>

        <form action="{{ route('travels') }}" method="GET" class="d-flex col-6 mb-3 gap-2">
            <input type="search" class="form-control" placeholder="Search by purpose or description" aria-label="Search"
                aria-describedby="search-addon" name="search" value="{{ request('search') }}" />
            <input type="date" class="form-control date-range-picker" placeholder="Filter by date range"
                name="date" value="{{ request('date') }}" />
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
            </button>
        </form>

        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Purpose</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($travels->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No travels found</td>
                    </tr>
                @else
                    @foreach ($travels as $travel)
                        <tr>
                            <td>
                                <p class="fw-bold mb-1">{{ $travel->purpose }}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">{{ $travel->description }}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">{{ $travel->start_date }}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-1">{{ $travel->end_date }}</p>
                            </td>
                            <td>
                                <button type="button" class="btn btn-link btn-sm btn-rounded edit-travel"
                                    data-travelid="{{ $travel->travel_id }}">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $travels->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
    @livewire('travel-management')
@endsection
