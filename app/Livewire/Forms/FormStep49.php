<?php

namespace App\Livewire\Forms;

use Closure;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class FormStep49 extends Component
{
    public PostForm $form;

    public $answerSelected = [];

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    public array $students = [];

    public array $questionOptions = [];

    public $subject = false;

    public array $finishedSubjects = [];

    public ?string $otherCountry = '';

    public $showShrink;

    public $disabledBtn = false;

    protected array $messages = [];

    protected $listeners = [
        'set-show-shrink-true' => 'setShowShrinkTrue',
        'set-answer-button-square' => 'setAnswerButtonSquare',
        'set-remove-student' => 'removeStudent',
        'set-remove-selected-square' => 'removeSelectedSquare',
        'set-country' => 'setCountry',
        'set-sub-step-down' => 'stepDown',
        'set-sub-step-up' => 'stepUp',
        'save' => 'save',
    ];

    public function rules(): array
    {
        $this->messages['answer-selected.required'] = $this->jsonQuestion->question_options['error_empty_text'];
        $this->messages['answer-selected.invalid'] = $this->jsonQuestion->question_options['error_invalid_option'];
        $this->messages['otherCountry.required_if'] = 'Een land selecteren is verplicht';
        return [
            'answerSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $this->dispatch('set-loading-false')->component(\App\Livewire\Partials\FormButtons::class);
                        $fail($this->messages['answerSelected.required']);
                    }
                },
                'array',
            ],
            'otherCountry' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if (($this->answerSelected['id'] ?? null) === 5 && empty($value)) {
                        $fail('Een land selecteren is verplicht');
                    }
                    if (! empty($value) && ! array_key_exists($value, getCountriesByName())) {
                        $fail('Ongeldige landkeuze');
                    }
                },
                'nullable',
            ],
        ];
    }

    public function setShowShrinkTrue(): void
    {
        $this->showShrink = true;
    }

    public function setAnswerButtonSquare(int $id, string $val): void
    {
        $this->answerSelected = ['id' => $id, 'value' => $val];
        $this->loading = false;

        if ($id === 5) {
            $this->dispatch('set-loading-false');
            $this->dispatch('set-modal-othercountry');

            return;
        }

        $this->otherCountry = '';
        $this->dispatch('set-loading-false');
  
    }

    public function setCountry(string $country): void
    {
        $this->otherCountry = $country;
        $this->loading = false;

        $this->dispatch('set-loading-false');
        // $this->dispatch('set-loading-false')->component(\App\Livewire\Partials\FormButtons::class);
    }

    public function removeSelectedSquare(int $id): void
    {
        if (in_array($id, $this->answerSelected)) {
            $this->answerSelected = [];
        }
        $this->otherCountry = '';
        $this->disabledBtn = false;
    }

    public function save(): void
    {
        $this->dispatch('set-loading-true');
        $this->disabledBtn = true;
        $this->form->addRulesFromOutside($this->rules());

        try {
            $this->validate($this->rules());
        } catch (Throwable $e) {
            $this->disabledBtn = false;
            $this->dispatch('set-loading-false')->component(\App\Livewire\Partials\FormButtons::class);
            throw $e;
        }

        $answer = [
            'friend_id' => $this->subject['id'],
            'country_id' => array_key_exists('id', $this->answerSelected) ? $this->answerSelected['id'] : null,
            'other_country' => $this->answerSelected['id'] == 5 ? $this->otherCountry : null,
        ];

        $this->jsonQuestion->question_title = $this->jsonQuestion->question_title.' ID:'.$this->subject['id'];
        $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);

        if (isset($this->subject['id'])) {
            \App\Models\SurveyFriend::where('id', $this->subject['id'])
                ->where('owner_student_id', $this->form->getStudent()->id)
                ->update([
                    'country_id' => $this->answerSelected['id'] ?? null,
                    'other_country' => $this->otherCountry,
                ]);
        }

        if (array_key_exists(0, $this->students)) {
            $this->stepUp();
        } else {
            $this->dispatch('step-up')->component(StepController::class);
        }
    }

    public function stepUp(): void
    {
        $this->answerSelected = [];
        $this->otherCountry = '';
        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;

        if (count($this->students) == 0 && $this->subject == null) {
            $this->dispatch('step-up')->component(StepController::class);
        }
        $this->disabledBtn = $this->setDatabaseResponse();
        $this->dispatch('set-loading-false');
    }

    public function stepDown(): void
    {
        if (count($this->finishedSubjects) <= 1) {
            $this->dispatch('step-down')->component(StepController::class);

            return;
        }

        if (! empty($this->finishedSubjects)) {
            array_unshift($this->students, array_pop($this->finishedSubjects));
            $this->subject = end($this->finishedSubjects);
        }

        $this->answerSelected = [];
        $this->otherCountry = '';
        $this->disabledBtn = $this->setDatabaseResponse();
    }

    public function mount(): void
    {
        $this->setStudents();
        shuffle($this->students);
        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;

        $this->disabledBtn = $this->setDatabaseResponse();
    }

    public function render()
    {
        $this->loading = false;

        return view('livewire.forms.form-step49');
    }

    public function setDatabaseResponse()
    {
        if (empty($this->subject)) {
            $this->dispatch('step-up')->component(StepController::class);

            return false;
        }

        $response = \App\Models\SurveyAnswer::where('student_id', $this->form->getStudent()->id)
            ->where('question_id', $this->jsonQuestion->id)
            ->whereJsonContains('student_answer->student_id', $this->subject['id'])
            ->first();

        if (! $response) {
            $this->dispatch('set-loading-false')->component(\App\Livewire\Partials\FormButtons::class);
            Log::info('Could not find response to question '.$this->jsonQuestion->id.
                ' for subject '.$this->subject['id'].
                ' and current student '.$this->form->getStudent()->id);

            return false;
        }

        $answer = $response->student_answer ?? [];
        $this->answerSelected = [];
        $this->otherCountry = $answer['other_country'] ?? '';

        if (! empty($answer['country_id'])) {
            foreach ($this->jsonQuestion->question_answer_options as $key => $option) {
                if ($option['id'] == $answer['country_id']) {
                    $this->answerSelected = ['id' => $answer['country_id'], 'value' => $option['value']];
                }
            }
        }

        $this->dispatch('set-loading-false')->component(\App\Livewire\Partials\FormButtons::class);

        return true;
    }

    public function setStudents(): void
    {
        $this->students = $this->form->getSelectablesForQuestion($this->jsonQuestion);
    }
}
