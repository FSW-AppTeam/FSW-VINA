<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\AnswerBtnBlock;
use Closure;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep16 extends Component
{
    public PostForm $form;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $savedAnswers;

    public $answerSelected = null;

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
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['answer_id.required']);
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

        $this->form->createAnswer($this->answerSelected['id'] ?? [], $this->jsonQuestion, $this->stepId);
        $this->dispatch('set-enable-next');
        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        foreach ($this->jsonQuestion->question_answer_options as $option) {
            if ($option['id'] === $this->savedAnswers) {
                $this->answerSelected['id'] = $this->savedAnswers;
                $this->answerSelected['value'] = $option['value'];
            }
        }
    }

    public function render()
    {
        $this->dispatch('set-enable-next');
        return view('livewire.forms.form-step16');
    }
}
