<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'ruangan',
    ];
    protected $hidden = ["created_at", "updated_at"];
}
