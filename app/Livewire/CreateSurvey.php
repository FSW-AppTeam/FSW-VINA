<?php

namespace App\Livewire;

use Livewire\Component;

class CreateSurvey extends Component
{
    public $update;

    public function mount()
    {
        session()->flash('message', 'Survey mounted -- ');
    }

    public function render()
    {
        return view('livewire.create-survey');
    }
}
