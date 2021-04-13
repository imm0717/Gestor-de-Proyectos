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
            'details' => [
                'title' => 'Project Details'
            ],
            'partials' => [
                'form' => [
                    'create' => 'Create Project',
                    'update' => 'Update Project',
                    'create-subproject' => 'Create Subproject',
                    'update-subproject' => 'Update Subproject'
                ]
            ]
        ],
        'task' => [
            'index' => [
                'table' => [
                    'header-name' => 'Name',
                    'header-startdate' => 'Start Date',
                    'header-enddate' => 'End Date'
                ]
            ],
            'partials' => [
                'form' => [
                    'create' => 'New Task',
                    'update' => 'Update Task',
                    'create-subproject' => 'New Subtask',
                    'update-subproject' => 'Update Subtask'
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
