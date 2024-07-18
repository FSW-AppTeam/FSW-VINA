<div class="btn p-1
    @if($showShrink)selected-btn-shrink @endif"
    @if($nextId == $id)id="next-student"@endif>
    @if ($showFade)
        <button type="button"
                wire:click="removeStudent({{$id}})"
                class="p-2 btn-circle btn-xl"
                style="opacity: 0.4"
                @if(!$buttonEnabled) disabled @endif>
            {{$name}}
        </button>
    @else
        <button type="button"
                wire:click="setStudent({{$id}})"
                class="p-2 btn-circle btn-xl"
                style="opacity: 1"
                @if(!$buttonEnabled) disabled @endif>
            {{$name}}
        </button>
    @endif
</div>
