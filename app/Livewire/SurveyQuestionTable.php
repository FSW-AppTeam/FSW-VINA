<?php

namespace App\Livewire;

use App\Models\SurveyQuestion;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SurveyQuestionTable extends Component
{
    use AuthorizesRequests, WithPagination;

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    public ?array $selected = [];

    //Create, Edit, Delete, View SurveyQuestion props
    public ?int $order = null;

    public ?string $question_type = null;

    public ?string $question_title = null;

    public ?string $question_content = null;

    public ?array $question_answer_options = null;

    public ?array $question_options = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $surveyquestion_id = null;

    public ?SurveyQuestion $surveyquestion = null;

    //Multiple Selection props
    public array $selectedSurveyQuestions = [];

    public bool $bulkDisabled = true;

    //Update & Store Rules
    protected array $rules =
        [
            'order' => 'int',
            'question_type' => 'string',
            'question_title' => 'string',
            'question_content' => 'string',
            'question_answer_options' => 'array',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedSurveyQuestions = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedSurveyQuestions->count().' '.Str::plural('surveyquestion', $paginatedSurveyQuestions->count()).' found';

        return view('livewire.surveyquestion.components.table', compact('paginatedSurveyQuestions'));
    }

    //Toggle the $bulkDisabled on or off based on the count of selected posts
    public function updatedselectedSurveyQuestions()
    {
        $this->bulkDisabled = count($this->selectedSurveyQuestions) < 2;
        $this->surveyquestion = null;
    }

    public function questionAnswerOptions(): Attribute
    {
        $this->question_answer_options = json_decode($this->question_answer_options, true);
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            SurveyQuestion::create($validatedData);
        });
        $this->refresh('SurveyQuestion successfully created!');
    }

    //Get & assign selected post props
    public function initData(SurveyQuestion $surveyquestion)
    {
        // assign values to public props
        $this->surveyquestion = $surveyquestion;
        $this->surveyquestion_id = $surveyquestion->id;
        $this->order = $surveyquestion->order;
        $this->question_type = $surveyquestion->question_type;
        $this->question_title = $surveyquestion->question_title;
        $this->question_content = $surveyquestion->question_content;
        if (is_array($surveyquestion->question_answer_options)) {
            $this->question_answer_options = $surveyquestion->question_answer_options;
        }
        if (is_string($surveyquestion->question_answer_options)) {
            $this->question_answer_options = json_decode($surveyquestion->question_answer_options);
        }
        if (is_array($surveyquestion->question_options)) {
            $this->question_options = $surveyquestion->question_options;
        }

        if (is_string($surveyquestion->question_options)) {
            $this->question_options = json_decode($surveyquestion->question_options);
        }
        $this->created_at = $surveyquestion->created_at;
        $this->updated_at = $surveyquestion->updated_at;

        $this->selectedSurveyQuestion = [];
    }

    //Get & assign selected category
    public function initDataBulk() {}

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $this->surveyquestion->update($validatedData);
        $this->refresh('SurveyQuestion successfully updated!');
    }

    //Bulk update
    public function updateBulk()
    {
        $this->validate();
        SurveyQuestion::whereIn('id', $this->selectedSurveyQuestions)->update([]);
        $this->refresh('SurveyQuestion successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->selectedSurveyQuestions)) {
            DB::transaction(function () {
                SurveyQuestion::destroy($this->selectedSurveyQuestions);
            });
        }

        if (! empty($this->surveyquestion)) {
            DB::transaction(function () {
                $this->surveyquestion->delete();
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
        $this->reset(['selectedSurveyQuestions', 'bulkDisabled',
            'surveyquestion_id',
            'order',
            'question_type',
            'question_title',
            'question_content',
            'question_answer_options',
            'question_options',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $surveyquestion = new SurveyQuestion;

        return empty($query) ? $surveyquestion :
            $surveyquestion->where(function ($q) use ($query) {
                $q->where('order', 'like', '%'.$query.'%')
                    ->orWhere('question_type', 'like', '%'.$query.'%')
                    ->orWhere('question_title', 'like', '%'.$query.'%')
                    ->orWhere('question_content', 'like', '%'.$query.'%')
                    ->orWhere('question_answer_options', 'like', '%'.$query.'%')
                    ->orWhere('question_options', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }

    public function toggleEnable($row)
    {
        $model = SurveyQuestion::find($row['id']);
        $model->update(['enabled' => ! $model->enabled]);
    }
}
