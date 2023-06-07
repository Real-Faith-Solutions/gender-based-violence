<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlaceOfIncidences;

class PlaceOfIncidencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlaceOfIncidences::create([
            'item_name' => "House",
        ]);

        PlaceOfIncidences::create([
            'item_name' => "Outdoor",
        ]);

        PlaceOfIncidences::create([
            'item_name' => "Public Transpo",
        ]);

        PlaceOfIncidences::create([
            'item_name' => "Road",
        ]);

        PlaceOfIncidences::create([
            'item_name' => "Facility",
        ]);

        PlaceOfIncidences::create([
            'item_name' => "Office",
        ]);

        PlaceOfIncidences::create([
            'item_name' => "School",
        ]);

        PlaceOfIncidences::create([
            'item_name' => "Workplace",
        ]);
    }
}
