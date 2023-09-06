<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use App\Models\SurveyStudent;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Form;
use stdClass;

class PostForm extends Form
{
    public ?SurveyAnswers $answers;

    #[Computed(persist: true)]
    public function getStudent(): SurveyStudent
    {
        return SurveyStudent::find(\Session::get('survey-student-id'));
    }

    #[Computed(persist: true)]
    public function getStudentsWithoutActiveStudent(): array
    {
        return SurveyStudent::where('class_id', $this->getStudent()->class_id)
            ->whereNot('id', $this->getStudent()->id)
            ->get()
            ->toArray();
    }

    public function createAnswer(array $answer, stdClass $jsonQuestions, int $stepId): void
    {
        SurveyAnswers::updateOrCreate(
            [
                'student_id' => $this->getStudent()->id,
                'survey_id' => $jsonQuestions->survey_id,
                'question_id' => $jsonQuestions->question_id,
                'question_type' => $jsonQuestions->question_type,
                'question_title' => $jsonQuestions->question_title,
            ],
            [
                'student_answer' => $answer
            ]
        );

        \Session::put([
            "step$stepId" => true
        ]);

//        dump(json_encode($answer));
//        dd('yes created');

//        $this->reset();
    }

    public function createStudent(int $surveyId, string $name, string $classId): void
    {
       $student = SurveyStudent::firstOrCreate([
            'survey_id' => $surveyId,
            'name' => $name,
            'class_id' => $classId,
        ]);

        \Session::put([
            'student-name' => $name,
            'survey-student-id' => $student->id,
            'survey-student-class-id' => $classId,
            'step2' => true
        ]);
    }

    public function update()
    {
        $this->answers->update(
            $this->all()
        );
    }

}
