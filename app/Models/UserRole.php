<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $table='user_roles';
    protected $fillable = [
        'id_user', 'id_role',
    ];
    public static $role_attach_roles = [
        'roles' => 'required|array|min:1|exists:roles'
    ];

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }

    public function role(){
        return $this->hasOne('App\Models\Role', 'id', 'id_role');
    }
}
