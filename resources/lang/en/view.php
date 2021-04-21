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
                'title' => 'Project Details',
                'description_tab' => 'Description',
                'subprojects_tab' => 'Subproyectos',
                'tasks_tab' => 'Tasks',
                'members_tab' => 'Members',
                'files_tab' => 'Attached Files',
            ],
            'partials' => [
                'form' => [
                    'create' => 'New Project',
                    'update' => 'Update Project',
                    'create-subproject' => 'New Subproject',
                    'update-subproject' => 'Update Subproject'
                ]
            ]
        ],
        'task' => [
            'index' => [
                'table' => [
                    'header-name' => 'Name',
                    'header-project' => 'Project',
                    'header-startdate' => 'Start Date',
                    'header-enddate' => 'End Date'
                ],
                'title' => 'Tasks & Subtasks'
            ],
            'details' => [
                'title' => 'Task Details',
                'description_tab' => 'Description',
                'tasks_tab' => 'Subtasks',
                'members_tab' => 'Collaborators',
                'files_tab' => 'Attached Files',
            ],
            'partials' => [
                'form' => [
                    'create' => 'New Task',
                    'update' => 'Update Task',
                    'create-subproject' => 'New Subtask',
                    'update-subproject' => 'Update Subtask'
                ]
            ]

        ],
        'process' => [
            'index' => [
                'table' => [
                    'header-name' => 'Name',
                ],
                'title' => 'Process & Subprocess'
            ],

            'partials' => [
                'form' => [
                    'create' => 'New Process',
                    'update' => 'Update Process',
                    'create-subprocess' => 'New Subprocess',
                    'update-subprocess' => 'Update Subprocess'
                ]
            ]
        ],
        'logs' => [
            'index' => [
                'table' => [
                    'header-type' => 'Type',
                    'header-description' => 'Description',
                    'header-date' => 'Date'
                ],
                'title' => 'Logs'

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
