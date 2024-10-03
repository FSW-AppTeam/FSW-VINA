<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SearchDropdown extends Component
{
    public $searchResults;

    public $search = '';

    public $selectedCountry;

    public function mount()
    {
        $this->searchResults = getCountriesByIso();
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

        if ($this->selectedCountry) {
            $this->dispatch('set-country', $this->selectedCountry)->component('forms.form-step7');
        }

        return view('livewire.components.search-dropdown');
    }
}
