<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">
                        
            <div class="form-group">
                <label for="name">User name:</label>
                <input wire:model="name" type="text" class="form-control" name="name"
                       id="name"
                       title="User name" placeholder="Enter user name..." autofocus>
                @error("name")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="role_id">Role role_id:</label>
                <select  class="form-select" aria-label="Default select example" wire:model.live="role_id" id="role_id">
                    <option value="">-- Select --</option>
                    @foreach( App\Models\Role::all()->pluck("name", "id") as $key=>$option)
                        <option value="{{$key}}" >{{$option}}</option>
                    @endforeach
                </select>
                @error("role_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">User email:</label>
                <input wire:model="email" type="text" class="form-control" name="email"
                       id="email"
                       title="User email" placeholder="Enter user email..." autofocus>
                @error("email")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="solis_id">User solis_id:</label>
                <input wire:model="solis_id" type="text" class="form-control" name="solis_id"
                       id="solis_id"
                       title="User solis_id" placeholder="Enter user solis_id..." autofocus>
                @error("solis_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
                    <input wire:model.live="user_id" type="hidden" name="id">
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
