<?php

namespace App\Livewire\Forms;

use App\Models\SurveyStudent;
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

        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        $this->name = old('student-name') ?? \Session::get('step2-student-name') ?? "";

//        $this->dispatch('getJsonQuestion', 2);
        dump('form step 2 mounted!!');

        session()->flash('message', 'Form Step 2 mounted -- ' . $this->stepId);
    }

    public function render()
    {
        return view('livewire.forms.form-step2');
    }
}
