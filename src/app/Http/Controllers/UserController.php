<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
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
	  
    public function create(Request $request) {
    	
    	$input = $request->all();

        $rules = [
            'email'    => 'required|unique:users|email',
            'password' => 'required',
        ];

        $validator = Validator::make($input, $rules);
        
        if ($validator->fails()) {
            return \Response::json(['message' => $validator->messages()], 400);
        }

        $newUser = $this->user->new($input);

    	if($newUser) {

            //AclService::setPermissions($newUser);

    		return \Response::json(['message' => 'Successfully saved item!'], 201);
    	}

    	return \Response::json(['message' => 'Bad Request!'], 400);
    }

    public function login() {

    	$request = Request();
    	
    	$input = $request->all();

    	$rules = [
            'email'    => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($input, $rules);
        
        if ($validator->fails()) {
            return \Response::json(['message' => $validator->messages()], 400);
        }

        $user = $this->user->getBy('email',$input['email']);
              
        if($user == null or !Hash::check($input['password'], $user->password)) {
			 return \Response::json(['message' => 'Not Found!'], 404);
		}

		$authToken = Str::random(60);
        
        RedisService::setValue($authToken,$user->email);

		$user->api_token = $authToken;
		
    	return \Response::json($user, 200);

    }

    public function logout(string $token) {

    	//find auth_token in Redis and delete it
        $user = RedisService::getValue($token);
    	
    	if (empty($user)){
    		return \Response::json(['message' => 'Not Found!'], 404);
    	}
        
        RedisService::removeValue($token);

    	return \Response::json(['message' => 'Successfully logged out!'], 200);

    }

}
