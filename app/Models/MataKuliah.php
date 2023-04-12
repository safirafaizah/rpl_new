<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'mata_kuliah', 'kode_mk' , 'sks'
    ];
    protected $hidden = ["created_at", "updated_at"];
}
