<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Super User';
        $user->email = 'superuser@rangrez.com';
        $user->password = bcrypt('password');
        $user->save();
        $user->assignRole('Super_User');

        $user = new User;
        $user->name = 'Reseller Account';
        $user->email = 'reseller@rangrez.com';
        $user->password = bcrypt('password');
        $user->save();
        $user->assignRole('Reseller');
    }
}
