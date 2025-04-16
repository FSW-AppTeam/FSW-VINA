<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog"
     aria-labelledby="viewPost" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Translations Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-decoration-underline">id</h6>
                    <p class="text-muted">{{$translation_id}}</p>
                <hr>

                <h6 class="text-decoration-underline">Slug</h6>
                    <p class="text-muted">{{$slug}}</p>
                <hr>
                <h6 class="text-decoration-underline">en</h6>
                    <p class="text-muted">{{$en}}</p>
                <hr>

                <h6 class="text-decoration-underline">nl</h6>
                    <p class="text-muted">{{$nl}}</p>
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
