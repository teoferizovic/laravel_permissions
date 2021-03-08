<?php

use App\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolePermission::updateOrCreate(
            ['id' =>  1],
            [
            	'role_id' => 1,
            	'permission_id' => 1,
            	'model_name' => 'comments'
        	]
        );
        RolePermission::updateOrCreate(
            ['id' =>  2],
            [
            	'role_id' => 1,
            	'permission_id' => 2,
            	'model_name' => 'comments'
        	]
        );
        RolePermission::updateOrCreate(
            ['id' =>  3],
            [
            	'role_id' => 1,
            	'permission_id' => 3,
            	'model_name' => 'comments'
        	]
        );
        RolePermission::updateOrCreate(
            ['id' =>  4],
            [
            	'role_id' => 1,
            	'permission_id' => 4,
            	'model_name' => 'comments'
        	]
        );
    }
}
