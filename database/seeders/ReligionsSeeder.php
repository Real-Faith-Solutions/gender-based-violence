<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religions;

class ReligionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Religions::create([
            'item_name' => "Roman Catholic",
        ]);

        Religions::create([
            'item_name' => "Islam",
        ]);

        Religions::create([
            'item_name' => "Evangelicals",
        ]);

        Religions::create([
            'item_name' => "Protestant",
        ]);

        Religions::create([
            'item_name' => "Iglesia ni Cristo",
        ]);
    }
}
