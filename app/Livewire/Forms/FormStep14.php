<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\FlagImage;
use App\Models\SurveyAnswers;
use App\Models\SurveyStudent;
use Closure;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormStep14 extends Component
{
    public PostForm $form;

    public $stepId;

    public $jsonQuestion;
    public $flagsSelected = [];

    public $firstRequired = true;

    protected array $messages = [];

    public $basicTitle = "";

    public array $students = [];

    public array $startStudent = [];
    public array $shadowStudents = [];
    public $studentCounter = 1;

    public  $setPage = true;

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
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
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
        $isoFlag = array_search(ucfirst($image), getIsoCountries());
        if(file_exists(public_path('build/images/flags/' . strtolower($isoFlag) . '.svg'))){
            $imageFile = asset('build/images/flags/' . strtolower($isoFlag) . '.svg');

        }

        if(!$imageFile && file_exists(public_path('flags/' . strtolower($image) . '.jpg'))){
            $imageFile = asset('flags/' . strtolower($image) . '.jpg');
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

        if (session::has('survey-student-class-id')) {
            $answer = [
                'student_id' => $this->startStudent['id'],
                'countries' => $this->flagsSelected
            ];

            $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);
            session::put(['student-country-culture-student' => $this->flagsSelected]);

            $this->dispatch('set-animation-flag-student');

            if(array_key_exists(1, $this->students)){
                foreach ($this->flagsSelected as $flagSelect){
                    $this->dispatch('set-show-flag-true', $flagSelect['id'])->component(FlagImage::class);
                }

                $this->startStudent = $this->students[1];
                $this->studentCounter ++;
                $this->flagsSelected = [];  // db output
                $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;

                array_shift($this->students);
            } else {
                $this->dispatch('set-step-id-up');
            }
        }
    }

    public function mount(): void
    {
        $this->flagsSelected = old('flagsSelected') ?? \Session::get('student-country-culture-student') ?? [];

        $this->basicTitle = $this->jsonQuestion->question_title;
        $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;
        $this->students = $this->form->getStudentsWithoutActiveStudent();
        $this->shadowStudents = $this->students;

        if(empty($this->startStudent)){
            $this->startStudent = $this->students[0];
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step14');
    }

    public function setDatabaseResponse()
    {
        $response = SurveyAnswers::where('student_id', $this->form->getStudent()->id)
            ->where('survey_id', $this->jsonQuestion->survey_id)
            ->where('question_id', $this->stepId)
            ->whereJsonContains('student_answer->id', $this->startFriend['id'])
            ->first();

        if(!$response) {
            ray('NIET gevonden' . $this->startFriend['id'] );
            return;
        }

        foreach ($response->student_answer['value'] as $response) {
            $student = SurveyStudent::find($response);
            $this->setSelectedStudentId($response, $student->name);
        }
    }
}
