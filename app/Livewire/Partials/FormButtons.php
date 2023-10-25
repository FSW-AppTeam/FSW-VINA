<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class FormButtons extends Component
{
    public $stepId;

    public function render()
    {
        return view('livewire.partials.form-buttons');
    }
}
