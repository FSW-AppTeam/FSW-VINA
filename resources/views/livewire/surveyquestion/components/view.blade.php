<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog"
     aria-labelledby="viewPost" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SurveyQuestion Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                    <h6 class="text-decoration-underline">Surveyquestion_id</h6>
                        <p class="text-muted">{{$surveyquestion_id}}</p>
                    <hr>

                    <h6 class="text-decoration-underline">Order</h6>
                        <p class="text-muted">{{$order}}</p>
                    <hr>
                    <h6 class="text-decoration-underline">Question_type</h6>
                        <p class="text-muted">{{$question_type}}</p>
                    <hr>

                    <h6 class="text-decoration-underline">Question_title</h6>
                        <p class="text-muted">{{$question_title}}</p>
                    <hr>

                    <h6 class="text-decoration-underline">Question_content</h6>
                        <p class="text-muted">{{$question_content}}</p>
                    <hr>

                    <h6 class="text-decoration-underline">Question_answer_options</h6>
                        <p class="text-muted">{{json_encode($question_answer_options)}}</p>
                    <hr>

                    <h6 class="text-decoration-underline">Question_options</h6>
                        <p class="text-muted">{{json_encode($question_options)}}</p>
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
