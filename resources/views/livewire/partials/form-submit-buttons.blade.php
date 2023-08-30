<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

{{--    @click="$dispatch('setStepIdUp')"--}}

    <div class="card-footer">
        @if($stepId != 1)
            <input class="btn btn-secondary float-start" wire:click="$parent.setStepIdDown()" type="button" value="<-" name="back-btn"/>
        @endif
        <button class="btn btn-secondary float-end" >-></button>
    </div>
</div>
