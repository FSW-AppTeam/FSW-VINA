<?php

namespace App\Livewire;

use Livewire\Component;

class StudentFadeComponent extends Component
{
    public $showFade = false;
    public $showShrink = false;
    public $nextId = 0;

    public $id;

    public $name;
    public $selectedFriendsIds;

    protected $listeners = [
        'set-disable-student-fade-btn' => 'disableShowFade',
        'set-toggle-remove-student' => 'removeStudent',
        'set-refresh' => '$refresh',
        'set-show-fade-true' => 'setShowFadeTrue',
        'set-show-shrink-true' => 'setShowShrinkTrue',
    ];

    public function setShowFadeFalse(): void
    {
        $this->showFade = false;
    }

    public function setShowFadeTrue($id): void
    {
        if($id === $this->id){
            $this->showFade = true;
        }
    }

    public function setShowShrinkTrue(): void
    {
        if($this->nextId === $this->id) {
            $this->showShrink = true;
        }
    }

    public function setStudent($id): void
    {
        $this->showFade = true;
        $this->dispatch('set-selected-student-id-comp', $id, $this->name);
    }

    public function removeStudent($id): void
    {
        $this->showFade = false;
        $this->dispatch('remove-selected-student-id', $id, $this->name);
    }

    public function disableShowFade($id): void
    {
        if($id === $this->id){
            $this->showFade = false;
        }
    }

    public function mount()
    {
        if(in_array($this->id, $this->selectedFriendsIds)){
            $this->showFade = true;
        }
    }
    public function render()
    {
       return view('livewire.student-fade-component');
    }
}
