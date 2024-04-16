<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep8 extends Component
{
    public PostForm $form;
    public int|null $indicationCountry = null;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;

    public string $originCountryName;

    protected $messages = [];

    public $firstRequired = true;

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['indicationCountry.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'indicationCountry' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['indicationCountry.required']);
                    }
                }
            ],
        ];
    }

    public function updatedIndicationCountry()
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
            $this->form->createAnswer(!is_null($this->indicationCountry ) ? [$this->indicationCountry] : [], $this->jsonQuestion, $this->stepId);

            \Session::put(['student-indication-country' => $this->indicationCountry ?? null]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->indicationCountry = old('indicationCountry') ?? \Session::get('student-indication-country') ?? null;
        if($this->indicationCountry) {
            $this->nextEnabled = true;
        }
    }

    public function setAnswerBlockAnswerId(int $id): void
    {
        $this->indicationCountry = $id;
    }

    public function render()
    {
        // skip question when origin country was 1 or not set in question 6
        if(\Session::get('student-origin-country') === 1 || is_null(\Session::get('student-origin-country'))){
            $this->dispatch('set-step-id-up');

            return view('livewire.partials.blanco');
        } else {
            if(\Session::get('student-origin-country') === 6){
                $this->originCountryName = old('originFromCountryName') ?? \Session::get('student-origin-from-country-name') ?? null;
            } else {
                $this->originCountryName = old('originCountryName') ?? \Session::get('student-origin-country-name') ?? null;
            }
        }

        return view('livewire.forms.form-step8');
    }
}
