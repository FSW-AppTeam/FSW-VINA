<?php

namespace App\Livewire\Forms;

use App\Models\Survey;
use Closure;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep1 extends Component
{
    public PostForm $form;
    public $surveyCode = '';

    public $jsonQuestion;
    public $stepId;
    public $nextEnabled;
    public $backEnabled;

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
                function (string $attribute, mixed $value, Closure $fail) {
                    if (empty($value)) {
                        $this->firstRequired = false;
                        $this->dispatch('set-disable-next');
                        $fail($this->messages['surveyCode.exists']);
                    }

                    if (!Survey::checkCode($value)) {
                        $this->dispatch('set-disable-next');
                        $fail($this->messages['surveyCode.exists']);
                    }
                }
            ],

        ];
    }

    public function mount(): void
    {
        if(session::get('survey-id')) {
            $survey = Survey::where('id', session::get('survey-id'));
            if($survey->exists()) {
                $this->surveyCode = $survey->first()->survey_code;
            }
        }

        if($this->surveyCode) {
            $this->nextEnabled = true;
        }
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $survey = Survey::where('survey_code', $this->surveyCode)->first();
        session::put([
            'survey-id' => $survey->id,
        ]);

        $this->dispatch('set-step-id-up');
    }

    public function updatedsurveyCode()
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);
        $this->dispatch('set-enable-next');
    }

    public function update()
    {
        $this->dispatch('getJsonQuestion', 1);
    }

    public function render()
    {
        return view('livewire.forms.form-step1');
    }
}
