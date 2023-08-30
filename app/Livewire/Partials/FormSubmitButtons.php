<?php

namespace App\Livewire\Partials;

use Livewire\Attributes\Locked;
use Livewire\Component;

class FormSubmitButtons extends Component
{
    public $stepId;

    public function render()
    {
        return view('livewire.partials.form-submit-buttons');
    }
}
