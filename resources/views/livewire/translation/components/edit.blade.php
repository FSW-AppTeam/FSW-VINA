<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Translation</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">

                    <div class="form-group">
                        <label for="slug">Slug:</label>
                        <input wire:model="slug" type="text" class="form-control" name="slug"
                               id="slug"
                               title="Slug" placeholder="Enter slug order..." autofocus>
                        @error("slug")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="en">en:</label>
                        <textarea wire:model="en"  id="en" name="en" rows="4" cols="50" class="form-control">
                        </textarea>
                        @error("en")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nl">nl:</label>
                        <textarea wire:model="nl"  id="nl" name="en" rows="4" cols="50" class="form-control">
                        </textarea>
                        @error("nl")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <input wire:model.live="translation_id" type="hidden" name="id">
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
