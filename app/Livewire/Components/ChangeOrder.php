<?php

namespace App\Livewire\Components;

use App\Models\SurveyQuestion;
use Livewire\Component;

class ChangeOrder extends Component
{
    public $model;

    public $id;

    public $order;

    protected $listeners = [
    ];

    public function moveUp($id)
    {
        dd($model);

        $newOrder = $this->order + 1;
        $this->switchOrder($model, $newOrder);
        $this->dispatch('created', 'Order updated successfully!');

    }

    public function moveDown($id)
    {
        $newOrder = $this->order - 1;
        $this->switchOrder($model, $newOrder);
        $this->dispatch('created', 'Order updated successfully!');
    }

    public function mount($model)
    {
        $this->model = $model;
        $this->id = $model->id;
        $this->order = $model->order;
    }

    public function render()
    {
        return view('livewire.components.change-order');
    }


    public function switchOrder($model, $newOrder)
    {
        $replaceModel = SurveyQuestion::where('order', $newOrder);
        if ($replaceModel->exists()) {
            $replaceModel->first()->update(['order' => $model->order]);
        }
        $model->order = $newOrder;
        $model->save();
    }
}
