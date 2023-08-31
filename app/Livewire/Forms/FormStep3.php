<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Livewire\Component;

class FormStep3 extends Component
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

//    public string $route;

    public $jsonQuestion;

    public function save(): void
    {
        $this->validate();

//        $this->success = true;

        \Session::put([
            'step3-student-name' => $this->name,
            'step3' => true
        ]);

        if (\Session::has('step1-student-class-code')) {
            $answer = SurveyAnswers::firstOrCreate([
                'survey_id' => 1,
                'name' => $this->name,
                'class_id' => \Session::get('step1-student-class-code'),
            ]);


//            'class_id',
//        'student_id',
//        'survey_id',
//        'question_id',
//        'question_type',
//        'question_title',
//        'question_answer',
//

        }

        $this->dispatch('set-step-id-up');


//        $this->reset('name', 'body');

//        if ($validator->passes()) {
//            return response()->json(['success'=>'Added new records.']);
//        }
//        return response()->json(['error'=>$validator->errors()]);

    }

    public function mount(): void
    {
        $this->name = old('name') ?? \Session::get('step1-student-name') ?? "";
    }

    public function render()
    {
        return view('livewire.forms.form-step3');
    }
}
