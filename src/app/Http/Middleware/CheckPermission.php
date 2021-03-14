<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\RedisService;

class CheckPermission
{
    private $routes;

    public function __construct() { 

        $this->routes = [
                  "get" => "Read",
                  "post" => "Create",
                  "put" => "Update",
                  "delete" => "Delete",
        ];

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $authToken = str_replace("Bearer ","",$request->header('Authorization'));
        
        $aclKey = $authToken."-"."ACL";

        $permissionsJson = json_decode(RedisService::getValue($aclKey,'acl'));
        $permissionsArr = (array) $permissionsJson;

        $model = explode("/", $request->path());
        $modelName = $model[1]; 
        
        if ( (isset($permissionsArr[$modelName]) == false) || (in_array($this->routes[strtolower($request->method())],$permissionsArr[$modelName]) == false )) {
            return \Response::json(['message' => 'Forbidden!'], 403);
        } 
        
        return $next($request);
        
    }
}
