<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\Data;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Role;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;

class PengaturanController extends Controller
{
    //
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function akun(Request $request)
    {
            $roles         = Role::get();
            $user          = User::whereHas('roles', function($q){
                                $q->where('id_role', 2);
                            })->where('username','!=', 'admin')->get();
            return view('pengaturan.akun', compact('user', 'roles'));      
    }

    public function akun_data(Request $request)
    {
        $data = User::select('*');
        return Datatables::of($data)
                ->addColumn('roles',function(User $admin){
                    return $admin->roles->toArray();
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('select_role'))) {
                        $instance->whereHas('roles', function($q) use($request){
                            $q->where('id_role', $request->get('select_role'));
                        });
                    }
                    if (!empty($request->get('select_user'))) {
                        $instance->where('id', $request->get('select_user'));
                    }
                    if (!empty($request->get('search'))) {
                         $instance->where(function($w) use($request){
                            $search = $request->get('search');
                                $w->orWhere('username', 'LIKE', "%$search%")
                                ->orWhere('nama', 'LIKE', "%$search%")
                                ->orWhere('nidn', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%")
                                ->orWhere('jabatan', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('idd', function($x){
                    return Crypt::encrypt($x['id']);
                  })
                ->rawColumns(['idd'])
                ->make(true);
    }

    public function akun_ubah ($idd, Request $request)
    {
         try {
             $id = Crypt::decrypt($idd);
         } catch (DecryptException $e) {
             return redirect()->route('pengaturan.akun');
         }
         $roles   = Role::get();
         if ($request->isMethod('post')) {
             $this->validate($request, [ 
                 'nama' => ['required', 'string'],
                 'username'=> ['required', 'string', 'max:255', Rule::unique('users')->ignore($id, 'id')],
                 'email'=> ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id, 'id')],
             ]);
             User::where('id', $id)->update([
                 'nama'=> $request->nama,
                 'username'=> $request->username,
                 'email'=> $request->email,
                 'updated_at' => Carbon::now()
             ]);
             $detach = User::find($id)->roles()->detach();
             $attach = User::find($id)->roles()->attach($request->roles);
             Log::info(Auth::user()->nama." memperbarui profil user #".$id.", ".$request->nama);
             return redirect()->route('pengaturan_akun_ubah', ['id'=>$idd])->with('msg','Profil '.$request->nama.' telah diperbarui');
         }
         $data = User::find($id);
         if($id == 1 || $data == null){
             abort(403, "Tidak diperkenankan akses laman!");
         }
         return view('pengaturan.akun_ubah', compact('data','roles'));
    }

    public function matakuliah(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [ 
                'kode_mk'=> ['required'],
                'mata_kuliah'=> ['required'],
                'sks'=> ['nullable', 'numeric', 'between:0,99.99'],
            ]);
            
            $data = MataKuliah::create([
                'kode_mk' => $request->kode_mk,
                'mata_kuliah' => $request->mata_kuliah,
                'sks' => $request->sks,
            ]);
            if($data){
                return redirect()->route('pengaturan.matakuliah')->with('msg','Data berhasil ditambahkan');
            }else{
                return redirect()->route('pengaturan.matakuliah')->with('msg','Data gagal ditambahkan');
            }
           
        }
        $mk   = MataKuliah::get();
        return view('pengaturan.matakuliah', compact('mk'));
    }

    public function matakuliah_data(Request $request)
    {
        $data = MataKuliah::select('*')->orderBy("id");
            return Datatables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                            $search = $request->get('search');
                            $instance->where('mata_kuliah', 'LIKE', "%$search%");
                        }
                    })
                    ->addColumn('idd', function($x){
                        return Crypt::encrypt($x['id']);
                      })
                    ->rawColumns(['idd'])
                    ->make(true);
    }

    public function matakuliah_hapus(Request $request) {
        $data = MataKuliah::find($request->id);
        if($data){
            Log::warning(Auth::user()->nama." menghapus mata kuliah : ".$data->mata_kuliah);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus!'
            ]);
        }
    }

    public function matakuliah_ubah($idd, Request $request) {
        try {
            $id = Crypt::decrypt($idd);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [ 
                'kode_mk'=> ['required'],
                'mata_kuliah'=> ['required'],
                'sks'=> ['nullable', 'numeric', 'between:0,99.99'],
            ]);
            $data = MataKuliah::find($id);
            $d = $data->update([ 
                'kode_mk' => $request->kode_mk,
                'mata_kuliah' => $request->mata_kuliah,
                'sks' => $request->sks,
            ]);
            if($d){
                return redirect()->route('pengaturan.matakuliah')->with('msg','Data berhasil diubah');
            }else{
                return redirect()->route('pengaturan.matakuliah')->with('msg','Data gagal diubah');
            }
        }
        $data = MataKuliah::findOrFail($id);
        $mk   = MataKuliah::get();
        return view('pengaturan.matakuliah_ubah', compact('data', 'mk'));
    }







}

