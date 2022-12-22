<?php

namespace Database\Seeders;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User;
        $user->id=1;
        $user->username = "admin";
        $user->nama = "admin";
        $user->email = "no-reply@jgu.ac.id";
        $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->password = bcrypt('adminadmin'); 
        $user->save();
    }
}
