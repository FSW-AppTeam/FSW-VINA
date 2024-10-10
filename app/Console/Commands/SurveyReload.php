<?php

namespace App\Console\Commands;

use App\Models\SurveyQuestion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SurveyReload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:reload';

    /**
     * @var string
     */
    protected $description = 'Reload questions from the questions.json file!';

    /**
     * Execute the console command.
     */
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Reload survey questions');

        $str = file_get_contents(base_path('database/questions.json'));
        $data = json_decode($str); // decode the JSON into an array
        foreach ($data as $item) {
            $question = SurveyQuestion::find($item->question_id);
            $question->order = $item->order;
            $question->enabled = true;
            if (isset($item->enabled)) {
                $question->enabled = $item->enabled;
            }
            $question->form_type = null;
            if (isset($item->form_type)) {
                $question->form_type = $item->form_type;
            }
            $question->depends_on_question = null;
            if (isset($item->depends_on_question)) {
                $question->depends_on_question = $item->depends_on_question;
            }
            $question->question_type = $item->question_type;
            $question->question_title = $item->question_title;
            $question->question_content = $item->question_content;
            $question->question_answer_options = null;
            if (isset($item->question_answer_options)) {
                $question->question_answer_options = $item->question_answer_options;
            }
            $question->question_options = null;
            if (isset($item->question_options)) {
                $question->question_options = $item->question_options;
            }
            $question->default_disable_next = false;
            if (isset($item->default_disable_next)) {
                $question->default_disable_next = $item->default_disable_next;
            }
            $question->save();
        }

    }
}
