<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\MataKuliah;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Data;
use App\Models\Status;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class JadwalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'nama'=> ['required'], 
                'jadwal'=> ['required', 'date'],
                'asesor'=>['required'],
                'ruangan' => ['required'],
                'catatan' => ['required'],
            ]);

            // dd($request);
            $data = Data::create([
                'id_user'       => Auth::user()->id,
                'id_jadwal'     => $request->jadwal,
                'id_ruangan'    => $request->ruangan,
                'id_asesor'     => $request->asesor,
            ]);
            if($data){
                return redirect()->route('jadwal.index')->with('msg','Data berhasil ditambahkan');
            }else{
                return redirect()->route('jadwal.index')->with('msg','Data gagal ditambahkan');
            }
           
        }else{
            $jadwal     = Jadwal::orderBy('id')->get();
            $ruangan    = Ruangan::orderBy('id')->get();
            // dd($request);
            return view('jadwal.index', compact('jadwal', 'ruangan'));
        }       
    }

    public function data(Request $request)
    {
        $data = Data::where("id_user", Auth::user()->id)
        ->with('jadwal')
        ->with('ruangan')
                ->select('*')->orderByDesc("updated_at");
            return Datatables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('ruangan'))) {
                            $instance->where('id_ruangan', $request->get('ruangan'));
                        }
                        if (!empty($request->get('search'))) {
                            $instance->whereHas('ruangan', function($q) use($request){
                                $search = $request->get('search');
                                $q->where('ruangan', 'LIKE', "%$search%");
                            });
                        }

                    })
                    ->addColumn('idd', function($x){
                        return Crypt::encrypt($x['id']);
                      })
                    ->rawColumns(['idd'])
                    ->make(true);
    }


}
