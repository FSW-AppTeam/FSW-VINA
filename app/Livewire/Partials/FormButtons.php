<?php

namespace App\Livewire\Partials;

use App\Livewire\Forms\StepController;
use Livewire\Component;

class FormButtons extends Component
{
    public $stepId;

    public $jsonQuestion;

    public $nextEnabled;

    public $backEnabled;

    protected $listeners = [
        'refresh-from-buttons' => '$refresh',
        'set-enable-next' => 'enableNext',
        'set-disable-next' => 'disableNext',
        'set-enable-all' => 'enableAll',
        'set-refresh-form' => '$refresh',
    ];

    public function enableNext()
    {
        $this->nextEnabled = true;
    }

    public function disableNext()
    {
        $this->nextEnabled = false;
    }

    public function enableAll()
    {
        $this->nextEnabled = true;
        $this->backEnabled = true;
    }
    public function disableAll()
    {
        $this->nextEnabled = false;
        $this->backEnabled = false;
    }

    public function clickBack()
    {
        $this->dispatch('top-of-page');
        $this->disableAll();
        $this->dispatch('back')->component(StepController::class);
    }

    public function clickNext()
    {
        $this->dispatch('top-of-page');
        $this->disableAll();
        $this->dispatch('next')->component(StepController::class);
    }

    public function render()
    {
        $this->dispatch('top-of-page');
        return view('livewire.partials.form-buttons');
    }
}
