<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class InstallQuestionsController extends Controller
{
    public function index()
    {
        $options = [
            'default' => 'Default (NL)',
            'en' => 'English',
        ];

        return view('install', compact('options'));
    }

    public function install(Request $request)
    {
        $surveys = Survey::all();

        try {
            foreach ($surveys as $survey) {
                if ($survey->surveyStudents) {
                    return redirect()->back()->with('error', 'translation.students_exist');
                }
                $survey->delete();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $questions = SurveyQuestion::all();
        try {
            foreach ($questions as $question) {
                $question->delete();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $questionsSet = $request->get('questionsSet', 'default');

        Artisan::call('survey:load',
            [
                'questionsSet' => $questionsSet,
            ]
        );

        return redirect('surveyquestiontable');

    }
}
