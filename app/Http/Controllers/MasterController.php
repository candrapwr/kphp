<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function master_kph_json(Request $request)
    {
        if ($request->isMethod('post')) {
            if($request->input('delData')==1){
                $data = DB::table('kph')->where('kph_id', $request->input('dataId'))->delete();
                if($data){
                    $dataJson['sukses'] = $data;
                    $dataJson['pesan'] = 'Data berhasil di hapus';
                }else{
                    $dataJson['sukses'] = $data;
                    $dataJson['pesan'] = 'Gagal hapus data';
                }
                print_r(json_encode($dataJson));
            }else{
                if($request->input('kph_name')!=""){
                    $data = DB::table('kph')->insert([
                        'kph_name'=>$request->input('kph_name')
                    ]);
                    if($data){
                        $dataJson['sukses'] = $data;
                        $dataJson['pesan'] = 'Data berhasil di simpan';
                    }else{
                        $dataJson['sukses'] = $data;
                        $dataJson['pesan'] = 'Gagal insert DB';
                    }
                }else{
                    $dataJson['sukses'] = false;
                    $dataJson['pesan'] = 'Gagal menambah data';
                }
                print_r(json_encode($dataJson));
            }
        }else{
            $data = DB::table('kph')->get();
            $dataJson['data'] = $data;
            print_r(json_encode($dataJson));
        }
    }

    public function master_kph()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Master"], ['name' => "Departemen"]];
        return view('/content/master/kph', ['breadcrumbs' => $breadcrumbs]);
    }

    public function master_jabatan()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Master"], ['name' => "Jabatan"]];
        return view('/content/master/jabatan', ['breadcrumbs' => $breadcrumbs]);
    }

    public function master_shift()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Master"], ['name' => "Shift"]];
        return view('/content/master/shift', ['breadcrumbs' => $breadcrumbs]);
    }
}
