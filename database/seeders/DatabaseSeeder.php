<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(DirectoriesTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(DirectoryTypesTableSeeder::class);
        $this->call(PlaceOfIncidencesSeeder::class);
        $this->call(RelationshipToVictimSurvivorsSeeder::class);
        $this->call(ReligionsSeeder::class);
    }
}
