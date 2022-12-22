<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'title',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    protected $appends = ['color'];

    public function getColorAttribute(){
        $x = "";
        if($this->id == 1){
            $x = "secondary";
        } else if($this->id == 2){
            $x = "warning";
        } else if($this->id == 3){
            $x = "danger";
        } else if($this->id == 4){
            $x = "info";
        } else {
            $x = "muted";
        }
        return $x;
    }
}
