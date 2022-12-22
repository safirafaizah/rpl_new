<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MataKuliah;
use File;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MataKuliah::truncate();
        $json = File::get("database/data/mata_kuliah.json");
        $loc = json_decode($json);
  
        foreach ($loc as $key => $value) {
            MataKuliah::create([
                "id" => $value->id,
                "kode_mk" => $value->kode_mk,
                "mata_kuliah" => $value->mata_kuliah,
                "sks" => $value->sks,
            ]);
        }
    }
}
