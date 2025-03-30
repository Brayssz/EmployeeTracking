<div>
    <div class="modal fade" id="travelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($travel_id)
                        <h5 class="modal-title" id="exampleModalLabel">Edit Travel</h5>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">Add Travel</h5>
                    @endif
                    <button type="button" class="btn-close" data-mdb-ripple-init data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="purpose" class="col-form-label">Purpose:</label>
                                <input type="text" class="form-control" id="purpose" wire:model="purpose" />
                                @error('purpose') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="description" wire:model="description"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="start_date" class="col-form-label">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" wire:model="start_date" />
                                @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="col-form-label">End Date:</label>
                                <input type="date" class="form-control" id="end_date" wire:model="end_date" />
                                @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
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

                $('.add-travel').on('click', function () {
                    $('#travelModal').modal('show');
                });
                $('.edit-travel').on('click', function () {
                    var id = $(this).data('travelid');
                    console.log(id);

                    @this.set('travel_id', id);

                    @this.call('edit', id).then(() => {
                        $('#travelModal').modal('show');
                    });

                });
                $('#travelModal').on('hidden.bs.modal', function () {
                    @this.call('resetForm');
                });
            });

        </script>
    @endpush
</div>
