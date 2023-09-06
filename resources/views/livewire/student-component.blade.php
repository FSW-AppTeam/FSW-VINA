<div>
    @if ($showDiv)
        <button type="button"
                wire:click="setStudent({{$id}})"
                class="p-3">
            {{$name}}
        </button>
    @endif
</div>
