<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use Closure;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormStep8 extends Component
{
    public PostForm $form;
    public int|null $indicationCountry = null;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $savedAnswers;

    public $depentsOnQuestion = 7;

    protected $messages = [];

    public $firstRequired = true;

    public $originCountryName;

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['indicationCountry.required'] = $this->jsonQuestion->question_options['error_empty_text'];

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
        $this->form->createAnswer($this->indicationCountry, $this->jsonQuestion, $this->stepId);

        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        $this->indicationCountry = $this->savedAnswers ?? null;
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
        $savedAnswer = SurveyAnswer::where('question_id', $this->depentsOnQuestion)
            ->where('student_id', Session::get('student-id'));

        if(!$savedAnswer->exists()) {
            $this->dispatch('set-step-id-up');
            return view('livewire.partials.blanco');
        }

        $depentsOnQuestionAnswers =  $savedAnswer->first()->student_answer;

        if($depentsOnQuestionAnswers['country_id'] === 1) {
            $this->dispatch('set-step-id-up');
            return view('livewire.partials.blanco');
        }

        $depentsOnQuestion = SurveyQuestion::find($this->depentsOnQuestion);

        foreach($depentsOnQuestion->question_answer_options as $option){
            if($option['id'] === $depentsOnQuestionAnswers['country_id']) {
                $this->originCountryName = $option['value'];
            }
        }

        if($depentsOnQuestionAnswers['country_id'] === 6) {
            $this->originCountryName = $depentsOnQuestionAnswers['other_country'];
        }

        return view('livewire.forms.form-step8');
    }
}
