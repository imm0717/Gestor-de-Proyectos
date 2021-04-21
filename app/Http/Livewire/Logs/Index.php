<?php

namespace App\Http\Livewire\Logs;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Index extends Component
{
    use WithPagination;

    private $itemsPerPage = 10;
    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        return view('livewire.logs.index', [
            'logs' => Activity::where('causer_id', auth()->id())->orderBy('created_at', 'desc')->paginate(20)
        ]);
    }
}
