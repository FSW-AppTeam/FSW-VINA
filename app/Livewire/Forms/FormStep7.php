<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep7 extends Component
{
    public PostForm $form;

    public int|null $originCountry = null;
    public string|null $originCountryName = "";
    public string|null $fromCountry = "";

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;

    public $firstRequired = true;

    protected $messages = [];

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['origin-country.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'originCountry' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['origin-country.required']);
                    }
                }
            ],
        ];
    }

    public function updatedOriginCountry()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-enable-next');
    }
    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer(!is_null($this->originCountry) ? [$this->originCountry] : [], $this->jsonQuestion, $this->stepId);

            if(!empty($this->fromCountry)){
                $this->jsonQuestion->question_title = $this->jsonQuestion->question_options->question_custom_input_title;
                $this->jsonQuestion->question_type = 'text';
                $this->form->createAnswer([$this->fromCountry], $this->jsonQuestion, $this->stepId);
            }

            \Session::put(['student-origin-country' => $this->originCountry ?? null]);
            \Session::put(['student-origin-country-name' => $this->originCountryName ?? null]);
            \Session::put(['student-origin-from-country-name' => $this->fromCountry ?? null]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->originCountry = old('originCountry') ?? \Session::get('student-origin-country') ?? null;
        $this->originCountryName = old('fromCountry') ?? \Session::get('student-origin-country-name') ?? null;


        if($this->originCountry === 6){
            $this->fromCountry = old('studentOriginFromCountryName') ?? \Session::get('student-origin-from-country-name') ?? null;
        }
        if($this->originCountry) {
            $this->nextEnabled = true;
        }

    }

    public function setAnswerBlockAnswerId(int $id, string $countryName): void
    {
        $this->originCountry = $id;
        $this->originCountryName = $countryName;
    }

    public function render()
    {
        return view('livewire.forms.form-step7');
    }
}
