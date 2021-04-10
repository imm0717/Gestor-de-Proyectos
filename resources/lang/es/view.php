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
                'title' => 'Detalles del Proyecto'
            ],
            'partials' => [
                'form' => [
                    'create' => 'Nuevo Proyecto',
                    'update' => 'Actualizar Proyecto',
                    'create-subproject' => 'Nuevo Subproyecto',
                    'update-subproject' => 'Actualizar Subproyecto'
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
