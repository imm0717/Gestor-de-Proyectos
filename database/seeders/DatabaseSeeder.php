<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(3)->afterCreating(function(User $user){
            Team::factory()->create(['user_id' => $user->id]);
        })->create();

        /*$this->call([
            ProjectSeeder::class
        ]);*/
    }
}
