<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        "0" => ['permission' => 'all', 'description' => 'Todos los permisos'],
        "1" => ['permission' => 'edit-project', 'description' => 'Editar Datos de Proyectos'],
        "2" => ['permission' => 'delete-project', 'description' => 'Eliminar Proyecto'],
        "3" => ['permission' => 'add-subproject', 'description' => 'Agregar Subproyecto'],
        "4" => ['permission' => 'add-task', 'description' => 'Agregar Tareas a un Proyecto'],
        "5" => ['permission' => 'edit-task', 'description' => 'Editar Tarea de un Proyecto'],
        "6" => ['permission' => 'delete-task', 'description' => 'Eliminar Tarea de un Proyecto'],
        "7" => ['permission' => 'add-subtask', 'description' => 'Agregar Subtareas'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert($this->permissions);
    }
}
