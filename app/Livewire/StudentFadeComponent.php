<?php

namespace App\Livewire;

use App\Livewire\Forms\FormStep12;
use Livewire\Component;


class StudentFadeComponent extends Component
{
    public $showFade = false;

    public $id;

    public $name;
    public $selectedFriendsIds;

    protected $listeners = [
        'set-toggle-view-student-fade' => 'disableShowFade',
        'set-toggle-remove-student' => 'removeStudent',
        'set-refresh' => '$refresh',
        'set-show-fade-true' => 'setShowFadeTrue',
    ];

    public function setShowFadeFalse()
    {
        $this->showFade = false;
    }

    public function setShowFadeTrue($id)
    {
        if($id === $this->id){
            dump('hier showfade?' . $this->id);
            $this->showFade = true;
        }
    }

    public function setStudent($id): void
    {
        $this->showFade = true;
        $this->dispatch('set-selected-student-id-comp', $id, $this->name)->component(FormStep12::class);
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
//        dump('render fade componnetn  = ' . $this->showFade);

       return view('livewire.student-fade-component');
    }
}
