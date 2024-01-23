<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\FlagImage;
use Closure;
use Livewire\Component;

class FormStep13 extends Component
{
    public PostForm $form;

    public $stepId;

    public $jsonQuestion;
    public $flagsSelected = [];

    public $firstRequired = true;

    protected array $messages = [];

    protected $listeners = [
        'set-selected-flag-id' => 'setSelectedFlagId',
        'remove-selected-flag-id' => 'removeSelectedFlagId',
        'set-refresh' => '$refresh',
    ];

    public function rules(): array
    {
        $this->messages['flags.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'flagsSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired) {
                        $this->firstRequired = false;

                        if (empty($value)) {
                            $fail($this->messages['flags.required']);
                        }
                    }
                },
                'array'
            ],
        ];
    }


    public function setSelectedFlagId(int $id, string $image, string $country): void
    {
        if(count($this->flagsSelected) <= 3){
            $this->flagsSelected[] = ['id' => $id, 'image' => $image, 'country' => $country];
        }
    }

    public function removeSelectedFlagId(int $id, string $country): void
    {
        foreach ($this->flagsSelected as $key => $flagSelect){
            if($flagSelect['id'] === $id && $flagSelect['country'] === $country){
                array_splice($this->flagsSelected, $key, 1);
            }
        }

        $this->dispatch('set-show-flag-true', $id)->component(FlagImage::class);
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer($this->flagsSelected, $this->jsonQuestion, $this->stepId);

            \Session::put(['student-country-culture-self' => $this->flagsSelected]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->flagsSelected = old('flagsSelected') ?? \Session::get('student-country-culture-self') ?? [];
    }

    public function render()
    {
        return view('livewire.forms.form-step13');
    }
}
