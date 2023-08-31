<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormButtons extends Component
{
    public $stepId;

    public function render()
    {
        return view('livewire.forms.form-buttons');
    }
}
