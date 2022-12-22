<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sso_klas2(Request $request)
    {
        try {
            if(Session::get('klas2_api_key') != $request->api_key){
                return redirect()->route('login')->withErrors(['msg' => 'Token API kedaluwarsa, silakan ulangi lagi!']);
            }
            Session::put('klas2_api_key', null);
            if($request->token == md5($request->api_key.$request->id) && env('APP_KEY').gmdate('Y/m/d') == Crypt::decrypt($request->api_key)){
                $user = User::where('username', $request->id)->first();
                if ($user != null) { //login
                    if(($request->dept_id  != "STUDENT") || $user->jabatan == null){
                        User::where('id',$user->id)->update([
                            'jabatan'=> $request->job,
                            'updated_at' => Carbon::now()
                        ]);
                        // dd($request);
                    }
                    Auth::loginUsingId($user->id);

                } else { //register
                    $user = User::where('email',$request->email)->first();
                    if($request->email == null){
                        $user = User::where('username',$request->id)->first();
                    }
                    if($user == null){
                        $new_user = false;
                        if($request->email == null || $request->email == ""){
                            $request->email = null;
                        }
                        $new_user=User::insert([
                                'nama' => strtoupper($request->name),
                                'email' => $request->email,
                                'username' => $request->id,
                                'password'=> Hash::make($request->id),
                                'jabatan'=> $request->job,
                                'email_verified_at' => Carbon::now(),
                                'created_at' => Carbon::now()
                        ]);
                        
                        if($new_user){
                            $user = User::where('username', $request->id)->first();
                            if($request->dept_id == "ACAD" ){
                                $user->roles()->attach(Role::where('id', '3')->first());
                            } elseif ($request->dept_id == "STUDENT") {
                                $user->roles()->attach(Role::where('id', '4')->first());
                            }
                        }  
                    } else {
                        $old_user = $user->update([
                            'nama' => $request->name,
                            'email' => $request->email,
                            'username' => $request->id,
                            'jabatan'=> $request->job,
                            'updated_at' => Carbon::now()
                        ]);
                        
                        if($old_user){
                            $user = User::where('username', $request->id)->first();
                            if($request->dept_id == "ACAD" && !$user->hasRole('3')){
                                $user->roles()->attach(Role::where('id', '3')->first());
                            } else if($request->dept_id == "STUDENT" && !$user->hasRole('4')){
                                $user->roles()->attach(Role::where('id', '4')->first());
                            }
                        }  
                    }
                    Auth::loginUsingId($user->id);
                }
                return redirect()->route('home');
            } else {
                abort(403, "Unable to access restricted pages!");
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return redirect()->route('login')->withErrors(['msg' => $msg]);
        }
    }
}
