<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use Carbon\Carbon;
use DB;

class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => $e->getMessage() ]);
        }
        try {
     
            $user = Socialite::driver('google')->user();
            $finduser = User::where('id_google', $user->id)->first();
            if($finduser){
                Auth::loginUsingId($finduser->id);
                return redirect()->route('home');
            }else{
                $findemail = User::where('email', $user->email)->first();
                if($findemail){
                    $update_user = User::where('email',$user->email)
                                ->update([
                                    'id_google' => $user->id,
                                    'updated_at' => Carbon::now()
                                ]);
                    if($update_user){
                        Auth::loginUsingId($finduser->id);
                        return redirect()->route('home');
                    } else {
                        abort(403, "Tidak dapat mengakses halaman terbatas!");
                    }
                } else {
                    // echo "User tidak terdaftar";
                    $msg = "Maaf, $user->email tidak terdaftar.<br>Silahkan login dengan cara yang lain!";
                    return redirect()->route('login')->withErrors(['msg' => $msg]);
                }
            }
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Sesi Kedaluwarsa, silahkan ulangi lagi!']);
        }
    }
}
