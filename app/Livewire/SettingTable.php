<?php

namespace App\Livewire;

use App\Models\Setting;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class SettingTable extends Component
{
    use AuthorizesRequests, WithPagination;

    // DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    public ?string $key = null;

    public ?string $value = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $setting_id = null;

    public ?Setting $setting = null;

    // Update & Store Rules
    protected array $rules =
        [
            'key' => 'string',
            'value' => 'string',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedSettings = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        // results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedSettings->count().' '.Str::plural('setting ', $paginatedSettings->count()).' found';

        return view('livewire.settings.components.table', compact('paginatedSettings'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            Setting::create($validatedData);
        });
        $this->refresh('Setting successfully created!');
    }

    // Get & assign selected post props
    public function initData(Setting $setting)
    {
        // assign values to public props
        $this->setting = $setting;
        $this->setting_id = $setting->id;
        $this->key = $setting->key;
        $this->value = $setting->value;
        $this->created_at = $setting->created_at;
        $this->updated_at = $setting->updated_at;
    }

    // Get & assign selected category
    public function initDataBulk() {}

    public function update()
    {
        $validatedData = $this->validate($this->rules);
        $this->setting->update($validatedData);
        $this->refresh('Setting successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->setting)) {
            DB::transaction(function () {
                $this->setting->delete();
            });
        }
        $this->refresh('Successfully deleted!');
    }

    public function refresh($message)
    {
        session()->flash('message', $message);
        $this->clearFields();

        // Close the active modal
        $this->dispatch('hideModal');
    }

    public function mount() {}

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset([
            'setting_id',
            'key',
            'value',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more svaluese the model file.
     **/
    public function search($query)
    {
        $settings = new Setting;

        return empty($query) ? $settings :
            $settings->where(function ($q) use ($query) {
                $q->where('key', 'like', '%'.$query.'%')
                    ->orWhere('value', 'like', '%'.$query.'%');
            });
    }
}
