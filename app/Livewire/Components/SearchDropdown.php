<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SearchDropdown extends Component
{
    public $searchResults;

    public $search = '';

    public $selectedCountry;

    public string $targetComponent = 'forms.form-step7';

    public function mount(?string $targetComponent = null)
    {
        $this->searchResults = getCountriesByIso();

        if ($targetComponent) {
            $this->targetComponent = $targetComponent;
        }
    }

    public function updatedSelectedCountry($value): void
    {
        if (empty($value)) {
            return;
        }

        $country = $value;
        $this->selectedCountry = null;
        $this->dispatch('set-country', $country)->component($this->targetComponent);
    }

    public function render()
    {
        if (strlen($this->search) >= 1) {
            $search_text = $this->search;
            $countries = getCountriesByIso();

            $this->searchResults = array_filter($countries, function ($el) use ($search_text) {
                return str_contains(strtolower($el[1]), strtolower($search_text));
            });
        }

        // if ($this->selectedCountry) {
        //     $country = $this->selectedCountry;
        //     $this->selectedCountry = null;
        //     $this->dispatch('set-country', $country)->component($this->targetComponent);
        // }

        return view('livewire.components.search-dropdown');
    }
}
