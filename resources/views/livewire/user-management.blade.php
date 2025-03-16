<div>
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($user_id)
                        <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">Add user</h5>
                    @endif
                    <button type="button" class="btn-close" data-mdb-ripple-init data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row mb-4">
                            <div class="col-6">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" wire:model="name" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="email" wire:model="email" />
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="position" class="col-form-label">Position:</label>
                                <select class="form-select py-1" id="position" aria-label="Select Position" wire:model="position">
                                    <option selected value="">Select Position</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Employee">Employee</option>
                                </select>
                                @error('position') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="department_id" class="col-form-label">Department:</label>
                                <select class="form-select py-1" id="department_id" aria-label="Filter by department" wire:model="department_id">
                                    <option selected value="">Select department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->department_id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="password" wire:model="password" />
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="password_confirmation" class="col-form-label">Confirm Password:</label>
                                <input type="password" class="form-control" id="password_confirmation" wire:model="password_confirmation" />
                                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @if ($user_id)
                                <div class="col-6">
                                    <label for="status" class="col-form-label">Status:</label>
                                    <select class="form-select py-1" id="status" aria-label="Select Status" wire:model="status">
                                        <option selected value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-mdb-ripple-init
                            data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-mdb-ripple-init>Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {

                $('.add-user').on('click', function () {
                    $('#userModal').modal('show');
                });
                $('.edit-user').on('click', function () {
                    var id = $(this).data('userid');
                    console.log(id);

                    @this.set('user_id', id);

                    @this.call('edit', id).then(() => {
                        $('#userModal').modal('show');
                    });

                });
                $('#userModal').on('hidden.bs.modal', function () {
                    @this.call('resetForm');
                });
            });

        </script>
        
    @endpush
</div>
