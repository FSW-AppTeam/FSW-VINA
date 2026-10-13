<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\FormButtons;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use Closure;
use Livewire\Component;
use Throwable;

class FormStepMultiText extends Component
{
    public PostForm $form;

    public array $input = [];

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    public $maxEntries = 15;

    protected $messages = [];

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
        'save' => 'save',
    ];

    public function rules(): array
    {
        if (isset($this->jsonQuestion->question_options['error_empty_text'])) {
            $this->messages['input.required'] = $this->jsonQuestion->question_options['error_empty_text'];
            $this->messages['input.unique'] = $this->jsonQuestion->question_options['error_unique_text'];
        }

        $rules = [
            'input' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    $filledValues = array_filter($this->input, function ($item) {
                        return trim((string) $item) !== '';
                    });

                    $requiredInputs = $this->jsonQuestion->question_options['mandatory_inputs'] ?? 1;
                    if (count($filledValues) < $requiredInputs) {
                        $this->dispatch('set-loading-false')->component(FormButtons::class);
                        $fail($this->messages['input.required']);
                    }

                    // Check for duplicate names
                    $normalizedNames = array_map(
                        fn ($name) => mb_strtolower(trim((string) $name)),
                        $filledValues
                    );

                    if (count($normalizedNames) !== count(array_unique($normalizedNames))) {
                        $fail($this->messages['input.unique']);
                    }

                    if (
                        data_get($this->jsonQuestion, 'question_options.friend_source')
                        || data_get($this->jsonQuestion, 'question_options.friend_source_migratory_background')
                    ) {
                        $friendQuestionIds = SurveyQuestion::query()
                            ->get(['id', 'question_options'])
                            ->filter(fn (SurveyQuestion $question) =>
                                data_get($question, 'question_options.friend_source')
                                || data_get($question, 'question_options.friend_source_migratory_background')
                            )
                            ->pluck('id')
                            ->reject(fn (int $id) => $id === $this->jsonQuestion->id);

                        $otherFriendNames = SurveyAnswer::query()
                            ->where('student_id', $this->form->getStudent()->id)
                            ->whereIn('question_id', $friendQuestionIds)
                            ->get()
                            ->flatMap(fn (SurveyAnswer $answer) => $answer->student_answer ?? [])
                            ->map(fn ($name) => mb_strtolower(trim((string) $name)))
                            ->all();

                        if (array_intersect($normalizedNames, $otherFriendNames)) {
                            $fail($this->messages['input.unique']);
                        }
                    }
                },
            ],
        ];

        if (isset($this->jsonQuestion->question_options['validation_max'])) {
            $rules['input'][] = 'max:'.$this->jsonQuestion->question_options['validation_max'];
        }

        return $rules;
    }

    public function updatedInput()
    {
        $this->resetValidation('input');
        $this->dispatch('set-loading-false');
    }

    public function setAnswerBlockAnswerId($id): void
    {
        $this->input = $id;
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
        $this->form->createAnswer($this->formatInputValue(), $this->jsonQuestion, $this->stepId);
        $this->dispatch('step-up')->component(StepController::class);
    }

    public function mount(): void
    {
        $this->maxEntries = $this->jsonQuestion->question_options['available_inputs'] ?? $this->maxEntries;
        $this->input = $this->normalizeInput($this->savedAnswers);
        if (! empty(array_filter($this->input, function ($item) {
            return trim((string) $item) !== '';
        }))) {
            $this->loading = false;
        }
    }

    public function render()
    {
        $this->loading = false;

        return view('livewire.forms.form-step-multi-text');
    }

    private function normalizeInput(mixed $value): array
    {
        $values = array_fill(0, $this->maxEntries, '');

        if (is_array($value)) {
            foreach ($value as $index => $item) {
                if ($index < $this->maxEntries) {
                    $values[$index] = (string) $item;
                }
            }

            return $values;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                foreach ($decoded as $index => $item) {
                    if ($index < $this->maxEntries) {
                        $values[$index] = (string) $item;
                    }
                }

                return $values;
            }

            $lines = preg_split('/\r\n|\r|\n/', $value) ?: [];
            foreach ($lines as $index => $line) {
                if ($index < $this->maxEntries) {
                    $values[$index] = $line;
                }
            }
        }

        return $values;
    }

    private function formatInputValue(): array
    {
        return array_values(array_filter(
            array_map(
                fn ($value) => trim((string) $value),
                $this->input
            )
        ));
    }
}
