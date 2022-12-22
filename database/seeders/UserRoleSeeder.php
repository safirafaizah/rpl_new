<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
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
            ["id_user" => 1, "id_role" => 1],
            ["id_user" => 1, "id_role" => 2],
            ["id_user" => 1, "id_role" => 3],
            ["id_user" => 1, "id_role" => 4],
        ];

        foreach ($data as $x) {
            if(!UserRole::where('id_user', $x['id_user'])
            ->where('id_role', $x['id_role'])->first()){
                $m = new UserRole();
                $m->id_user = $x['id_user'];
                $m->id_role = $x['id_role'];
                $m->save();
            }
        }
    }
}
