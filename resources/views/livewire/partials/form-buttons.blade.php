<div class="card-footer">
<div class="mb-2">
        @if($stepId !== 0 && $stepId !== 1)
            <button class="btn btn-secondary float-start "
                    wire:click="$dispatchTo('forms.step-controller', 'set-step-id-down')" type="button" name="back-btn">
                <i class="bi bi-arrow-left"></i></button>
        @endif
        <button class="btn btn-secondary float-end " type="submit"><i class="bi bi-arrow-right"></i></button>
    </div>

    {{--            <div wire:loading>--}}
    {{--                <svg>...</svg> <!-- SVG loading spinner -->--}}
    {{--            </div>--}}
</div>
