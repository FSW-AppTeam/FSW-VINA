<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Setting</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">

                    <div class="form-group">
                        <label for="key">Key:</label>
                        <input wire:model="key" type="text" class="form-control" name="key"
                               id="key"
                               title="Key" placeholder="Enter key order..." autofocus>
                        @error("key")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="value">Value:</label>
                        <input wire:model="value" type="text" class="form-control" name="value"
                               id="value"
                               title="value" placeholder="Enter value..." autofocus>
                        @error("value")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <input wire:model.live="settting_id" type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click.prevent="clearFields" data-bs-dismiss="modal">Close</button>
                <button type="submit" wire:click.prevent="update"
                        class="btn btn-outline-primary" data-bs-dismiss="modal">Update
                </button>
            </div>
        </div>
    </div>
</div>
