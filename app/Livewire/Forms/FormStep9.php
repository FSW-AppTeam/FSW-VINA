<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep9 extends Component
{
    public PostForm $form;

    public int|null $religion = null;
    public string|null $otherReligion;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $savedAnswers;

    protected $messages = [];

    public $firstRequired = true;

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['religion.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'religion' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['religion.required']);
                    }
                }
            ],
        ];
    }

    public function updatedReligion()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-enable-next');
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        if($this->religion != 6){
            $this->otherReligion = null;
        }
        $answer = [
            'religion' => $this->religion,
            'other_religion' => $this->otherReligion
        ];

        $this->form->createAnswer( $answer, $this->jsonQuestion, $this->stepId);

        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        $this->religion = $this->savedAnswers['religion'] ?? null;
        $this->otherReligion = $this->savedAnswers['other_religion'] ?? null;

        if($this->religion) {
            $this->nextEnabled = true;
        }
    }

    public function setAnswerBlockAnswerId(int $id, string $otherReligion = null): void
    {
        $this->religion = $id;

        if($id == 6 && !is_null($otherReligion)){
            $this->otherReligion = $otherReligion;
        }
        if($id != 6){
            $this->otherReligion = null;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step9');
    }
}
