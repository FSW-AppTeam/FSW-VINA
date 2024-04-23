<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep3 extends Component
{
    public PostForm $form;

    public int|null $age = null;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $savedAnswers;

    public $firstRequired = true;

    protected $messages = [];

    public function rules(): array
    {
        $this->messages['age.required'] = $this->jsonQuestion->question_options['error_empty_text'];
        return [
            'age' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['age.required']);
                    }
                },
            ],
        ];
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        $this->form->createAnswer($this->age, $this->jsonQuestion, $this->stepId);
        $this->dispatch('set-step-id-up');
    }

    public function updatedAge()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-enable-next');
    }


    public function mount(): void
    {
        $this->age = $this->savedAnswers ?? null;
        if($this->age) {
            $this->nextEnabled = true;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step3');
    }
}
