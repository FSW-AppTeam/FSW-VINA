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
        <div class="col image-box p-2" style="opacity: 0;">
            <img src="{{ asset('flags/' .$image. '.jpg') }}"
                 style="width: 90%;"
                 type="button">
            <p class="mt-1">{{$country}}</p>
        </div>
    @endif
</div>


