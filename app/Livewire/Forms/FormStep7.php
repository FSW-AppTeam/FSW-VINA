<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep7 extends Component
{
    public PostForm $form;

    public ?int $originCountry = null;

    public ?string $otherCountry = '';

    public $countryModal = true;

    public $stepId;

    public $nextEnabled;

    public $backEnabled;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    protected $messages = [];

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['origin-country.required'] = $this->jsonQuestion->question_options['error_empty_text'];
        $this->messages['origin-country.invalid'] = $this->jsonQuestion->question_options['error_invalid_option'];

        return [
            'originCountry' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['origin-country.required']);
                    }
                },
            ],
            'otherCountry' => [
                function (string $attribute, mixed $value, Closure $fail) {

                    if (! empty($value)) {
                        if (! array_key_exists($value, getCountriesByName())) {
                            $fail($this->messages['origin-country.invalid']);
                        }
                    }
                },
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

        $answer = [
            'country_id' => $this->originCountry,
            'other_country' => $this->otherCountry,
        ];

        $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);
        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        $this->originCountry = $this->savedAnswers['country_id'] ?? null;
        $this->otherCountry = $this->savedAnswers['other_country'] ?? null;

        if ($this->originCountry) {
            $this->nextEnabled = true;
        }

    }

//    public function setAnswerBlockAnswerId(int $id, string $countryName): void
//    {
//        $this->originCountry = $id;
//        if ($id === 6) {
//            $this->dispatch('set-modal-flag');
//        }
//
//        if ($id !== 6) {
//            $this->otherCountry = '';
//        }
//    }

    public function setCountry(): void
    {
        $this->otherCountry = $this->countryModal;
    }

    public function render()
    {
        return view('livewire.forms.form-step7');
    }
}
