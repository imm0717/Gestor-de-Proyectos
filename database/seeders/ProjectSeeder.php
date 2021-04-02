<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::factory()->count(3)->afterMaking(function ($project){
            $user = User::find(1);
            $project->created_by_id = $user->id;
        })->create();
    }
}
