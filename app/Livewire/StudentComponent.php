<?php

namespace App\Livewire;

use Livewire\Component;



class StudentComponent extends Component
{
    public $showDiv = true;

    public $id;

    public $name;

    public function setStudent($id): void
    {
      $this->showDiv = false;
      $this->dispatch('set-selected-student-id', $id, $this->name);
    }

    public function render()
    {
        return view('livewire.student-component');
    }
}
