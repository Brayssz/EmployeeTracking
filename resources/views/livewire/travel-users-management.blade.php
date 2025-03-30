<div>
    <div class="modal fade" id="travelUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($travel_id && $user_id)
                        <h5 class="modal-title" id="exampleModalLabel">Edit Travel Participant</h5>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">Add Travel Participant</h5>
                    @endif
                    <button type="button" class="btn-close" data-mdb-ripple-init data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="travel_id" class="col-form-label">Travel:</label>
                                <select class="form-control" id="travel_id" wire:model="travel_id">
                                    <option value="">Select Travel</option>
                                    @foreach ($travels as $travel)
                                        <option value="{{ $travel->travel_id }}">{{ $travel->purpose }}</option>
                                    @endforeach
                                </select>
                                @error('travel_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label for="user_id" class="col-form-label">User:</label>
                                <select class="form-control" id="user_id" wire:model="user_id">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
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

                $('.add-participant').on('click', function () {
                    $('#travelUserModal').modal('show');
                });
                $('.edit-participant').on('click', function () {
                    var id = $(this).data('traveluserid');
                    console.log(id);

                    @this.set('travelUser_id', id);

                    @this.call('edit', id).then(() => {
                        $('#travelUserModal').modal('show');
                    });
                });
                $('#travelUserModal').on('hidden.bs.modal', function () {
                    @this.call('resetForm');
                });
            });
        </script>
    @endpush
</div>
