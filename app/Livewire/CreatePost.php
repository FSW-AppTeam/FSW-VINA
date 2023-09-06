<?php

namespace App\Livewire;

use App\Livewire\Forms\PostForm;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreatePost extends Component
{
    public PostForm $form;

    // form step 1

    public $classCode;

    public function save()
    {
        $this->validate();

        $this->form->store();
        $this->form->createAnswer(2);

        dump('saved! create post');
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
