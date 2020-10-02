<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->setConnection('mysql2');
        $role->name = 'Reseller';
        $role->save();

        $role = new Role;
        $role->setConnection('mysql2');
        $role->name = 'Super_User';
        $role->save();
    }
}
