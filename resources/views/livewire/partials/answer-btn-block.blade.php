<div>
    <button
        data-answer-btn
        type="button"
        class="btn btn-outline-secondary press-buttons-inline
        {{$disabledBtn?'disabled':''}}
        {{!$showBtn?'invisible':''}}"
        id="{{ $id }}"
        wire:target="disabledBtn"
        wire:loading.attr="disabled"
        wire:click="$dispatch('block-btn-move-up-animation', {event:event});"
    >{{ $value }}</button>
</div>
