<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\FlagImage;
use App\Models\SurveyAnswers;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormStep14 extends Component
{
    public PostForm $form;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $flagsSelected = [];

    public $firstRequired = true;
    public $basicTitle = "";
    public array $students = [];

    public array $startStudent = [];
    public array $finishedStudent = [];
    public $studentCounter = 1;

    protected array $messages = [];

    protected $listeners = [
        'set-selected-flag-id' => 'setSelectedFlagId',
        'remove-selected-flag-id' => 'removeSelectedFlagId',
        'set-sub-step-id-down' => 'stepDown',
        'set-sub-step-id-up' => 'stepUp',
        'set-save-answer' => 'save',
        'set-refresh' => '$refresh',
    ];

    public function rules(): array
    {
        $this->messages['flags.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'flagsSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;

                        $this->dispatch('set-enable-next');
                        $fail($this->messages['flags.required']);
                    }
                },
                'array'
            ],

        ];
    }

    public function setSelectedFlagId(int $id, string $image, string $country): void
    {
        if(count($this->flagsSelected) > 3){
            return;
        }
        $imageFile = false;

        if($image == 'anders'){
            $image = $country;
        }

        if(file_exists(public_path($image))){
            $imageFile = $image;
        }

        $isoFlag = array_search(ucfirst($image), getIsoCountries());
        if(!$imageFile && file_exists(public_path('build/images/flags/' . strtolower($isoFlag) . '.svg'))){
            $imageFile = 'build/images/flags/' . strtolower($isoFlag) . '.svg';
        }

        if(!$imageFile && file_exists(public_path('images/flags/' . strtolower($image) . '.jpg'))){
            $imageFile = 'images/flags/' . strtolower($image) . '.jpg';
        }
        $this->flagsSelected[] = ['id' => $id, 'image' => $imageFile, 'country' => $country];
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

        if (session::has('survey-id')) {
            $answer = [
                'student_id' => $this->startStudent['id'],
                'countries' => $this->flagsSelected
            ];

            $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);
            foreach ($this->flagsSelected as $flagSelect){
                $this->dispatch('set-show-flag-true', $flagSelect['id'])->component(FlagImage::class);
            }
            if(array_key_exists(0, $this->students)){
                $this->studentCounter ++;
                $this->flagsSelected = [];  // db output
                $this->startStudent =  array_shift($this->students);
                $this->jsonQuestion->question_title = $this->basicTitle . " ID: " . $this->startStudent['id'];
                $this->finishedStudent[] = $this->startStudent;
                $this->setDatabaseResponse();
                $this->dispatch('set-enable-next');
            } else {
                $this->dispatch('set-step-id-up');
            }
        }
    }


    public function stepDown(): void
    {
        $this->disappear = false;
        if($this->studentCounter <= 1) {
            $this->dispatch('set-step-id-down');
            return;
        }
        if(!empty($this->finishedStudent)) {
            array_unshift($this->students, array_pop($this->finishedStudent));
            $this->startStudent = end($this->finishedStudent);
            $this->jsonQuestion->question_title = $this->basicTitle . " ID: " . $this->startStudent['id'];

        }
        $this->flagsSelected = [];
        $this->setDatabaseResponse();
        $this->studentCounter --;
    }

    public function stepUp(): void
    {
        $this->dispatch('set-disable-next');
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-disapear-true');

        if(count($this->students) >= 1) {
            $this->dispatch('set-animation-flag-student');
        }
        if(count($this->students) == 0 ) {
            $this->dispatch('set-save-answer');
        }
    }

    public function mount(): void
    {
        $this->basicTitle = $this->jsonQuestion->question_title;
        $this->students = $this->form->getStudentsWithoutActiveStudent();
        $this->startStudent = array_shift($this->students);
        $this->finishedStudent[] = $this->startStudent;
        $this->jsonQuestion->question_title = $this->basicTitle . " ID:" .  $this->startStudent['id'];
        $this->setDatabaseResponse();
    }

    public function render()
    {
        return view('livewire.forms.form-step14');
    }

    public function setDatabaseResponse()
    {
        $response = SurveyAnswers::where('student_id', $this->form->getStudent()->id)
            ->where('question_id', $this->stepId)
            ->whereJsonContains('student_answer->student_id', $this->startStudent['id'])
            ->first();

        if(!$response) {
            Log::info('NIET gevonden' . $this->startStudent['id'] );
            return;
        }
        foreach ($response->student_answer['countries'] as $responseItem) {
            $this->setSelectedFlagId($responseItem['id'], $responseItem['image'], $responseItem['country']);
        }
    }
}
