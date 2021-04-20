<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class DeleteModal extends Component
{
    public $modalId;
    
    public function render()
    {
        return view('livewire.partials.delete-modal', [
            'title' => __('view.partials.delete-modal.title'),
            'message' => __('view.partials.delete-modal.body')
        ]);
    }
}
