<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Download extends Component
{
    public $file = null;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.partials.download');
    }


    public function download()
    {
        return Storage::disk()->download($this->file);
    }
}
