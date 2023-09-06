<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStep3 extends Component
{
    public PostForm $form;

    public int|null $age;

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'age' => 'required',
    ];

    protected $messages = [
        'age.required' => 'Leeftijd is verplicht',
    ];


    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer([$this->age], $this->jsonQuestion, $this->stepId);

            \Session::put([
                'student-age' => $this->age
            ]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
//        $this->age = old('age');
//        session()->flush();

        $this->age = old('age') ?? session()->get('student-age');

        dump('form step 3 mounted!!');
    }

    public function render()
    {
        return view('livewire.forms.form-step3');
    }
}
