<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

    <div class="card-footer">
        @if($stepId != 1)
            <input class="btn btn-secondary float-start mb-2" wire:click="$dispatchTo('forms.step-controller', 'set-step-id-down')" type="button" value="<-" name="back-btn"/>
        @endif
        <button class="btn btn-secondary float-end mb-2">-></button>
    </div>

    {{--            <div wire:loading>--}}
    {{--                <svg>...</svg> <!-- SVG loading spinner -->--}}
    {{--            </div>--}}
</div>
