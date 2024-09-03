<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;
use Throwable;

class FormStep7 extends Component
{
    public PostForm $form;

    public ?int $originCountry = null;

    public ?string $otherCountry = '';

    public $countryModal = true;

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    protected $messages = [];

    protected $listeners = [
        'save' => 'save',
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['origin-country.required'] = $this->jsonQuestion->question_options['error_empty_text'];
        $this->messages['origin-country.invalid'] = $this->jsonQuestion->question_options['error_invalid_option'];
        $this->messages['otherCountry.required_if'] = 'Een land selecteren is verplicht';

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
                'required_if:originCountry,6',
            ],
        ];
    }

    public function updatedOriginCountry()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-loading-false');
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        try {
            $this->validate($this->rules());
        } catch (Throwable $e) {
            $this->dispatch('set-loading-false');
            throw $e;
        }
        $answer = [
            'country_id' => $this->originCountry,
            'other_country' => $this->otherCountry,
        ];

        $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);
        $this->dispatch('step-up')->component(StepController::class);
    }

    public function mount(): void
    {
        $this->originCountry = $this->savedAnswers['country_id'] ?? null;
        $this->otherCountry = $this->savedAnswers['other_country'] ?? null;

        if ($this->originCountry) {
            $this->loading = false;
        }

    }

    public function setAnswerBlockAnswerId(int $id): void
    {
        $this->originCountry = $id;
        if ($id === 6) {
            $this->dispatch('set-modal-othercountry');
        }

        if ($id !== 6) {
            $this->otherCountry = '';
        }
    }

    public function setCountry(): void
    {
        $this->otherCountry = $this->countryModal;
    }

    public function render()
    {
        $this->loading = false;
        return view('livewire.forms.form-step7');
    }
}
