<?php

namespace App\Livewire;

use App\Models\Survey;
use App\Models\SurveyExport;
use App\Models\SurveyStudent;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SurveyTable extends Component
{
    use AuthorizesRequests, WithPagination;

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    public ?array $selected = [];

    //Create, Edit, Delete, View Survey props
    public ?string $survey_code = null;

    public ?string $qualtrics_name = null;

    public ?string $qualtrics_id = null;

    public ?string $qualtrics_param = null;

    public ?DateTime $started_at = null;

    public ?DateTime $finished_at = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $survey_id = null;

    public ?Survey $survey = null;

    //Multiple Selection props
    public array $selectedSurveys = [];

    public bool $bulkDisabled = true;

    //Update & Store Rules
    protected array $rules =
        [
            'survey_code' => 'string',
            'qualtrics_name' => 'string',
            'qualtrics_id' => 'string',
            'qualtrics_param' => 'string',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedSurveys = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedSurveys->count().' '.Str::plural('survey', $paginatedSurveys->count()).' found';

        return view('livewire.survey.components.table', compact('paginatedSurveys'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            Survey::create($validatedData);
        });
        $this->refresh('Survey successfully created!');
    }

    //Get & assign selected post props
    public function initData(Survey $survey)
    {
        // assign values to public props
        $this->survey = $survey;
        $this->survey_id = $survey->id;
        $this->survey_code = $survey->survey_code;
        $this->qualtrics_name = $survey->qualtrics_name;
        $this->qualtrics_id = $survey->qualtrics_id;
        $this->qualtrics_param = $survey->qualtrics_param;
        $this->started_at = $survey->started_at;
        $this->finished_at = $survey->finished_at;
        $this->created_at = $survey->created_at;
        $this->updated_at = $survey->updated_at;

        $this->selectedSurvey = [];
    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->survey->update($validatedData);
        $this->refresh('Survey successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->selectedSurveys)) {
            DB::transaction(function () {
                Survey::destroy($this->selectedSurveys);
            });
        }

        if (! empty($this->survey)) {
            DB::transaction(function () {
                foreach ($this->survey->surveyStudents as $student){
                    $student->delete();
                }
                $this->survey->delete();
            });
        }
        $this->refresh('Successfully deleted!');
    }

    public function refresh($message)
    {
        session()->flash('message', $message);
        $this->clearFields();

        //Close the active modal
        $this->dispatch('hideModal');
    }

    public function mount() {}

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset(['selectedSurveys', 'bulkDisabled',
            'survey_id',
            'survey_code',
            'qualtrics_name',
            'qualtrics_id',
            'qualtrics_param',
            'started_at',
            'finished_at',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $survey = new Survey;

        return empty($query) ? $survey :
            $survey->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function checkSurvey($surveyId)
    {
        $surveyExport = new SurveyExport;
        try {
            $count = $surveyExport->checkExportCsv($surveyId);
            if ($count > 0) {
                $this->refresh('Succesfully generated '.$count.' CSV files!');
            } else {
                session()->flash('error', 'No new CSV files generated!');
            }
        } catch (\Exception $exception) {
            session()->flash('error', 'Ooops... Something went wrong with the CSV export job: '.$exception);
        }

    }

    public function deleteStudentNames($surveyId)
    {
        SurveyStudent::where('survey_id', $surveyId)
            ->update([
                'name' => null,
            ]);
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
