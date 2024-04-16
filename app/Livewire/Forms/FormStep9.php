<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep9 extends Component
{
    public PostForm $form;

    public int|null $religion = null;
    public string $newReligion;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;

    protected $messages = [];

    public $firstRequired = true;

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['religion.required'] = $this->jsonQuestion->question_options->error_empty_text;

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

        if (\Session::has('survey-id')) {
            $this->form->createAnswer( !is_null($this->religion) ? [$this->religion] : [], $this->jsonQuestion, $this->stepId);

            if(!empty($this->newReligion)){
                $this->jsonQuestion->question_title = $this->jsonQuestion->question_options->question_custom_input_title;
                $this->jsonQuestion->question_type = 'text';
                $this->form->createAnswer([$this->newReligion], $this->jsonQuestion, $this->stepId);
            }

            \Session::put(['student-religion' => $this->religion ?? null]);
            \Session::put(['student-religion-different' => $this->newReligion ?? ""]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->religion = old('religion') ?? \Session::get('student-religion') ?? null;

        if($this->religion === 6){
            $this->newReligion = old('newReligion') ?? \Session::get('student-religion-different') ?? "";
        }
        if($this->religion) {
            $this->nextEnabled = true;
        }
    }

    public function setAnswerBlockAnswerId(int $id, string $newReligion = null): void
    {
        $this->religion = $id;

        if(!is_null($newReligion)){
            $this->newReligion = $newReligion;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step9');
    }
}
