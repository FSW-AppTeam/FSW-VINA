<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Livewire\Component;

class FormStep31 extends Component
{
    public PostForm $form;

    public string $name = '';

    protected $rules = [
//        'name' => 'required|min:2',
    ];

    protected $messages = [
        'name.required' => 'Naam is verplicht',
        'name.min' => 'Je naam is minimaal 2 karakters.',
    ];

    public $stepId;

    public $jsonQuestion;

    public $answerValues;

    public function save(): void
    {
//        $this->validate();

        if (\Session::has('survey-student-class-id')) {
             $this->form->createAnswer($this->answerValues, $this->jsonQuestion, $this->stepId);

            $this->dispatch('set-step-id-up');
        }


//        $this->reset('name', 'body');

//        if ($validator->passes()) {
//            return response()->json(['success'=>'Added new records.']);
//        }
//        return response()->json(['error'=>$validator->errors()]);

    }

    public function mount(): void
    {
        $this->name = old('name') ?? \Session::get('step1-student-name') ?? "";

        $this->answerValues = [
            ['id' => 2, 'value' => 4],
            ['id' => 5, 'value' => 2],
            ['id' => 6, 'value' => 3],
        ];

    }

    public function render()
    {
        return view('livewire.forms.form-step31');
    }
}
