<?php

namespace App\Livewire\Partials;

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
        'set-enable-all' => 'enableAll',
    ];
    public function enableNext()
    {
        $this->nextEnabled = true;
    }
    public function disableNext()
    {
        $this->nextEnabled = false;
    }

    public function enableBack()
    {
        $this->backEnabled = true;
    }

    public function enableAll()
    {
        $this->nextEnabled = true;
        $this->backEnabled = true;
    }

    public function render()
    {
        return view('livewire.partials.form-buttons');
    }

    public function nextStep()
    {
        $this->disableNext();
        $this->dispatch('set-sub-step-id-up');
    }

}
