<?php

namespace Database\Seeders;

use App\Models\SurveyQuestion;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $str = file_get_contents(base_path('database/questions.json'));
        $data = json_decode($str); // decode the JSON into an array
        foreach ($data as $item) {
            $question = new SurveyQuestion();
            $question->id = $item->question_id;
            $question->order = $item->order;
            if (isset($item->enabled)) {
                $question->enabled = $item->enabled;
            }
            if (isset($item->form_type)) {
                $question->form_type = $item->form_type;
            }
            if (isset($item->depends_on_question)) {
                $question->depends_on_question = $item->depends_on_question;
            }
            $question->question_type = $item->question_type;
            $question->question_title = $item->question_title;
            $question->question_content = $item->question_content;
            if (isset($item->question_answer_options)) {
                $question->question_answer_options = $item->question_answer_options;
            }
            if (isset($item->question_options)) {
                $question->question_options = $item->question_options;
            }
            if (isset($item->default_disable_next)) {
                $question->default_disable_next = $item->default_disable_next;
            }
            $question->save();
        }
    }
}
