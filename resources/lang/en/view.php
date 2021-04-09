<?php

return [
    /*
    |--------------------------------------------------------------------------
    | View Data Language Lines
    |--------------------------------------------------------------------------
    */
    'livewire' => [
        'project' => [
            'index' => [
                'table' => [
                    'header-name' => 'Name',
                    'header-startdate' => 'Start Date',
                    'header-enddate' => 'End Date'
                ],
                'title' => 'Projects & Child Projects'
            ],
            'partials' => [
                'form' => [
                    'create' => 'Create Project',
                    'update' => 'Update Project',
                    'create-subproject' => 'Create Subproject',
                    'update-subproject' => 'Update Subproject'
                ]
            ]
        ]
    ],
    'partials' => [
        'delete-modal' => [
            'title' => 'Delete Confirmation',
            'body' => 'Are you sure you want to delete this item?'
        ]
    ]


];
