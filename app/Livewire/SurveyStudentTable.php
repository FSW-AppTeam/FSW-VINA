<?php

namespace App\Livewire;

use App\Models\SurveyStudent;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SurveyStudentTable extends Component
{
    use AuthorizesRequests, WithPagination;

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    public ?array $selected = [];

    //Create, Edit, Delete, View SurveyStudent props
    public ?string $name = null;

    public ?DateTime $finished_at = null;

    public ?DateTime $exported_at = null;

    public ?int $survey_id = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $surveystudent_id = null;

    public ?SurveyStudent $surveystudent = null;

    //Multiple Selection props
    public array $selectedSurveystudents = [];

    public bool $bulkDisabled = true;

    //Update & Store Rules
    protected array $rules =
        [
            'name' => 'string',
            'survey_id' => 'int',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedSurveyStudents = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedSurveyStudents->count().' '.Str::plural('surveystudent', $paginatedSurveyStudents->count()).' found';

        return view('livewire.surveystudent.components.table', compact('paginatedSurveyStudents'));
    }

    //Toggle the $bulkDisabled on or off based on the count of selected posts
    public function updatedselectedSurveyStudents()
    {
        $this->bulkDisabled = count($this->selectedSurveyStudents) < 2;
        $this->surveystudent = null;
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            SurveyStudent::create($validatedData);
        });
        $this->refresh('SurveyStudent successfully created!');
    }

    //Get & assign selected post props
    public function initData(SurveyStudent $surveystudent)
    {
        // assign values to public props
        $this->surveystudent = $surveystudent;
        $this->surveystudent_id = $surveystudent->id;
        $this->name = $surveystudent->name;
        $this->finished_at = $surveystudent->finished_at;
        $this->exported_at = $surveystudent->exported_at;
        $this->survey_id = $surveystudent->survey_id;
        $this->created_at = $surveystudent->created_at;
        $this->updated_at = $surveystudent->updated_at;

        $this->selectedSurveyStudent = [];
    }

    //Get & assign selected category
    public function initDataBulk()
    {

    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->surveystudent->update($validatedData);
        $this->refresh('SurveyStudent successfully updated!');
    }

    //Bulk update
    public function updateBulk()
    {
        $this->validate();
        SurveyStudent::whereIn('id', $this->selectedSurveyStudents)->update([]);
        $this->refresh('SurveyStudent successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->selectedSurveyStudents)) {
            DB::transaction(function () {
                SurveyStudent::destroy($this->selectedSurveyStudents);
            });
        }

        if (! empty($this->surveystudent)) {
            DB::transaction(function () {
                $this->surveystudent->delete();
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

    public function mount()
    {

    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset([
            //            'selectedSurveyStudents',
            'bulkDisabled',
            'surveystudent_id',
            'name',
            'finished_at',
            'exported_at',
            'survey_id',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $surveystudent = new SurveyStudent();

        return empty($query) ? $surveystudent :
            $surveystudent->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
