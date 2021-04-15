<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;
use Livewire\WithFileUploads;

class Attachment extends Component
{
    use WithFileUploads;

    public $photo;

    public function render()
    {
        return view('livewire.partials.attachment');
    }

    public function save(){

        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        dd($this->photo);
    }
}
