<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Directory;

class DirectoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Directory::create([
            'dir_first_name' => 'Larry',
            'dir_middle_name' => 'Garcia',
            'dir_last_name' => 'Magtanggol',
            'dir_post_desi' => 'Lawyer',
            'dir_directory_type' => 'PAO',
            'dir_contact_no_1' => '12345678901',
            'dir_contact_no_2' => '1234567',
            'dir_contact_no_3' => '8910111',
            'dir_email' => 'pao_larry@email.com',
            'dir_facebook' => 'http://facebook.com/pao', 
        ]);

        Directory::create([
            'dir_first_name' => 'Ray',
            'dir_middle_name' => 'Dimagiba',
            'dir_last_name' => 'Dimatibag',
            'dir_post_desi' => 'Lawyer',
            'dir_directory_type' => 'PAO',
            'dir_contact_no_1' => '12345678901',
            'dir_contact_no_2' => '87654567898',
            'dir_contact_no_3' => '3456789',
            'dir_email' => 'pao_ray@email.com',
            'dir_facebook' => 'https://www.facebook.com/pao', 
        ]);

        Directory::create([
            'dir_first_name' => 'Sultan',
            'dir_middle_name' => 'Raya',
            'dir_last_name' => 'Kudarat',
            'dir_post_desi' => 'Head',
            'dir_directory_type' => 'BHRC',
            'dir_contact_no_1' => '87654738291',
            'dir_contact_no_2' => '4536271',
            'dir_contact_no_3' => '8746252',
            'dir_email' => 'bhrc_sultan@email.com',
            'dir_facebook' => 'https://www.facebook.com/BHRCBARMM', 
        ]);
    }
}
