<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\AnswerBtnBlock;
use Closure;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep24 extends Component
{
    public PostForm $form;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;

    public $answerSelected = [];

    public $firstRequired = true;

    protected array $messages = [];

    public $basicTitle = "";

    public array $students = [];

    public array $startStudent = [];

    public int $answerId;

    protected $listeners = [
        'set-answer-button-square' => 'setAnswerButtonSquare',
        'set-remove-selected-square' => 'removeSelectedSquare',
        'set-save-answer' => 'save',
    ];

    public function rules(): array
    {
        $this->messages['answer_id.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'answerSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired) {
                        $this->firstRequired = false;

                        if (empty($value)) {
                            $fail($this->messages['answer_id.required']);
                        }
                    }
                },
                'array'
            ],

        ];
    }

    public function setAnswerButtonSquare(int $id, string $val): void
    {
        $this->answerSelected = ['id' => $id, 'value' => $val];

        $this->dispatch('set-show-btn-false', $id)->component(AnswerBtnBlock::class);
    }

    public function removeSelectedSquare(int $id): void
    {
        if(in_array($id, $this->answerSelected)){
            $this->answerSelected = [];
        }

        $this->dispatch('refreshAnswerBtnBlock')->component(AnswerBtnBlock::class);
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        if (session::has('survey-id')) {
            $this->form->createAnswer(isset($this->answerSelected['id']) ? [$this->answerSelected['id']] : [], $this->jsonQuestion, $this->stepId);

            session::put(['student-class-polarisation' => $this->answerSelected]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->answerSelected = old('answerSelected') ?? session::get('student-class-polarisation') ?? [];
    }

    public function render()
    {
        return view('livewire.forms.form-step24');
    }
}
