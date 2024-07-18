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
        'set-enable-back' => 'enableBack',
        'set-disable-back' => 'disableBack',
        'set-enable-all' => 'enableAll',
    ];

    public function enableNext()
    {
        $this->nextEnabled = true;
        $this->dispatch('set-button-enable');
    }

    public function disableNext()
    {
        $this->nextEnabled = false;
        $this->dispatch('set-button-disable');
    }

    public function disableBack()
    {
        $this->nextEnabled = false;
        $this->dispatch('set-button-disable');
    }

    public function enableBack()
    {
        $this->backEnabled = true;
        $this->dispatch('set-button-enable');
    }

    public function enableAll()
    {
        $this->nextEnabled = true;
        $this->backEnabled = true;
        $this->dispatch('set-button-enable');

    }
    public function disableAll()
    {
        $this->nextEnabled = false;
        $this->backEnabled = true;
        $this->dispatch('set-button-disable');
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
