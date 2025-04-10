<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog"
     aria-labelledby="viewPost" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Settings Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-decoration-underline">id</h6>
                    <p class="text-muted">{{$setting_id}}</p>
                <hr>

                <h6 class="text-decoration-underline">Key</h6>
                    <p class="text-muted">{{$key}}</p>
                <hr>
                <h6 class="text-decoration-underline">Value</h6>
                    <p class="text-muted">{{$value}}</p>
                <hr>

                <h6 class="text-decoration-underline">Created_at</h6>
                    <p class="text-muted">{{$created_at}}</p>
                <hr>

                <h6 class="text-decoration-underline">Updated_at</h6>
                    <p class="text-muted">{{$updated_at}}</p>
                <hr>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
