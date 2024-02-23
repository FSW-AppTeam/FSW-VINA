<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="deleteModal" tabindex="-1" role="dialog"
     aria-labelledby="createSurvey" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Survey Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete selected Survey?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" wire:click="delete"
                        class="btn btn-outline-danger" data-bs-dismiss="modal">Delete
                </button>
            </div>
        </div>
    </div>
</div>
