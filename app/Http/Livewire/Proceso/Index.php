<?php

namespace App\Http\Livewire\Proceso;

use App\Models\Proceso;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class Index extends Component
{

    use WithPagination;
    use WithLogs;

    private $itemsPerPage = 10;
    public $process = null;
    public $data = [];
    public $deleteModalId = "processDeleteModal";
    
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'data.en.name' => 'required|string|max:50',
        'data.en.description' => 'required|string|max:256',
        'process.created_by_id' => 'required',
        'process.parent_id' => 'nullable'
    ];

    protected $validationAttributes = [
        'data.en.name' => 'Name',
        'data.es.name' => 'Nombre',
        'data.en.description' => 'Description',
        'data.es.description' => 'Descripción'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetForm($parent_id = null)
    {
        $this->resetValidation();
        $this->process = new Proceso();
        $this->process->parent_id = $parent_id;
        $this->process->created_by_id = auth()->id();

        if (isset($parent_id)) {
            $parent_process = Proceso::find($parent_id);
            $parent_translations = $parent_process->getTranslationsArray();
        }

        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = '';
            $this->data[$locale]['description'] = '';
            $this->data[$locale]['parent_name'] = (isset($parent_translations[$locale]['name'])) ? $parent_translations[$locale]['name'] : '';
        }
    }

    public function edit($id)
    {
        $this->process = Proceso::findOrFail($id);
        $translations = $this->process->getTranslationsArray();
        $process_parent = $this->process->parent;
        if (isset($process_parent)) {
            $parent_translations = $this->process->parent->getTranslationsArray();
        }

        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = $translations[$locale]['name'];
            $this->data[$locale]['description'] = $translations[$locale]['description'];
            if (isset($process_parent) && count($parent_translations) > 0)
                $this->data[$locale]['parent_name'] = $parent_translations[$locale]['name'];
        }
    }

    public function submit()
    {
        if ($this->process->id == "") {
            $log_action = WithLogs::$create;
            $log_message = "Process added";
        } else {
            $log_action = WithLogs::$update;
            $log_message = "Process updated";
        }

        $this->validate($this->rules);

        foreach (config('translatable.locales') as $locale) {
            if (isset($this->data[$locale]['name'])) {
                $this->process->translateOrNew($locale)->name = $this->data[$locale]['name'];
            }
            if (isset($this->data[$locale]['description'])) {
                $this->process->translateOrNew($locale)->description = $this->data[$locale]['description'];
            }
        }

       try {
            $this->process->save();
            $this->logActivity($log_action, $log_message, ['model' => Process::class, 'id' => $this->process->id]);
            $this->dispatchBrowserEvent('processStored');
            $this->resetForm();
            session()->flash('message', 'Todo OK');
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Process::class, 'id' => isset($this->process->id) ? $this->process->id : null]);
            session()->keep('message', 'Ocurrio un error');
        }
    }

    public function showDeleteConfirmationModal($id)
    {
        $this->process = Proceso::find($id);
        $this->dispatchBrowserEvent('show'.$this->deleteModalId);
    }

    public function delete()
    {
        try {
            $log_message = "Proceso eliminado";
            $this->process->delete();
            $this->logActivity(WithLogs::$delete, $log_message, ['model' => Process::class, 'id' => $this->process->id]);
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Process::class, 'id' => $this->process->id]);
        }

        $this->dispatchBrowserEvent('close'.$this->deleteModalId);
    }

    public function render()
    {
        return view('livewire.proceso.index', [
            'processes' => Proceso::with('translations')->with('childs')->where('parent_id', '=', null, 'and')->where('created_by_id', Auth::id())->latest()->paginate($this->itemsPerPage),
            'locales' => config('translatable.locales'),
            'default_locale' => config('app.locale')
        ]);
    }
}
