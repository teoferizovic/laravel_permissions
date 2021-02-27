<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::updateOrCreate(
            ['id' =>  1],
            ['name' => 'Create']
        );

        Permission::updateOrCreate(
            ['id' =>  2],
            ['name' => 'Read']
        );

        Permission::updateOrCreate(
            ['id' =>  3],
            ['name' => 'Update']
        ); 

        Permission::updateOrCreate(
            ['id' =>  4],
            ['name' => 'Delete']
        ); 
    }
}
