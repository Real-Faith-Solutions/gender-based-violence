<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DirectoryType;

class DirectoryTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DirectoryType::create([
            'name' => "PAO",
        ]);

        DirectoryType::create([
            'name' => "BHRC",
        ]);

        DirectoryType::create([
            'name' => "WCPU",
        ]);

        DirectoryType::create([
            'name' => "WCPD",
        ]);

        DirectoryType::create([
            'name' => "MSSD",
        ]);
    }
}
