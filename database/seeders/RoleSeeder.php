<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
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
            ["id" => 1, "title" => "Admin"],
            ["id" => 2, "title" => "Kajur"],
            ["id" => 3, "title" => "Asesor"],
            ["id" => 4, "title" => "Mahasiswa"],
        ];

        foreach ($data as $x) {
            if(!Role::where('id', $x['id'])->first()){
                $m = new Role();
                $m->id = $x['id'];
                $m->title = $x['title'];
                $m->save();
            }
        }
    }
}
