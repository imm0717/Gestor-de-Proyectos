<?php

namespace App\Http\Livewire\Partials;

use App\Traits\WithLogs;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Attachment extends Component
{
    use WithFileUploads;
    use WithLogs;

    public $file = null;
    public $model;
    public $extensions_logo = [
        'pdf' => 'fa fa-file-pdf-o',
        'jpg' => 'fa fa-file-image-o',
        'png' => 'fa fa-file-image-o',
        'doc' => 'fa fa-file-word-o',
        'docx' => 'fa fa-file-word-o',
        'xls' => 'fa fa-file-excel-o',
        'xlsx' => 'fa fa-file-excel-o',
        'rar' => 'fa fa-file-archive-o',
        'zip' => 'fa fa-file-zip-o',
    ];

    public function save()
    {
        $this->validate([
            'file' => 'file|max:2048', // 2MB Max
        ]);

        try {
            $filename = $this->file->getClientOriginalName();
            $extension = $this->file->extension();
            $path = $this->file->storeAs('files', $filename);

            if ($path != false && isset($this->model) && method_exists($this->model, 'attachments')) {
                $this->model->attachments()->create([
                    'file_path' => $path,
                    'extension' => $extension
                ]);
                $this->model->refresh();
                $this->file = null;
            }

            $log_message = "Fichero agregado";
            $this->logActivity(WithLogs::$update, $log_message, []);
        } catch (QueryException $e) {

            $this->logActivity(WithLogs::$error, $e->getMessage(), []);
        }
    }

    private function getAttachments()
    {
        if (isset($this->model) && method_exists($this->model, 'attachments')) {
            return $this->model->attachments;
        }
    }

    public function download($filename)
    {
        if (Storage::disk('local')->exists('files/' . $filename)) {
            return Storage::download('files/' . $filename);
        }
    }

    public function remove($attachment_id)
    {
        if (isset($attachment_id)) {
            try {
                $attachment = $this->model->attachments()->where('id', $attachment_id)->first();

                if (Storage::disk('local')->exists($attachment->file_path)) {
                    Storage::delete($attachment->file_path);
                }

                $attachment->delete();
                $this->model->refresh();

                $log_message = "Fichero eliminado";
                $this->logActivity(WithLogs::$delete, $log_message, []);
            } catch (QueryException $e) {
                $this->logActivity(WithLogs::$error, $e->getMessage(), []);
            }
        }
    }

    public function mount($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.partials.attachment', [
            'attachments' => $this->getAttachments()
        ]);
    }
}
