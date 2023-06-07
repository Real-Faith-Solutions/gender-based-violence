<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([
            'role_name' => "System Admin",
            'page_access' => "Dashboard,Rights Management,Reports,Maintenance,",
            'master_list_rights' => "",
        ]);

        UserRole::create([
            'role_name' => "Case Manager",
            'page_access' => "Dashboard,Master List,Reports,",
            'master_list_rights' => "Add,Revise,Delete,Upload,Approved/Disapproved,",
        ]);

        UserRole::create([
            'role_name' => "Service Provider",
            'page_access' => "Dashboard,Master List,Reports,",
            'master_list_rights' => "Add,Revise,Delete,Upload,Approved/Disapproved,",
        ]);

        UserRole::create([
            'role_name' => "Viewer",
            'page_access' => "Dashboard,Reports,",
            'master_list_rights' => "",
        ]);
    }
}
