<div class="d-flex align-items-center" id="change-order-{{$model->id}}">
    <button class="btn btn-outline-info btn-sm"
        wire:click="moveUp({{$model}})">
        <i class="fas fa-arrow-up"></i>
    </button>
    <button class="btn btn-outline-info btn-sm button-down"
            wire:click="moveDown({{$model}})"
        >
        <i class="fas fa-arrow-down"></i>
    </button>
</div>