<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\DB;

class ACLService
{

	public static function setPermissions(User $user) : bool {

		$rolePermissions = DB::select('SELECT rp.id,rp.permission_id,rp.model_name, p.name as permision_name FROM role_permissions as rp inner join permissions as p on rp.permission_id = p.id
			where role_id = :roleId',['roleId' => $user->role_id]
		);

		$permissions = [];

		foreach ($rolePermissions as $key => $value) {
			$permissions[$value->model_name][] = $value->permision_name;
		}

		
		if( !empty($permissions) ) {
			$redisAclKey = $user->token . '-' . 'ACL';
			RedisService::setValue($redisAclKey,json_encode($permissions),'acl');
		}
		
		return true;
	}

}