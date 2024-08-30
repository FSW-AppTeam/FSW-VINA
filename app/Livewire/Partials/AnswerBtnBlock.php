<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class AnswerBtnBlock extends Component
{
    public int $id;

    public string $value;

    public $disabledBtn = false;

    public $showBtn = true;

    public int $current;

    public $answerSelected = [];

    protected $listeners = [
        'set-answer-button-block' => 'setAnswerOption',
        'set-show-btn-false' => 'setShowBtnFalse',
        'set-show-btn-true' => 'setShowBtnTrue',
        'refreshAnswerBtnBlock' => '$refresh',
    ];

    public function render()
    {
        if (is_array($this->answerSelected) && in_array($this->id, $this->answerSelected ?? [])) {
            $this->showBtn = ! $this->showBtn;
        }
        if (! is_array($this->answerSelected) && $this->id == $this->answerSelected) {
            $this->showBtn = ! $this->showBtn;
        }

        return view('livewire.partials.answer-btn-block');
    }

    public function setAnswerOption(int $id): void
    {
        if ($this->id === $id) {
            $this->dispatch('set-answer-button-square', $this->id, $this->value);
        }
    }

    public function setShowBtnFalse(int $id)
    {
        if ($this->id === $id) {
            $this->showBtn = false;
        }
    }

    public function setShowBtnTrue(int $id): void
    {
        if ($this->id === $id) {
            $this->showBtn = true;
        }
    }

    public function setDisabledBtnFalse()
    {
        $this->disabledBtn = false;
    }

    public function setDisabledBtnTrue(): void
    {
        $this->disabledBtn = true;
    }

    public function mount() {}
}
