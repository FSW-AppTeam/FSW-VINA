<?php

namespace App\Livewire\Forms;

use App\Models\Survey;
use App\Models\SurveyFriend;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Features\SupportValidation\HandlesValidation;
use Livewire\Form;

class PostForm extends Form
{
    use HandlesValidation;

    public ?SurveyAnswer $answers;

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

    
    public function getSelectablesForQuestion(?SurveyQuestion $question): array
    {   
        
        if (! $question) {
            return $this->getSurvey()->usesFriends()
                ? $this->getStudent()->friends()->orderBy('position')->get()->toArray()
                : $this->getStudentsWithoutActiveStudent();
        }

        if ($this->getSurvey()->usesFriends() && in_array($question->id, [38, 49, 39])) {
            return $this->getFriendsForQuestion49();
        }

        if (! $this->getSurvey()->usesFriends() && $question->id == 49) {
            return $this->getStudentsFotQuestion49($question->depends_on_question);
        }

        if ($question->depends_on_question) {
            return $this->getSurvey()->usesFriends()
                ? $this->getFriendsOtherEthnicity()
                : $this->getStudentsOtherEthnicityWithResponse($question->depends_on_question);
        }

        return $this->getSurvey()->usesFriends()
            ? $this->getStudent()->friends()->orderBy('position')->get()->toArray()
            : $this->getStudentsWithoutActiveStudent();
    }

    #[Computed(persist: true)]
    public function getStudentsOtherEthnicityWithResponse($questionId): array
    {
        return SurveyStudent::where('survey_id', $this->getSurvey()->id)
            ->where('survey_students.id', '!=', $this->getStudent()->id)
            ->where('survey_answers.student_answer->country_id', '!=', 1)
            ->where('survey_answers.student_answer->country_id', '!=', 7)
            ->where('survey_answers.student_answer->country_id', '!=', null)
            ->where('question_id', $questionId)
            ->join('survey_answers', 'survey_answers.student_id', '=', 'survey_students.id')
            ->select('survey_students.*')
            ->get()
            ->toArray();
    }
    public function getFriendsOtherEthnicity(): array
    {
        return $this->getStudent()
            ->friends()
            ->whereNotIn('country_id', [1, 7])
            ->whereNotNull('country_id')
            ->orderBy('position')
            ->get()
            ->toArray();
    }

