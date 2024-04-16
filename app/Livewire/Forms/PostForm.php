<?php

namespace App\Livewire\Forms;

use App\Models\Survey;
use App\Models\SurveyAnswers;
use App\Models\SurveyStudent;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Features\SupportValidation\HandlesValidation;
use Livewire\Form;
use stdClass;

class PostForm extends Form
{
    use HandlesValidation;
    public ?SurveyAnswers $answers;

    #[Computed(persist: true)]
    public function getStudent(): SurveyStudent
    {
        return SurveyStudent::find(session::get('student-id'));
    }

    #[Computed(persist: true)]
    public function getSurvey(): Survey
    {
        return Survey::find(session::get('survey-id'));
    }

    #[Computed(persist: true)]
    public function getStudentsWithoutActiveStudent(): array
    {
        return SurveyStudent::where('survey_id', $this->getSurvey()->id)
            ->whereNot('id', $this->getStudent()->id)
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function getStudentsSelfFriendsSelected(): array
    {
        $answers = SurveyAnswers::where('student_id', $this->getStudent()->id)
            ->where('question_id', '=', 10)
            ->get('student_answer')->first()->student_answer;

        return $this->getStudent()
            ->whereIn('id', $answers)
            ->where('survey_id', $this->getSurvey()->id)
            ->get()
            ->toArray();
    }

    public function getStudentsNotInFriendsSelected(): array
    {
        $answers = SurveyAnswers::where('student_id', $this->getStudent()->id)
            ->where('question_id', '=', 10)
            ->get('student_answer')->first()->student_answer;

        return $this->getStudent()
            ->whereNot('id', $this->getStudent()->id)
            ->whereNotIn('id', $answers)
            ->where('survey_id', '=', $this->getSurvey()->id)
            ->limit(3)
            ->get()
            ->toArray();
    }

    public function getStudentsFriendsRelationsSelected(): array
    {
        $answers = SurveyAnswers::where('survey_answers.student_id', $this->getStudent()->id)
            ->where('survey_answers.question_id', 12) // friends of friends
            ->join('survey_students', 'survey_answers.student_id', '=', 'survey_students.id')
            ->where('survey_students.survey_id', '=', $this->getSurvey()->id)
            ->get(['survey_answers.student_answer'])
            ->toArray();

        $allFriends= [];
        // flat student array for import
        foreach ($answers as $answer){
              if(isset($answer['student_answer']['value'])){
                  foreach ($answer['student_answer']['value'] as $selectedFriend){
                    $allFriends[] = ['id' => $answer['student_answer']['student_id'], 'relation_id' => $selectedFriend];
                  }
              }
        }

        $uniqueStudents = [];

        try {
            $uniqueStudents = array_unique(
                array_merge(array_column($allFriends, 'id'), array_column($allFriends, 'relation_id'))
            );
        } catch (\Exception $e){
            dd($e->getMessage(), $allFriends);
        }

        $students = $this->getStudent()
            ->whereIn('id', $uniqueStudents)
            ->where('survey_id', $this->getSurvey()->id)
            ->get()
            ->toArray();

        return ['students' => $students, 'relations' => $allFriends];
    }

    public function createAnswer(array $answer, stdClass $jsonQuestions, int $stepId): void
    {
        SurveyAnswers::updateOrCreate(
            [
                'student_id' => $this->getStudent()->id,
                'question_id' => $jsonQuestions->question_id,
                'question_title' => $jsonQuestions->question_title,
            ],
            [
                'student_answer' => $answer,
                'question_type' => $jsonQuestions->question_type,
            ]
        );

        session::put([
            "step$stepId" => true
        ]);
    }

    public function createStudent(string $name, string $surveyId, bool $setSession = true): void
    {
       $student = SurveyStudent::firstOrCreate([
            'name' => strip_tags($name),
            'survey_id' => strip_tags($surveyId)
        ]);

       if($setSession){
           session::put([
               'student-name' => strip_tags($name),
               'student-id' => strip_tags($student->id),
               'survey-id' =>strip_tags($surveyId),
               'step2' => true
           ]);
       }
    }

    /**
     * Get student list from json file for testing purposes
     *
     * @param stdClass $studentList
     * @return void
     */
    public function createStudentListFromJson(stdClass $studentList): void
    {
        $this->createStudent($studentList->survey_id, $studentList->active_student, $studentList->class_id);

        foreach ($studentList->survey_students as $studentName){
            $this->createStudent($studentList->survey_id, $studentName, $studentList->class_id, false);
        }
    }

    public function setStudentFinishedSurvey(): void
    {
        SurveyStudent::where([
            'id' => $this->getStudent()->id,
            ])
        ->update([
            'finished_at' => now()
        ]);
    }

    public function update()
    {
        $this->answers->update(
            $this->all()
        );
    }

}
