<div class="btn p-1" >
    @if ($showFade)
        <button type="button"
                wire:click="removeStudent({{$id}})"
                class="p-2 btn-circle btn-xl"
                style="opacity: 0.4">
            {{$name}}
        </button>
    @else
        <button type="button"
                wire:click="setStudent({{$id}})"
                class="p-2 btn-circle btn-xl"
                style="opacity: 1">
            {{$name}}
        </button>
    @endif
</div>
