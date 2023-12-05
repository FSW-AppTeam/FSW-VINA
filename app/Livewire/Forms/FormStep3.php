<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep3 extends Component
{
    public PostForm $form;

    public int|null $age = null;

    public $stepId;

    public $jsonQuestion;

    public $firstRequired = true;

    public $setPage = true;

    protected $messages = [];

    public function rules(): array
    {
        $this->messages['age.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'age' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['age.required']);
                    } else {
                        $this->setPage = false;
                    }
                },
                'numeric'
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer(!is_null($this->age) ? [$this->age] : [], $this->jsonQuestion, $this->stepId);

            \Session::put([
                'student-age' => $this->age ?? null
            ]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->age = old('age') ?? \Session::get('student-age') ?? null;
    }

    public function render()
    {
        return view('livewire.forms.form-step3');
    }
}
