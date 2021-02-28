<?php

namespace App;

use Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getBy(string $value, string $data) {
        return $this->where($value, $data)->first();
    }

    public function new(array $data) : User {

        $user = new $this;
        
        $user->name       =      isset($data['name']) ? $data['name'] : '';
        $user->email      =      $data['email'];
        $user->password   =      Hash::make($data['password']);
        $user->role_id    =      isset($data['role_id']) ? $data['role_id'] : Config::get('constants.role.default');
        $user->save();
        
        return $user;
    }
}
