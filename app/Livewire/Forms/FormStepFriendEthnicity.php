<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\FormButtons;
use App\Models\SurveyFriend;
use Closure;
use Livewire\Component;
use Throwable;

class FormStepFriendEthnicity extends Component
{
    public PostForm $form;

    public array $answerSelected = [];

    public int $stepId;

    public $jsonQuestion;

    public bool $loading = true;

    public array $friends = [];

    public ?SurveyFriend $subject = null;

    public array $finishedSubjects = [];

    public bool $disabledBtn = false;

    protected array $messages = [];

    protected $listeners = [
        'set-answer-button-square' => 'setAnswerButtonSquare',
        'set-remove-selected-square' => 'removeSelectedSquare',
        'set-sub-step-down' => 'stepDown',
        'set-sub-step-up' => 'stepUp',
        'save' => 'save',
    ];

    public function rules(): array
    {
        $this->messages['answerSelected.required'] =
            $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'answerSelected' => 'required|array',
        ];
    }

    public function mount(): void
    {
        $this->friends = $this->form
            ->getStudent()
            ->friends()
            ->orderBy('position')
            ->get()
            ->all();

        $this->subject = array_shift($this->friends);

        if ($this->subject) {
            $this->finishedSubjects[] = $this->subject;
            $this->disabledBtn = $this->setDatabaseResponse();
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step-friend-ethnicity');
    }

    public function save(): void
    {
        $this->dispatch('set-loading-true');

        try {
            $this->validate();
        } catch (Throwable $e) {
            $this->dispatch('set-loading-false')->component(FormButtons::class);
            throw $e;
        }

        $this->subject->update([
            'country_id' => $this->answerSelected['id'],
        ]);

        if (! empty($this->friends)) {
            $this->stepUp();
        } else {
            $this->dispatch('step-up')->component(StepController::class);
        }
    }

    public function stepUp(): void
    {
        $this->answerSelected = [];

        $this->subject = array_shift($this->friends);

        if (! $this->subject) {
            $this->dispatch('step-up')->component(StepController::class);

            return;
        }

        $this->finishedSubjects[] = $this->subject;

        $this->disabledBtn = $this->setDatabaseResponse();

        $this->dispatch('set-loading-false');
    }

    public function stepDown(): void
    {
        if (count($this->finishedSubjects) <= 1) {
            $this->dispatch('step-down')->component(StepController::class);

            return;
        }

        array_unshift($this->friends, array_pop($this->finishedSubjects));

        $this->subject = end($this->finishedSubjects);

        $this->answerSelected = [];

        $this->disabledBtn = $this->setDatabaseResponse();
    }

    public function setAnswerButtonSquare(int $id, string $value): void
    {
        $this->answerSelected = [
            'id' => $id,
            'value' => $value,
        ];

        $this->save();
    }

    public function removeSelectedSquare(int $id): void
    {
        if (($this->answerSelected['id'] ?? null) === $id) {
            $this->answerSelected = [];
        }

        $this->disabledBtn = false;
    }

    protected function setDatabaseResponse(): bool
    {
        if (! $this->subject) {
            return false;
        }

        if ($this->subject->country_id === null) {
            return false;
        }

        foreach ($this->jsonQuestion->question_answer_options as $option) {
            if ($option['id'] == $this->subject->country_id) {
                $this->answerSelected = [
                    'id' => $option['id'],
                    'value' => $option['value'],
                ];

                return true;
            }
        }

        return false;
    }
}