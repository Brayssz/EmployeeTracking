<div>
    <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($department_id)
                        <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
                    @endif
                    <button type="button" class="btn-close" data-mdb-ripple-init data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" wire:model="name" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label for="status" class="col-form-label">Status:</label>
                                <select class="form-select py-1" id="status" aria-label="Select Status" wire:model="status">
                                    <option selected value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
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

                $('.add-department').on('click', function () {
                    $('#departmentModal').modal('show');
                });
                $('.edit-department').on('click', function () {
                    var id = $(this).data('departmentid');
                    console.log(id);

                    @this.set('department_id', id);

                    @this.call('edit', id).then(() => {
                        $('#departmentModal').modal('show');
                    });

                });
                $('#departmentModal').on('hidden.bs.modal', function () {
                    @this.call('resetForm');
                });
            });

        </script>
        
    @endpush
</div>
