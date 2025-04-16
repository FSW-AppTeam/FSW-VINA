<?php

namespace App\Livewire;

use App\Models\SurveyQuestion;
use App\Models\Translation;
use Livewire\Component;

class TranslationDetails extends Component
{
    public ?Translation $translation = null;

    public function render()
    {
        return view('livewire.translation.components.details', $this->translation);
    }

    //Get & assign selected post props
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

    public function mount(Translation $translation)
    {
        $this->translation = $translation;
    }

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
}
