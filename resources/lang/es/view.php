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
                    'header-enddate' => 'Conclusión'
                ],
                'title' => 'Proyectos y Subproyectos'
            ],
            'details' => [
                'title' => 'Detalles del Proyecto',
                'description_tab' => 'Descripción',
                'subprojects_tab' => 'Subproyectos',
                'tasks_tab' => 'Tareas',
                'members_tab' => 'Miembros',
                'files_tab' => 'Ficheros Adjuntos',
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
                    'header-project' => 'Proyecto',
                    'header-startdate' => 'Fecha de Inicio',
                    'header-enddate' => 'Fecha de Terminación'
                ],
                'title' => 'Tareas y Subtareas'
            ],
            'details' => [
                'title' => 'Detalles de la Tarea',
                'description_tab' => 'Descripción',
                'tasks_tab' => 'Subtareas',
                'members_tab' => 'Colaboradores',
                'files_tab' => 'Ficheros Adjuntos',
            ],
            'partials' => [
                'form' => [
                    'create' => 'Nueva Tarea',
                    'update' => 'Actualizar Tarea',
                    'create-subproject' => 'Nueva Subtarea',
                    'update-subproject' => 'Actualizar Subtarea'
                ]
            ]

        ],
        'process' => [
            'index' => [
                'table' => [
                    'header-name' => 'Nombre'
                ],
                'title' => 'Procesos y Subprocesos'
            ],

            'partials' => [
                'form' => [
                    'create' => 'Nuevo Proceso',
                    'update' => 'Actualizar Proceso',
                    'create-subprocess' => 'Nuevo Subproceso',
                    'update-subprocess' => 'Actualizar Subproceso'
                ]
            ]
        ],
        'logs' => [
            'index' => [
                'table' => [
                    'header-type' => 'Tipo',
                    'header-description' => 'Descripción',
                    'header-date' => 'Fecha'
                ],
                'title' => 'Logs'

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
