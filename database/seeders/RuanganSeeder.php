<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ["id" => "1", "ruangan" => "Luring/Offline"],
            ["id" => "2", "ruangan" => "Daring/Online"],
        ];

        foreach ($data as $x) {
            if(!Ruangan::where('id', $x['id'])->first()){
                $m = new Ruangan();
                $m->id = $x['id'];
                $m->ruangan = $x['ruangan'];
                $m->save();
            }
        }
    }
}
