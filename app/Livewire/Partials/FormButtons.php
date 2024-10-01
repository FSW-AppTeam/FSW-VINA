<?php

namespace App\Livewire\Partials;

use App\Livewire\Forms\StepController;
use Livewire\Component;

class FormButtons extends Component
{
    public $stepId;

    public $jsonQuestion;

    public $loading = true;

    protected $listeners = [
        'refresh-from-buttons' => '$refresh',
        'set-loading-false' => 'loadingFalse',
        'set-loading-true' => 'loadingTrue',
        'set-refresh-form' => '$refresh',
    ];

    public function loadingTrue()
    {
        $this->loading = true;
    }

    public function loadingFalse()
    {
        $this->loading = false;
    }

    public function clickBack()
    {
        $this->dispatch('top-of-page');
        $this->loadingTrue();
        $this->dispatch('back')->component(StepController::class);
    }

    public function clickNext()
    {
        $this->dispatch('top-of-page');
        $this->loadingTrue();
        $this->dispatch('next')->component(StepController::class);
    }

    public function render()
    {
        $this->dispatch('top-of-page');
        return view('livewire.partials.form-buttons');
    }
}
