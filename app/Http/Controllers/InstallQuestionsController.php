<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyFriend;
use App\Models\SurveyQuestion;
use App\Models\SurveyStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InstallQuestionsController extends Controller
{
    public function index()
    {
        $options = [
            'default' => 'Default (NL)',
            'en' => 'English',
        ];
        $surveys = Survey::orderBy('survey_code')->get();

        return view('install', compact('options', 'surveys'));
    }

    public function deleteSurvey(Request $request)
    {
        $surveyIds = Survey::pluck('id')->map(static fn ($id) => (string) $id);
        $validated = $request->validate([
            'survey_id' => ['required', Rule::in([...$surveyIds->all(), 'all'])],
        ]);

        $deleteAll = $validated['survey_id'] === 'all';
        $surveyIdsToDelete = $deleteAll ? $surveyIds : collect([(int) $validated['survey_id']]);

        DB::transaction(function () use ($surveyIdsToDelete) {
            $studentIds = SurveyStudent::whereIn('survey_id', $surveyIdsToDelete)
                ->pluck('id')
                ->map(static fn ($id) => (string) $id);

            SurveyAnswer::whereIn('student_id', $studentIds)->delete();
            SurveyFriend::whereIn('survey_id', $surveyIdsToDelete)->delete();
            SurveyStudent::whereIn('survey_id', $surveyIdsToDelete)->delete();
            Survey::whereIn('id', $surveyIdsToDelete)->delete();
        });

        $message = $deleteAll
            ? 'All surveys and their data deleted.'
            : 'Survey and its data deleted.';

        return redirect('/install-questions')->with('status', $message);
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
