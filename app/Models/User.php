<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function getAll($req)
    {
        $data = User::
            join('roles', 'roles.id', 'users.role_id')->
            where('users.active', true)->
            where('users.id', '!=', $req->id)->
            orderBy('users.name')->
            get([
                'users.id',
                'users.name',
                'users.username',
                'users.email',
                'roles.name AS role_name'
            ]);

        foreach ($data as $key => $item) {
            $item->key = $key;
        }

        return $data;
    }

    static public function getItem($id)
    {
        $data = User::
            join('roles', 'roles.id', 'users.role_id')->
            find($id, [
                'users.id',
                'users.name',
                'users.username',
                'users.email',
                'users.role_id',
                'roles.name AS role_name'
            ]);

        return $data;
    }
}