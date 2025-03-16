@extends('layouts.app-layout')

@section('content')
    <div class="container mt-4 ">
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <h2>Employer Tracking</h2>
                <p class="text-muted">| Track Employee Travel Locations</p>
            </div>

        </div>

        <form action="{{ route('tracking') }}" method="GET" class="d-flex col-6 mb-3 gap-2">
            <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon"
                name="search" value="{{ request('search') }}" />
            <select class="form-select py-1" aria-label="Filter by department" name="department_id">
                <option selected value="">Filter by department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->department_id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
            </button>
        </form>

        <div class="rounded-3" id="view_map" style="height: 700px;"></div>
    </div>
    @livewire('tracking')
@endsection
