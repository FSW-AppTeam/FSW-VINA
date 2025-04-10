<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="createModal" tabindex="-1" role="dialog"
     aria-labelledby="createTranslation" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Translation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="store">
                    <div class="form-group">
                        <label for="slug">Slug:</label>
                        <input wire:model="slug" type="text" class="form-control" name="slug"
                               id="slug"
                               title="Slug" placeholder="Enter slug..." autofocus>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click.prevent="clearFields" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="store" type="submit" class="btn btn-outline-primary">Submit
                </button>
            </div>
        </div>
    </div>
</div>
