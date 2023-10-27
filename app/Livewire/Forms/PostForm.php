<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use App\Models\SurveyStudent;
use Livewire\Attributes\Computed;
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
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function getStudentsSelfFriendsSelected(): array
    {
        $answer = SurveyAnswers::where('student_id', $this->getStudent()->id)
            ->where('survey_id', '=', 1)
            ->where('question_id', '=', 10)
            ->get('student_answer')->first()->student_answer;

        return $this->getStudent()
            ->whereIn('id', $answer)
            ->where('class_id', $this->getStudent()->class_id)
            ->get()
            ->toArray();
    }

    public function getStudentsNotInFriendsSelected(): array
    {
        $answer = SurveyAnswers::where('student_id', $this->getStudent()->id)
            ->where('survey_id', '=', 1)
            ->where('question_id', '=', 10)
            ->get('student_answer')->first()->student_answer;

        return $this->getStudent()
            ->whereNot('id', $this->getStudent()->id)
            ->whereNotIn('id', $answer)
            ->where('class_id', $this->getStudent()->class_id)
            ->limit(3)
            ->get()
            ->toArray();
    }

    public function getStudentsFriendsRelationsSelected(): array
    {
        $answer = SurveyAnswers::where('survey_answers.student_id', $this->getStudent()->id)
            ->where('survey_answers.survey_id', '=', 1)
            ->where('survey_answers.question_id', '=', 10)  // own friends
            ->orWhere('survey_answers.question_id', '=', 12) // friends of friends
            ->get('student_answer')
            ->toArray();

        $allFriends= [];
        $allFriendsFirst = [];
        foreach ($answer[0]['student_answer'] as $val){
            $allFriendsFirst[] = ['id' => $this->getStudent()->id, 'relation_id' => $val];
        }

//        unset($answer[0]); // reset for own friends
      // reset for own friends

        // flat student array for import
        foreach ($answer as $friend){
              if(isset($friend['student_answer'][0]['value'])){
                  foreach ($friend['student_answer'][0]['value'] as $selectedFriend){
                    $allFriends[] = ['id' => $friend['student_answer'][0]['id'], 'relation_id' => $selectedFriend];
                  }
              }
        }

        unset($allFriendsFirst[0]);  //reset for own friends

        $allFriends = array_merge($allFriendsFirst, $allFriends);
        $uniqueStudents = [];

        try {
            $uniqueStudents = array_unique(
                array_merge(array_column($allFriends, 'id'), array_column($allFriends, 'relation_id'))
            );
        } catch (\Exception $e){
            dd($e->getMessage());
        }

        $students = $this->getStudent()
            ->whereIn('id', $uniqueStudents)
            ->where('class_id', $this->getStudent()->class_id)
            ->get()
            ->toArray();

        return ['students' => $students, 'relations' => $allFriends];
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
    }

    public function createStudent(int $surveyId, string $name, string $classId, bool $setSession = true): void
    {
       $student = SurveyStudent::firstOrCreate([
            'survey_id' => strip_tags($surveyId),
            'name' => strip_tags($name),
            'class_id' => strip_tags($classId)
        ]);

       if($setSession){
           \Session::put([
               'student-name' => strip_tags($name),
               'survey-student-id' => strip_tags($student->id),
               'survey-student-class-id' =>strip_tags($classId),
               'step2' => true
           ]);
       }
    }

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
            'survey_id' => $this->getStudent()->survey_id,
            'class_id' => $this->getStudent()->class_id,
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
