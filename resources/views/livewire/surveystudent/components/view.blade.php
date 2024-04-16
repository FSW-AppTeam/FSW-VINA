<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog"
     aria-labelledby="viewPost" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SurveyStudent Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                    <h6 class="text-decoration-underline">Surveystudent_id</h6>
                        <p class="text-muted">{{$surveystudent_id}}</p>
                    <hr>
            
                    <h6 class="text-decoration-underline">Name</h6>
                        <p class="text-muted">{{$name}}</p>
                    <hr>
            
                    <h6 class="text-decoration-underline">Finished_at</h6>
                        <p class="text-muted">{{$finished_at}}</p>
                    <hr>
            
                    <h6 class="text-decoration-underline">Exported_at</h6>
                        <p class="text-muted">{{$exported_at}}</p>
                    <hr>
            
                    <h6 class="text-decoration-underline">Survey_id</h6>
                        <p class="text-muted">{{$survey_id}}</p>
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
