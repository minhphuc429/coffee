<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $role_manager = new Role();
        $role_manager->name = 'manager';
        $role_manager->description = 'chị quản lý';
        $role_manager->save();

        $role_employee = new Role();
        $role_employee->name = 'customer care';
        $role_employee->description = 'nhân viên chăm sóc khách hàng';
        $role_employee->save();

        $role_employee = new Role();
        $role_employee->name = 'deliver';
        $role_employee->description = 'nhân viên giao hàng';
        $role_employee->save();
    }
}