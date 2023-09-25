<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use App\Models\SurveyStudent;
use Arr;
use Closure;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Validator;

class FormStep11 extends Component
{
    public PostForm $form;

    public array $friends = [];

    public int $stepId;

    public \stdClass $jsonQuestion;

    public $firstRequired = true;

    protected array $messages = [

    ];

    protected $listeners = [
        'set-selected-student-id' => 'setSelectedStudentId',
        'remove-selected-student-id' => 'removeSelectedStudentId',
    ];

    public function setSelectedStudentId(int $id, string $name): void
    {
        $this->friends[] = ['id' => $id, 'name' => $name ];
    }

    public function removeSelectedStudentId(int $id): void
    {
        $key = array_search($id, array_column($this->friends, 'id'));

        if(is_int($key)){
            array_splice($this->friends, $key, 1);
        }

        $this->dispatch('set-toggle-view-student');
    }

    public function rules(): array
    {
        $this->messages['friends.required'] = $this->jsonQuestion->question_options->error_empty_text;
        $this->messages['friends.min'] = $this->jsonQuestion->question_options->error_one_text;

        return [
            'friends' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired) {
                        $this->firstRequired = false;

                        if (empty($value)) {
                            $fail($this->messages['friends.required']);
                        }

                        if (count($value) === 1) {
                            $fail($this->messages['friends.min']);
                        }
                    }
                },
                'array'
            ]
        ];
    }

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer(array_column($this->friends, 'id'), $this->jsonQuestion, $this->stepId);

            \Session::put(['student-own-friends-trust' => $this->friends]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->friends = old('friends') ?? \Session::get('student-own-friends-trust') ?? [];

        dump('form step 11 mounted!');
    }

    public function render()
    {
        return view('livewire.forms.form-step11');
    }
}
