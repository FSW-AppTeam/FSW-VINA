<?php

namespace App\Livewire;

use App\Models\SurveyAnswers;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SurveyAnswersTable extends Component
{
    use AuthorizesRequests, WithPagination;

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    public ?array $selected = [];

    //Create, Edit, Delete, View SurveyAnswers props
    public ?string $student_id = null;

    public ?integer $question_id = null;

    public ?string $question_type = null;

    public ?string $question_title = null;

    public ?json $student_answer = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $surveyanswers_id = null;

    public ?SurveyAnswers $surveyanswers = null;

    //Multiple Selection props
    public array $selectedSurveyAnswerss = [];

    public bool $bulkDisabled = true;

    //Update & Store Rules
    protected array $rules =
        [
            'student_id' => 'int',
            'question_id' => 'int',
            'question_type' => 'string',
            'question_title' => 'string',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedSurveyAnswerss = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedSurveyAnswerss->count().' '.Str::plural('surveyanswers', $paginatedSurveyAnswerss->count()).' found';

        return view('livewire.surveyanswers.components.table', compact('paginatedSurveyAnswerss'));
    }

    //Toggle the $bulkDisabled on or off based on the count of selected posts
    public function updatedselectedSurveyAnswerss()
    {
        $this->bulkDisabled = count($this->selectedSurveyAnswerss) < 2;
        $this->surveyanswers = null;
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            SurveyAnswers::create($validatedData);
        });
        $this->refresh('SurveyAnswers successfully created!');
    }

    //Get & assign selected post props
    public function initData(SurveyAnswers $surveyanswers)
    {
        // assign values to public props
        $this->surveyanswers = $surveyanswers;
        $this->surveyanswers_id = $surveyanswers->id;
        $this->student_id = $surveyanswers->student_id;
        $this->question_id = $surveyanswers->question_id;
        $this->question_type = $surveyanswers->question_type;
        $this->question_title = $surveyanswers->question_title;
        $this->student_answer = $surveyanswers->student_answer;
        $this->created_at = $surveyanswers->created_at;
        $this->updated_at = $surveyanswers->updated_at;

        $this->selectedSurveyAnswers = [];
    }

    //Get & assign selected category
    public function initDataBulk()
    {

    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->surveyanswers->update($validatedData);
        $this->refresh('SurveyAnswers successfully updated!');
    }

    //Bulk update
    public function updateBulk()
    {
        $this->validate();
        SurveyAnswers::whereIn('id', $this->selectedSurveyAnswerss)->update([]);
        $this->refresh('SurveyAnswers successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->selectedSurveyAnswerss)) {
            DB::transaction(function () {
                SurveyAnswers::destroy($this->selectedSurveyAnswerss);
            });
        }

        if (! empty($this->surveyanswers)) {
            DB::transaction(function () {
                $this->surveyanswers->delete();
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
        $this->reset(['selectedSurveyanswerss', 'bulkDisabled',
            'surveyanswers_id',
            'student_id',
            'question_id',
            'question_type',
            'question_title',
            'student_answer',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $surveyanswers = new SurveyAnswers();

        return empty($query) ? $surveyanswers :
            $surveyanswers->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
