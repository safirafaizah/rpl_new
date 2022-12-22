<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Data;
use App\Models\Status;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class VerifikasiController extends Controller
{
    //
    public function index(Request $request)
    {
            $mahasiswa      = User::whereHas('roles', function($q){
                            $q->where('id_role', 4);
                        })->where('username','!=', 'admin')->get();
            $mata_kuliah    = MataKuliah::get();
            $status         = Status::orderBy('id')->get();
            return view('verifikasi.index', compact('mahasiswa','mata_kuliah', 'status'));        
    }

    public function data(Request $request)
    {
        $data = Data::with('mata_kuliah')
        ->with('user')
        ->with('status')
                ->select('*')->orderByDesc("updated_at");
            return Datatables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('select_mahasiswa'))) {
                            $instance->where('id_user', $request->get('select_mahasiswa'));
                        }
                        if (!empty($request->get('select_mk'))) {
                            $instance->where('id_mk', $request->get('select_mk'));
                        }
                        if (!empty($request->get('select_status'))) {
                            $instance->where('id_status', $request->get('select_status'));
                        }
                        if (!empty($request->get('search'))) {
                            $instance->whereHas('mata_kuliah', function($q) use($request){
                                $search = $request->get('search');
                                $q->where('mata_kuliah', 'LIKE', "%$search%");
                            });
                        }

                    })
                    ->addColumn('idd', function($x){
                        return Crypt::encrypt($x['id']);
                      })
                    ->rawColumns(['idd'])
                    ->make(true);
    }

    public function lihat($idd, Request $request) {
        try {
            $id = Crypt::decrypt($idd);
        } catch (DecryptException $e) {
            return redirect()->route('verifikasi.index');
        }
        if ($request->isMethod('post')) {
            // dd($request);
            $data = Data::find($id);
            if($request->action == "verifikasi"){
                
                $d = $data->update([ 
                    'catatan' => $request->catatan,
                    'id_status' => "V", //Verifikasi
                    'id_verifikator' => Auth::user()->id,
                ]);
            } else {    
                $this->validate($request, [ 
                    'catatan'=> ['required'],
                ]);
                $d = $data->update([ 
                    'catatan' => $request->catatan,
                    'id_status' => "T", //Tolak
                ]);
            }
            if($d){
                // if( $request->kirim_email == "1"){
                //     //TODO : Kirim email ke dosen karena data ditolak
                //     $user = User::findOrfail($data->id_user);
                //     // dd($user);
                //     if($user){
                //         $s = array();
                //         $s['email'] = $user->email;
                //         $s['name'] = $user->nama;
                //         $s['subject'] = "Pengajuan Rekognisi Anda Ditolak";
                //         $s['messages'] = "Silahkan memperbarui data Rekognisi Anda di laman rpl.jgu.ac.id";
                //         $s['catatan'] = $request->catatan;
                //         \Mail::to($s['email'])->queue(new \App\Mail\MailNotification($s));
                //     }

                //     return redirect()->route('verifikasi',)->with('msg','Email berhasil dikirim dan data berhasil di'.$request->action.'!');
                // }
                return redirect()->route('verifikasi.lihat', ['id' => $idd])->with('msg','Data berhasil di'.$request->action.'!');
            }
        } 
        $data = Data::with('user')
                ->with('mata_kuliah')
                ->with('status')
                ->findOrFail($id);
        return view('verifikasi.lihat', compact('data'));
    }


}
