<div wire:loading
    wire:target="clickNext">
    <div id="overlay">
        <div id="overlaytext">
            <span class="spinner-border spinner-border-sm wait" role="status" aria-hidden="true"></span>
        </div>
    </div>
</div>
<div @if(empty($loading) || !$loading) style="display: none" @endif>
    <div id="overlay">
        <div id="overlaytext">
            <span class="spinner-border spinner-border-sm wait" role="status" aria-hidden="true"></span>
        </div>
    </div>
</div>