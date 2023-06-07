<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'username'              => 'gvbusername',
            'email'                 => 'gvb@gmail.com',
            'password'              => Hash::make('12345'),
            'user_last_name'        => 'Dela Cruz',
            'user_first_name'       => 'Juan',
            'user_middle_name'      => 'Luna',
            'user_contact_no'       => '12345678901',
            'user_employee_id'      => '12345',
            'role'                  => 'System Admin',
            'user_service_provider' => '',
            'is_active'		        => 'Yes',
            'user_region'	        => 'NATIONAL CAPITAL REGION (NCR)',
            'user_province'	        => 'CITY OF MANILA',
            'user_municipality'     => 'ERMITA',
            'user_barangay'         => 'Barangay 659',
        ]);

        User::create([
            'username'              => 'adminusername',
            'email'                 => 'admin@gbvims.com',
            'password'              => Hash::make('12345'),
            'user_last_name'        => 'De Guzman',
            'user_first_name'       => 'Alfred',
            'user_middle_name'      => 'Garcia',
            'user_contact_no'       => '12345678901',
            'user_employee_id'      => '12345',
            'role'                  => 'System Admin',
            'user_service_provider' => '',
            'is_active'		        => 'Yes',
            'user_region'	        => 'NATIONAL CAPITAL REGION (NCR)',
            'user_province'	        => 'NCR, FOURTH DISTRICT',
            'user_municipality'     => 'CITY OF PARAÑAQUE',
            'user_barangay'         => 'San Antonio',
        ]);

        User::create([
            'username'              => 'casemanager',
            'email'                 => 'casemanager@email.com',
            'password'              => Hash::make('12345'),
            'user_last_name'        => 'Silang',
            'user_first_name'       => 'Gabriel',
            'user_middle_name'      => 'Santos',
            'user_contact_no'       => '12345678901',
            'user_employee_id'      => '12345',
            'role'                  => 'Case Manager',
            'user_service_provider' => '',
            'is_active'		        => 'Yes',
            'user_region'	        => 'REGION IV-A (CALABARZON)',
            'user_province'	        => 'CAVITE',
            'user_municipality'     => 'GENERAL TRIAS',
            'user_barangay'         => 'Buenavista II',
        ]);

        User::create([
            'username'              => 'serviceprovider',
            'email'                 => 'serviceprovider@email.com',
            'password'              => Hash::make('12345'),
            'user_last_name'        => 'Cruzado',
            'user_first_name'       => 'Redentor',
            'user_middle_name'      => 'Antonio',
            'user_contact_no'       => '12345678901',
            'user_employee_id'      => '12345',
            'role'                  => 'Service Provider',
            'user_service_provider' => 'BHRC',
            'is_active'		        => 'Yes',
            'user_region'	        => 'REGION VI (WESTERN VISAYAS)',
            'user_province'	        => 'ILOILO',
            'user_municipality'     => 'BATAD',
            'user_barangay'         => 'Drancalan',
        ]);

        User::create([
            'username'              => 'viewer',
            'email'                 => 'viewer@email.com',
            'password'              => Hash::make('12345'),
            'user_last_name'        => 'Santos',
            'user_first_name'       => 'Judy',
            'user_middle_name'      => 'Cruz',
            'user_contact_no'       => '12345678901',
            'user_employee_id'      => '12345',
            'role'                  => 'Viewer',
            'user_service_provider' => '',
            'is_active'		        => 'Yes',
            'user_region'	        => 'AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)',
            'user_province'	        => 'MAGUINDANAO',
            'user_municipality'     => 'DATU PIANG',
            'user_barangay'         => 'Damabalas',
        ]);
    }
}
