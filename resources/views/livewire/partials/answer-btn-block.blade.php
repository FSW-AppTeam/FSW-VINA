<div>
    <button
        type="button"
        class="btn btn-outline-secondary press-buttons-inline @if(!$showBtn) invisible @endif"
        id="{{ $id }}"
{{--        wire:click="setAnswer({{$id}})"--}}
        wire:click="$dispatch('set-block-btn-animation');"
    >{{ $value }}</button>
</div>
