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
                    'header-name' => 'Nombre',
                    'header-startdate' => 'Inicio',
                    'header-enddate' => 'Conclución'
                ],
                'title' => 'Proyectos y Subproyectos'
            ],
            'details' => [
                'title' => 'Detalles del Proyecto',
                'description_tab' => 'Descripción',
                'tasks_tab' => 'Tareas',
                'members_tab' => 'Miembros',
                'files_tab' => 'Adjuntos',
            ],

            'partials' => [
                'form' => [
                    'create' => 'Nuevo Proyecto',
                    'update' => 'Actualizar Proyecto',
                    'create-subproject' => 'Nuevo Subproyecto',
                    'update-subproject' => 'Actualizar Subproyecto'
                ]
            ]
        ],
        'task' => [
            'index' => [
                'table' => [
                    'header-name' => 'Nombre',
                    'header-startdate' => 'Inicio',
                    'header-enddate' => 'Conclución'
                ],
                'title' => 'Tareas y Subtareas'
            ],
            'partials' => [
                'form' => [
                    'create' => 'Nueva Tarea',
                    'update' => 'Actualizar Tarea',
                    'create-subproject' => 'Nueva Subtarea',
                    'update-subproject' => 'Actualizar Subtarea'
                ]
            ]

        ]
    ],
    'partials' => [
        'delete-modal' => [
            'title' => 'Confirmación de Borrado',
            'body' => 'Está seguro que desea borrar este artículo?'
        ]
    ]


];
