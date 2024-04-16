<button wire:click="download"
        type="button"
        class="btn btn-outline-primary">
        <span wire:loading.remove> Download {{$file}}</span>
        <div wire:loading>
            Downloading Report...
        </div>
</button>