    public function getStudentsFotQuestion49($questionId): array
    {
        $selected = SurveyAnswer::where('student_id', $this->getStudent()->id)
            ->where('question_id', '=', 48);
        if (! $selected->exists()) {
            return [];
        }
        $selectedStudents = $selected->get('student_answer')->first()->student_answer;

        $students = SurveyStudent::where('survey_id', $this->getSurvey()->id)
            ->select('survey_students.*')
            ->where('survey_students.id', '!=', $this->getStudent()->id)
            ->whereIn('survey_students.id', $selectedStudents)
            ->where(function ($query) {
                $query->where('survey_answers.student_answer->country_id', '=', 1)
                    ->orWhere('survey_answers.student_answer->country_id', '=', 7)
                    ->orWhere('survey_answers.student_answer->country_id', '=', null);
            })
            ->where('question_id', $questionId)
            ->join('survey_answers', 'survey_students.id', '=', 'survey_answers.student_id')
            ->get()
            ->toArray();

        // These students did not awnser the dependent question. So they are included.
        $studentsLate = SurveyStudent::where('survey_id', $this->getSurvey()->id)
            ->select('survey_students.*')
            ->where('survey_students.id', '!=', $this->getStudent()->id)
            ->whereIn('survey_students.id', $selectedStudents)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('survey_answers')
                    ->whereRaw('survey_students.id = survey_answers.student_id');
            })
            ->get()
            ->toArray();

        return array_merge($students, $studentsLate);
    }
    public function getFriendsForQuestion49(): array
    {
        $selected = SurveyAnswer::where('student_id', $this->getStudent()->id)
            ->where('question_id', '=', 48);
        if (! $selected->exists()) {
            return [];
        }

        $selectedFriends =  $selected->get('student_answer')->first()->student_answer;

        return SurveyFriend::where('owner_student_id', $this->getStudent()->id)
            ->whereIn('id', $selectedFriends)
            ->orderBy('position')
            ->get()
            ->toArray();
    }

    //    public function getStudentsNotInFriendsSelected(): array
    //    {
    //        $answers = SurveyAnswer::where('student_id', $this->getStudent()->id)
    //            ->where('question_id', '=', 10)
    //            ->get('student_answer')->first()->student_answer;
    //
    //        return $this->getStudent()
    //            ->whereNot('id', $this->getStudent()->id)
    //            ->whereNotIn('id', $answers)
    //            ->where('survey_id', '=', $this->getSurvey()->id)
    //            ->get()
    //            ->toArray();
    //    }
    //
    //    public function getStudentsFriendsRelationsSelected(): array
    //    {
    //        $answers = SurveyAnswer::where('survey_answers.student_id', $this->getStudent()->id)
    //            ->where('survey_answers.question_id', 12) // friends of friends
    //            ->join('survey_students', 'survey_answers.student_id', '=', 'survey_students.id')
    //            ->where('survey_students.survey_id', '=', $this->getSurvey()->id)
    //            ->get(['survey_answers.student_answer'])
    //            ->toArray();
    //
    //        $allFriends = [];
    //        // flat student array for import
    //        foreach ($answers as $answer) {
    //            if (isset($answer['student_answer']['value'])) {
    //                foreach ($answer['student_answer']['value'] as $selectedFriend) {
    //                    $allFriends[] = ['id' => $answer['student_answer']['student_id'], 'relation_id' => $selectedFriend];
    //                }
    //            }
    //        }
    //
    //        $uniqueStudents = [];
    //
    //        try {
    //            $uniqueStudents = array_unique(
    //                array_merge(array_column($allFriends, 'id'), array_column($allFriends, 'relation_id'))
    //            );
    //        } catch (\Exception $e) {
    //            dd($e->getMessage(), $allFriends);
    //        }
    //
    //        $students = $this->getStudent()
    //            ->whereIn('id', $uniqueStudents)
    //            ->where('survey_id', $this->getSurvey()->id)
    //            ->get()
    //            ->toArray();
    //
    //        return ['students' => $students, 'relations' => $allFriends];
    //    }

    public function createAnswer($answer, SurveyQuestion $jsonQuestions, int $stepId): void
    {
        $surveyAnswer = SurveyAnswer::updateOrCreate(
            [
                'student_id' => $this->getStudent()->id,
                'question_id' => $jsonQuestions->id,
                'question_title' => $jsonQuestions->question_title,
            ],
            [
                'student_answer' => $answer,
                'question_type' => $jsonQuestions->question_type,
            ]
        );
        if (data_get($jsonQuestions, 'question_options.friend_source')) {
            $this->getStudent()->syncFriends($surveyAnswer->student_answer);
        }

        session::put([
            "step$stepId" => true,
        ]);
    }

    public function createJsonAnswer($answer, SurveyQuestion $jsonQuestions, int $stepId): void
    {
        SurveyAnswer::updateOrCreate(
            [
                'student_id' => $this->getStudent()->id,
                'question_id' => $jsonQuestions->id,
                'question_title' => $jsonQuestions->question_title,
            ],
            [
                'student_answer' => $answer,
                'question_type' => $jsonQuestions->question_type,
            ]
        );

        if (data_get($jsonQuestions, 'question_options.friend_source')) {
            $this->getStudent()->syncFriends($surveyAnswer->student_answer);
        }

        session::put([
            "step$stepId" => true,
        ]);
    }

    public function createStudent(string $name, string $surveyId, bool $setSession = true): void
    {
        $student = SurveyStudent::firstOrCreate([
            'name' => strip_tags($name),
            'survey_id' => strip_tags($surveyId),
            'uuid' => \Illuminate\Support\Str::uuid(),
        ]);

        if ($setSession) {
            session::put([
                'student-name' => strip_tags($name),
                'student-id' => strip_tags($student->id),
                'survey-id' => strip_tags($surveyId),
            ]);
        }
    }

    public function update()
    {
        $this->answers->update(
            $this->all()
        );
    }
}
