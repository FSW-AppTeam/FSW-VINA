<?php

namespace App\Livewire\Partials;

use App\Livewire\Forms\FormStep15;
use Livewire\Component;

class AnswerBtnBlock extends Component
{
    public int $id;

    public string $value;

    public $showBtn = true;

    public int $current;
    public $answerSelected = [];

    protected $listeners = [
        'set-answer-button-block' => 'setAnswer',
        'set-show-btn-false'  => 'setShowBtnFalse'
    ];

    public function render()
    {
//        if(in_array($this->id, $this->answerSelected)){
//            $this->showBtn = !$this->showBtn;
//        }

        return view('livewire.partials.answer-btn-block');
    }

    public function boot()
    {
//        dump(" boot answeBtnBlock called -- ");
    }

    public function updated()
    {
          dump("updated here");
    }

    public function setAnswer(int $id): void
    {
        if($this->id === $id){
            $this->dispatch('set-answer-button-square',  $this->id, $this->value);
        }
    }

    public function setShowBtnFalse(int $id)
    {
//        dump("setShowBtnFalse this->id " . $this->id . " id " . $id);
//        dump($this->answerSelected);
//        if($this->id === $id) {
//            $this->showBtn = false;
//        }
    }

    public function mount()
    {
//        dump("mount this->id " . $this->id . " id " );
//        dump($this->answerSelected);

//        if(in_array($this->id, $this->answerSelected)){
//            $this->showBtn = !$this->showBtn;
//        }
    }

    public function activateBtn(int $id): void
    {

//        dump("activateBtn - activateBtn ----- ");


        if ($this->id === $id) {
            $this->showBtn = true;
        }
    }

}
