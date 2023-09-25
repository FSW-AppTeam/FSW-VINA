<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class FlagImage extends Component
{
    public $showFlag = true;

    public int $id;

    public string $country;

    public string $image;

    public array $flagsSelected;

    protected $listeners = [
        'set-show-flag-true' => 'setShowFlagTrue',
        'set-flag-from-js' => 'setFlagFromJs',
    ];

    public function setShowFlagTrue(int $id): void
    {
        if($id === $this->id){
            $this->showFlag = true;
        }
    }

    public function setFlag(int $id): void
    {
        if((count($this->flagsSelected) <= 3)) {
            if ($id !== 6) {
                $this->showFlag = false;
                $this->dispatch('set-selected-flag-id', $id, $this->image, $this->country);
            }

            if ($id === 6) { // open modal
                $this->dispatch('set-modal-flag');
            }
        }
    }

    public function setFlagFromJs(string $country): void
    {
        if($this->id === 6){
            $this->dispatch('set-selected-flag-id', 6, 'anders', $country);
        }
    }

    public function removeFlag(int $id): void
    {
        $this->showFlag = true;
        $this->dispatch('remove-selected-flag-id', $id, $this->image);
    }

    public function mount()
    {
//        dump('flagimage mount before id = ' . $this->id);
//        dump('showFlag mount before = ' . $this->showFlag);

        if(($this->id !== 6) && in_array($this->id, array_column($this->flagsSelected, 'id'))){
                $this->showFlag = !$this->showFlag;
        }
    }

    public function render()
    {
        return view('livewire.partials.flag-image');
    }
}
