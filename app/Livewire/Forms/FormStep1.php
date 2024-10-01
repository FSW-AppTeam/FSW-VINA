<?php

namespace App\Livewire\Forms;

use App\Models\Survey;
use Closure;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Throwable;

class FormStep1 extends Component
{
    public PostForm $form;

    public $surveyCode = '';

    public $jsonQuestion;

    public $stepId;

    public $loading = true;

    protected $listeners = [
        'save' => 'save',
    ];

    protected $rules = [
        'surveyCode' => 'required|min:2',
    ];

    protected $messages = [
        'surveyCode.required' => 'De klas code is verplicht.',
        'surveyCode.min' => 'De :attribute moet minimaal 2 karakters zijn.',
    ];

    public function rules(): array
    {
        $this->messages['surveyCode.exists'] = 'Code bestaat niet.';

        return [
            'surveyCode' => [
                'required',
                'min:3',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['surveyCode.exists']);
                    }

                    if (! Survey::checkCode($value)) {
                        $fail($this->messages['surveyCode.exists']);
                    }
                },
            ],

        ];
    }

    public function mount(): void
    {
        if (session::get('survey-id')) {
            $survey = Survey::where('id', session::get('survey-id'));
            if ($survey->exists()) {
                $this->surveyCode = $survey->first()->survey_code;
            }
        }

        if ($this->surveyCode) {
            $this->loading = false;
        }
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
        $survey = Survey::where('survey_code', $this->surveyCode)->first();
        session::put([
            'survey-id' => $survey->id,
        ]);

        $this->dispatch('step-up')->component(StepController::class);
    }

    public function updatedsurveyCode()
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);
        $this->dispatch('set-loading-false');
    }

    public function update()
    {
        $this->dispatch('getJsonQuestion', 1);
    }

    public function render()
    {
        $this->loading = false;
        return view('livewire.forms.form-step1');
    }
}
