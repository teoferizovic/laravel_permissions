<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate(
            ['id' =>  1],
            ['name' => 'Admin']
        );

        Role::updateOrCreate(
            ['id' =>  2],
            ['name' => 'User']
        );

        Role::updateOrCreate(
            ['id' =>  3],
            ['name' => 'Client']
        ); 
    }
}
