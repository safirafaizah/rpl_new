<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'id_data', 'id_ruangan', 'id_asesor', 'waktu'
    ];
    protected $hidden = ["created_at", "updated_at"];

    public function data()
    {
        return $this->belongsTo(Data::class, 'id_data');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }
    
    public function asesor()
    {
        return $this->belongsTo(User::class, 'id_asesor');
    }
}
