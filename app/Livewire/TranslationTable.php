<?php

namespace App\Livewire;

use App\Models\Translation;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class TranslationTable extends Component
{
    use AuthorizesRequests, WithPagination;

    // DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    public ?array $selected = [];

    public ?string $slug = null;

    public ?string $en = null;

    public ?string $nl = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $translation_id = null;

    public ?Translation $translation = null;

    // Update & Store Rules
    protected array $rules =
        [
            'slug' => 'string',
            'en' => 'string',
            'nl' => 'string',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedTranslations = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        // results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedTranslations->count().' '.Str::plural('surveyquestion', $paginatedTranslations->count()).' found';

        return view('livewire.translation.components.table', compact('paginatedTranslations'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            Translation::create($validatedData);
        });
        $this->refresh('Translation successfully created!');
    }

    // Get & assign selected post props
    public function initData(Translation $translation)
    {
        // assign values to public props
        $this->translation = $translation;
        $this->translation_id = $translation->id;
        $this->slug = $translation->slug;
        $this->en = $translation->en;
        $this->nl = $translation->nl;

        $this->created_at = $translation->created_at;
        $this->updated_at = $translation->updated_at;
    }

    // Get & assign selected category
    public function initDataBulk() {}

    public function update()
    {
        $validatedData = $this->validate($this->rules);
        $this->translation->update($validatedData);
        $this->refresh('Translation successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->translation)) {
            DB::transaction(function () {
                $this->translation->delete();
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
            'translation_id',
            'slug',
            'en',
            'nl',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $translations = new Translation;

        return empty($query) ? $translations :
            $translations->where(function ($q) use ($query) {
                $q->where('slug', 'like', '%'.$query.'%')
                    ->orWhere('nl', 'like', '%'.$query.'%')
                    ->orWhere('en', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }

    public function extract()
    {
        $translations = $this->extractTranslations();

        foreach ($translations as $key => $slug) {
            Translation::firstOrCreate(['slug' => $slug], ['nl' => $key, 'en' => $key]);
        }

        $this->refresh(langDatabase('translation.messages_extract_success'));
    }

    private function extractTranslations(): array
    {
        $directory = new RecursiveDirectoryIterator(resource_path('views'));
        $files = new RecursiveIteratorIterator($directory);

        $allFoundTranslations = [];

        foreach ($files as $file) {
            if ($file->isDir() || ! str_ends_with($file->getPathname(), '.blade.php')) {
                continue;
            }
            $this->extractFromCode($file, $allFoundTranslations);
        }

        $directory = new RecursiveDirectoryIterator(app_path('Http/Controllers'));
        $files = new RecursiveIteratorIterator($directory);

        foreach ($files as $file) {
            if ($file->isDir() || ! str_ends_with($file->getPathname(), '.php')) {
                continue;
            }
            $this->extractFromCode($file, $allFoundTranslations);
        }

        return $allFoundTranslations;
    }

    private function extractFromCode($file, &$allFoundTranslations)
    {
        $fileContent = file_get_contents($file->getPathname());

        $matches = [];
        preg_match_all('/langDatabase\((.*?)\)/', $fileContent, $matches);

        foreach ($matches[1] as $translationStr) {
            $param = [];
            // we ignore any entries which contain a variable
            // and only allow entries with a dot
            if (strpos($translationStr, '.') !== false) {
                $translationStr = explode(',', $translationStr);
                if (isset($translationStr[1])) {
                    $params = explode(',', $translationStr[1]);

                    if (isset($params[0])) {
                        preg_match('/\[\'(.*?)\'/', $params[0], $param);
                    }
                }

                $translationStr = rtrim($translationStr[0], "'");
                $translationStr = ltrim($translationStr, "'");
                $parts = explode('.', $translationStr);
                array_shift($parts);

                if (count($parts) === 1) {
                    $key = current($parts);
                    if (isset($param[1])) {
                        $key = current($parts).' :'.$param[1];
                    }
                    $allFoundTranslations[$key] = $translationStr;
                }
            }
        }
    }

    public function updateSeeder()
    {
        Artisan::call('iseed', [
            'tables' => 'translations',
            '--exclude' => 'id,created_at,updated_at,deleted_at',
            '--force' => true,
        ]);

        Artisan::call('config:push');
        $this->refresh(langDatabase('translation.messages_extract_success'));
    }

    public function importSeeder()
    {
        Artisan::call('db:seed --class=TranslationsTableSeeder');

        $this->refresh(langDatabase('translation.messages_import_seeder_success'));
    }
}
