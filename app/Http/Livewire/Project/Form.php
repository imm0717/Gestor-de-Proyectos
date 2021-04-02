<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    public $form = [
        'id' => '',
        'name' => '',
        'description' => '',
        'start_date' => '',
        'end_date' => '',
    ];

    protected $listeners = [
        'editProject' => 'editProjectHandler'
    ];

    public function editProjectHandler($data)
    {
        $this->form = array_merge($this->form, $data);
    }

    public function submit()
    {
        $this->validate([
            'form.name' => 'string|max:256',
            'form.start_date' => 'required|date',
            'form.end_date' => 'required|date'
        ]);

        if ($this->form['id'] == '') {
            $this->form['created_by_id'] = Auth::id();
            Project::create($this->form);
            $this->emit('newProject');
        } else {
            Project::find($this->form['id'])->update($this->form);
            $this->emit('projectChange');
        }
    }

    public function render()
    {
        return view('livewire.project.form');
    }
}
