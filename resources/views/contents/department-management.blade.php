@extends('layouts.app-layout')

@section('content')
    <div class="container mt-4 ">
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <h2>Department Management</h2>
                <p class="text-muted">| Manage your department records</p>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn text-white add-department" data-mdb-ripple-init style="background-color: #55acee;" href="#!"
                    role="button" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                    <i class="fab fa-plus me-2"></i>
                    Add Department
                </a>
            </div>
        </div>

        <form action="{{ route('departments') }}" method="GET" class="d-flex col-6 mb-3 gap-2">
            <input type="search" class="form-control" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" name="search" value="{{ request('search') }}" />
            <select class="form-select py-1" aria-label="Filter by status" name="status">
                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Filter by status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
            </button>
        </form>

        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($departments->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No departments found</td>
                    </tr>
                @else
                    @foreach ($departments as $department)
                        <tr>
                            <td>
                                <p class="fw-bold mb-1">{{ $department->name }}</p>
                            </td>
                            <td>
                                <span
                                    class="badge badge-{{ $department->status == 'active' ? 'success' : 'danger' }} rounded-pill d-inline">
                                    {{ ucfirst($department->status) }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-link btn-sm btn-rounded edit-department"
                                    data-departmentid="{{ $department->department_id }}">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $departments->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
    @livewire('department-management')
@endsection
