<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\MataKuliah;
use App\Models\Data;
use App\Models\Status;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class RekognisiController extends Controller
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
                'mata_kuliah'=> ['required'],
                'dokumen' => ['required', 'mimes:pdf,doc,docx','max:2048']
            ]);
            $dokName = null;
            if(isset($request->dokumen)){
                $dokName = Carbon::now()->format('YmdHis').'_'.Auth::user()->id.'.'.$request->dokumen->extension(); 
                $folderName =  "dokumen/rekognisi";
                $path = public_path()."/".$folderName;
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true); //create folder
                }
                $request->dokumen->move($path, $dokName); //upload image to folder
                $dokName=$folderName."/".$dokName;
            }
            // dd($request);
            $data = Data::create([
                'id_status'     => 'M',
                'id_user'       => Auth::user()->id,
                'id_mk'         => $request->mata_kuliah,
                'dokumen'       => $dokName
            ]);
            if($data){
                return redirect()->route('rekognisi.index')->with('msg','Data berhasil ditambahkan');
            }else{
                return redirect()->route('rekognisi.index')->with('msg','Data gagal ditambahkan');
            }
           
        }else{
            $mata_kuliah     = MataKuliah::orderBy('id')->get();
            return view('rekognisi.index', compact('mata_kuliah'));
        }       
    }

    public function data(Request $request)
    {
        $data = Data::where("id_user", Auth::user()->id)
        ->with('mata_kuliah')
        ->with('user')
        ->with('status')
                ->select('*')->orderByDesc("updated_at");
            return Datatables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('mata_kuliah'))) {
                            $instance->where('id_mk', $request->get('mata_kuliah'));
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

    public function ubah($idd, Request $request) {
        try {
            $id = Crypt::decrypt($idd);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [ 
                'mata_kuliah'=> ['required'],
                'dokumen' => ['required', 'mimes:pdf,doc,docx','max:2048']
            ]);
            $data = Data::with('mata_kuliah')->find($id);
            $dokName = $data->dokumen;
            if(isset($request->dokumen)){
                $dokName = Carbon::now()->format('YmdHis').'_'.md5(Auth::user()->id).'.'.$request->dokumen->extension(); 
                $folderName =  "dokumen/rekognisi";
                $path = public_path()."/".$folderName;
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true); //create folder
                }
                $upload = $request->dokumen->move($path, $dokName); //upload image to folder
                $dokName=$folderName."/".$dokName;
                if($upload){
                    File::delete(public_path()."/".$data->dokumen);
                }
            }
            // dd($request);
            $d = $data->update([ 
                'id_mk' => $request->mata_kuliah,
                'id_status' => 'M',
                'dokumen' => $dokName
            ]);
            if($d){
                Log::info(Auth::user()->nama." mengubah data #".$data->id);
                return redirect()->route(strtolower($data->mata_kuliah))->with('msg','Data berhasil diubah');
            }else{
                return redirect()->route(strtolower($data->mata_kuliah))->with('msg','Data gagal diubah');
            }
        }
        $data = Data::with('mata_kuliah')
                ->findOrFail($id);
        if($data->id_status == 'V'){
            abort(403, "Data sudah terverifikasi, Anda tidak diperkenankan mengubahnya!");
        }
        $mata_kuliah = MataKuliah::get();
       
        return view('rekognisi.ubah', compact('mata_kuliah', 'data'));
    }

    public function hapus(Request $request) 
    {
        $data = Data::where('id_status', '!=', 'V')->find($request->id);
        if($data && $data->id_user == Auth::user()->id){
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tidak diizinkan untuk menghapus data ini!'
            ]);
        }
    }
}
