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

    public function moveUp($data)
    {
        $newOrder = $this->order - 1;
        if (! $this->checkDependency($newOrder)) {
            $this->dispatch('error', 'Cannot move question up due to dependency constraints.');

            return;
        }
        $this->switchOrder($newOrder);
        $this->dispatch('created', 'Order updated successfully!');

    }

    public function moveDown($id)
    {
        $newOrder = $this->order + 1;

        if (! $this->checkDependency($newOrder)) {
            $this->dispatch('error', 'Cannot move question up due to dependency constraints.');

            return;
        }
        $this->switchOrder($newOrder);
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

    public function checkDependency($newOrder)
    {
        $replaceModel = SurveyQuestion::where('order', $newOrder);
        if ($this->model->depends_on_question == null) {
            return true;
        }

        if (! $replaceModel->exists()) {
            return true;
        }

        if ($this->model->depends_on_question != $replaceModel->first()->id) {
            return false;
        }

        if ($this->model->id != $replaceModel->first()->depends_on_question) {
            return false;
        }

        return true;
    }

    public function switchOrder($newOrder)
    {
        $replaceModel = SurveyQuestion::where('order', $newOrder);
        if ($replaceModel->exists()) {
            $replaceModel->first()->update(['order' => $this->model->order]);
        }
        $this->model->order = $newOrder;
        $this->model->save();
    }
}
