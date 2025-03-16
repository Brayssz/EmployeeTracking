@extends('layouts.app-layout')

@section('content')
    <div class="container mt-4 ">
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <h2>User Management</h2>
                <p class="text-muted">| Manage your users records</p>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn text-white add-user" data-mdb-ripple-init style="background-color: #55acee;" href="#!"
                    role="button" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                    <i class="fab fa-plus me-2"></i>
                    Add User
                </a>
            </div>
        </div>

        <form action="{{ route('users') }}" method="GET" class="d-flex col-6 mb-3 gap-2">
            <input type="search" class="form-control" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" name="search" />
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

        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($employees->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No employees found</td>
                    </tr>
                @else
                    @foreach ($employees as $employee)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex justify-content-center align-items-center"
                                        style="width: 45px; height: 45px; background-color: #007bff; font-weight: bold;">
                                        {{ strtoupper(substr($employee->name, 0, 2)) }}
                                    </div>
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">{{ $employee->name }}</p>
                                        <p class="text-muted mb-0">{{ $employee->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">{{ $employee->position }}</p>
                                <p class="text-muted mb-0">{{ $employee->department?->name ?? 'No Department'  }}</p>
                            </td>
                            <td>
                                <span
                                    class="badge badge-{{ $employee->status == 'active' ? 'success' : 'danger' }} rounded-pill d-inline">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-link btn-sm btn-rounded edit-user"
                                    data-userid="{{ $employee->id }}">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $employees->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
    @livewire('user-management')
@endsection
