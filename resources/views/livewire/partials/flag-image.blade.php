<div class="col">
    @if ($showFlag)
        <div class="col image-box p-2">
            <img src="{{ asset('flags/' .$image. '.jpg') }}"
                 style="width: 90%;"
                 type="button"
                 wire:click="setFlag({{$id}})"
                 alt="{{$country}}"
                 id="{{$id}}">
            <p class="mt-1">{{$country}}</p>
        </div>
    @else
        <div class="col p-2"  style="height: 123px; width: 180px;"></div>
    @endif
</div>


