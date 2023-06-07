<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RelationshipToVictimSurvivors;

class RelationshipToVictimSurvivorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RelationshipToVictimSurvivors::create([
            'item_name' => "Personal/Family",
        ]);

        RelationshipToVictimSurvivors::create([
            'item_name' => "Current Spouse/Partner",
        ]);

        RelationshipToVictimSurvivors::create([
            'item_name' => "Former Spouse/Partner",
        ]);

        RelationshipToVictimSurvivors::create([
            'item_name' => "Current Fiancé/Dating Relationship",
        ]);

        RelationshipToVictimSurvivors::create([
            'item_name' => "Former Fiancé/Dating Relationship",
        ]);

        RelationshipToVictimSurvivors::create([
            'item_name' => "Neighbors/Peers/Co-Workers/Classmates",
        ]);

        RelationshipToVictimSurvivors::create([
            'item_name' => "Immediate Family Members, Specify:",
        ]);

        RelationshipToVictimSurvivors::create([
            'item_name' => "Stepfamily Members, Specify:",
        ]);
    }
}
