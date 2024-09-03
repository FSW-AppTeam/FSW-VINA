<div wire:loading
    wire:target="clickNext">
    <div id="overlay">
        <div id="overlaytext">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Saving...!
        </div>
    </div>
</div>
<div @if(!$loading) style="display: none" @endif>
    <div id="overlay">
        <div id="overlaytext">
            <span class="spinner-border spinner-border-sm wait" role="status" aria-hidden="true"></span>
            Loading next...!
        </div>
    </div>
</div>

<style>
    .wait {cursor: wait;}
</style>