<?php

namespace App\Livewire;

use App\Models\SurveyStudent;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormStep2 extends Component
{
    public string $name = '';

    protected $rules = [
        'name' => 'required|min:2',
    ];

    protected $messages = [
        'name.required' => 'Naam is verplicht',
        'name.min' => 'Je naam is minimaal 2 karakters.',
    ];

    public $stepId;

    public $jsonQuestion;

    public function save(): void
    {
        $this->validate();

//        $this->success = true;
//        $this->reset('title', 'body');

        \Session::put([
            'step2-student-name' => $this->name,
            'step2' => true
        ]);

        if (\Session::has('step1-student-class-code')) {
            SurveyStudent::firstOrCreate([
                'survey_id' => 1,
                'name' => $this->name,
                'class_id' => \Session::get('step1-student-class-code'),
            ]);
        }

        $this->dispatch('setStepIdUp');
    }

    public function mount(): void
    {
        $this->name = old('student-name') ?? \Session::get('step2-student-name') ?? "";
    }

    public function render()
    {
        return view('livewire.form-step2');
    }
}
