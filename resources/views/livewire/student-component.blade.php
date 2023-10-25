<div>
    @if ($showDiv)
        <button type="button"
                wire:click="setStudent({{$id}})"
                class="btn-circle btn-xl">
            {{$name}}
        </button>
    @endif
</div>
