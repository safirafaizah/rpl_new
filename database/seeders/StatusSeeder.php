<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id" => "M", "status" => "Menunggu", "warna" => "primary"],
            ["id" => "T", "status" => "Ditolak", "warna" => "warning"],
            ["id" => "V", "status" => "Diverifikasi", "warna" => "success"],
        ];

        foreach ($data as $x) {
            if(!Status::where('id', $x['id'])->first()){
                $m = new Status();
                $m->id = $x['id'];
                $m->status = $x['status'];
                $m->warna = $x['warna'];
                $m->save();
            }
        }
    }

}
