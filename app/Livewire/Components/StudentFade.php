<?php

namespace App\Livewire\Components;

use Livewire\Component;

class StudentFade extends Component
{
    public $showFade = false;

    public $showShrink = false;

    public $nextId = 0;

    public $id;

    public $name;

    public $selectedStudents = [];

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
        if ($id === $this->id) {
            $this->showFade = true;
        }
    }

    public function setShowShrinkTrue(): void
    {
        if ($this->nextId === $this->id) {
            $this->showShrink = true;
        }
    }

    public function setStudent($id): void
    {
        $this->showFade = true;
        $this->dispatch('set-selected-student-id', $id, $this->name);
    }

    public function removeStudent($id): void
    {
        $this->showFade = false;
        $this->dispatch('remove-selected-student-id', $id);
    }

    public function disableShowFade($id): void
    {
        if ($id === $this->id) {
            $this->showFade = false;
        }
    }

    public function mount()
    {

    }

    public function render()
    {
        if (array_search($this->id, array_column($this->selectedStudents, 'id')) !== false) {
            $this->showFade = true;
        }
        return view('livewire.components.student-fade');
    }
}
