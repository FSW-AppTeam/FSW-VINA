<?php

namespace Tests\Browser;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyStudent;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HappyFlowTest extends DuskTestCase
{
    public $survey;
    public $student;
    public $browser;

    public function setUp(): void
    {
        parent::setUp();
        $this->survey = Survey::skip(1)->first();

        $user = User::where('role_id', 2)->first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);
        });
        // In step 1 and 2 session variable are set. The issue is that Dusk cannot access the session variables.
        // So we need to set the session variables by always run step 1 and 2 before running the other tests.
        $this->step1();
        $this->step2();
    }

    public function step1(): void
    {
        $question = SurveyQuestion::where('enabled', true)
            ->where('order', 1)->first();

        $this->browse(function (Browser $browser) use ($question) {
            $browser->visit('/step/1')
                ->assertSee($question->question_content)
                ->typeSlowly('#surveyCode', $this->survey->survey_code)
                ->pause(1000)
                ->pressAndWaitFor('@next')
                ->pause(1000)
                ->assertSee($question->nextQuestion()->question_content);
        });
    }

    public function step2(): void
    {
        $question = SurveyQuestion::where('enabled', true)
            ->where('order', 2)->first();

        $this->browse(function (Browser $browser) use ($question) {
            $browser->visit('/step/2')
                ->assertSee($question->question_content)
                ->typeSlowly('#student-name', 'John Doe the dusk tester')
                ->pause(1000)
                ->pressAndWaitFor('@next')
                ->pause(1000)
                ->assertSee($question->nextQuestion()->question_content);
        });
        $this->assertDatabaseHas('survey_students', [
            'name' => 'John Doe the dusk tester',
            'survey_id' => $this->survey->id,
        ]);
        $this->student = SurveyStudent::where('name', 'John Doe the dusk tester')
            ->where('survey_id', $this->survey->id)->first();

    }

    public function testFormStep3(): void
    {
        $question = SurveyQuestion::where('order', 3)
            ->where('enabled', true)->first();

        $this->browse(function (Browser $browser) use ($question) {
            $browser->visit('/step/'.$question->order)
                ->pause(1000)
                ->assertSee($question->question_content)
                ->pause(1000)
                ->typeSlowly('#age', 44)
                ->pause(1000)
                ->pressAndWaitFor('@next')
                ->pause(1000)
                ->assertSee($question->nextQuestion()->question_content);
        });

        $this->assertDatabaseHas('survey_answers', [
            'student_id' => $this->student->id,
            'question_id' => $question->id,
            'student_answer' => '44',
        ]);
    }

    public function testFormStep4(): void
    {
        $question = SurveyQuestion::where('order', 4)
            ->where('enabled', true)->first();
        $this->formTypeSelect($question);
    }

    public function testFormStep5(): void
    {
        $question = SurveyQuestion::where('order', 5)
            ->where('enabled', true)->first();
        $this->formTypeSelect($question);
    }

    public function testFormStep6(): void
    {
        $question = SurveyQuestion::where('order', 6)
            ->where('enabled', true)->first();

        $this->formTypeSelect($question);
    }

    private function formTypeSelect($question)
    {
        $this->browse(function (Browser $browser) use ($question) {
            $browser->visit('/step/'.$question->order)
                ->pause(1000)
                ->assertSee($question->question_content)
                ->pause(1000)
                ->pressAndWaitFor('@select-answer-2')
                ->pause(1000)
                ->pressAndWaitFor('@next')
                ->pause(1000)
                ->assertSee($question->nextQuestion()->question_content);
        });

        $this->assertDatabaseHas('survey_answers', [
            'student_id' => $this->student->id,
            'question_id' => $question->id,
            'student_answer' => '2',
        ]);
    }
}
