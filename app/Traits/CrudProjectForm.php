<?php
namespace App\Traits;

/**
 * 
 */
trait CrudProjectForm
{
    protected $listeners = ['selectEndDate', 'selectStartDate'];

    public $project = null;
    public $data = [];

    protected $rules = [
        'data.en.name' => 'required|string|max:50',
        'data.en.description' => 'required|string|max:256',
        'project.start_date' => 'required|date',
        'project.end_date' => 'required|date',
        'project.owner_id' => 'nullable',
        'project.created_by_id' => 'required',
        'project.parent_id' => 'nullable'
    ];

    protected $validationAttributes = [
        'project.start_date' => 'Start Date',
        'project.end_date' => 'End Date',
        'data.en.name' => 'Name',
        'data.es.name' => 'Nombre',
        'data.en.description' => 'Description',
        'data.es.description' => 'Descripción'
    ];
    
}

?>