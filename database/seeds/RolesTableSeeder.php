<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $role_manager = new Role();
        $role_manager->name = 'manager';
        $role_manager->description = 'A Manager User';
        $role_manager->save();

        $role_employee = new Role();
        $role_employee->name = 'employee';
        $role_employee->description = 'A Employee User';
        $role_employee->save();
    }
}