<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'id_status', 
        'id_mk',
        'id_user',
        'dokumen', 
        'skor', 
        'catatan', 
        'created_at', 
        'update_at'
    ];

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_mk');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
