<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\RedisService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

	private $user;

	public function __construct(User $user){
		$this->user = $user;
	}
	  
    public function create() {
    	
    	$request = Request();
    	$input = $request->all();

    	if ((isset($input['email']) == false) or (isset($input['password']) == false)) {
    		 return \Response::json(['message' => 'Bad Request!'], 400);
    	}

        $user = $this->user->getBy('email',$input['email']);

    	if($user) {
    		return \Response::json(['message' => 'User with that username allready exists!'], 400);
    	}

        $newUser = $this->user->new($input);

    	if($newUser) {

    		//$userImage = UserImageController::storeFile($input,$newUser->id);
    	
            //AclService::setPermissions($newUser);

    		return \Response::json(['message' => 'Successfully saved item!'], 201);
    	}

    	return \Response::json(['message' => 'Bad Request!'], 400);
    }

    public function login() {

    	$request = Request();
    	
    	$input = $request->all();

    	if ((isset($input['email']) == false) or (isset($input['password']) == false)) {
    		 return \Response::json(['message' => 'Bad Request!'], 400);
    	}

    	//$user = User::where('email', $input['email'])->first();
        $user = $this->user->getBy('email',$input['email']);
       
		//if($user == null or !password_verify($input['password'], $user->password)) {        
        if($user == null or !Hash::check($input['password'], $user->password)) {
			 return \Response::json(['message' => 'Not Found!'], 404);
		}

        /*if(UserLogController::create(["user_id"=>$user->id,'ip_address'=>$request->getClientIp()]) != true){
             return \Response::json(['message' => 'Server Error!'], 500);
        }*/

		$authToken = Str::random(60);
        //$authToken = bin2hex(openssl_random_pseudo_bytes(32));
        RedisService::setValue($authToken,$user->email);

		$user->api_token = $authToken;
		
    	return \Response::json($user, 200);

    }

    public function logout($token=null) {

    	if($token == null) {
    		return \Response::json(['message' => 'Bad Request!'], 400);
    	}

    	//find auth_token in Redis and delete it
        $user = RedisService::getValue($token);
    	
    	if (empty($user)){
    		return \Response::json(['message' => 'Not Found!'], 404);
    	}
        
        RedisService::removeValue($token);

    	return \Response::json(['message' => 'Successfully logged out!'], 200);

    }

}
