<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class BdhController extends Controller
{
    public function index()
    {
        $data_kph = DB::table('kph')->get();
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Master"], ['name' => "BDH"]];
        return view('/content/master/bdh', ['breadcrumbs' => $breadcrumbs, 'data_kph' => $data_kph]);
    }

    public function get_all()
    {
        $data = DB::table('bdh')
        ->selectRaw('bdh.*,kph.kph_name')
        ->leftjoin('kph','kph.kph_id','=','kph.kph_id')
        ->get();
        $dataJson['data'] = $data;
        echo json_encode($dataJson);
    }

    public function set_insert(Request $request)
    {
        if($request->input('update') != "1"){
            $data = DB::table('bdh')
            ->insert([
                'bdh_name'=> $request->input('bdh_name'),
                'kph_id'=> $request->input('kph_id')
            ]);
        }else{
            $data = DB::table('bdh')
            ->where('bdh_id', $request->input('dataId'))
            ->update([
                'bdh_name'=> $request->input('bdh_name_e'),
                'kph_id'=> $request->input('kph_id_e')
            ]);
        }

        if($data){
            $dataJson['sukses'] = $data;
            $dataJson['pesan'] = 'Data berhasil di simpan';
        }else{
            $dataJson['sukses'] = $data;
            $dataJson['pesan'] = 'Gagal DB';
        }
        echo json_encode($dataJson);
    }

    public function set_del(Request $request)
    {
        $data = DB::table('bdh')
        ->where('bdh_id', $request->input('dataId'))->delete();
        if($data){
            $dataJson['sukses'] = $data;
            $dataJson['pesan'] = 'Data berhasil di hapus';
        }else{
            $dataJson['sukses'] = $data;
            $dataJson['pesan'] = 'Gagal hapus data';
        }
        echo json_encode($dataJson);
    }

    public function get_one(Request $request)
    {
        $data = DB::table('bdh')
        ->selectRaw('bdh.*,kph.kph_name,kph.kph_id')
        ->leftjoin('kph','kph.kph_id','=','kph.kph_id')
        ->where('bdh_id', $request->input('dataId'))
        ->first();
        $dataJson['data'] = $data;
        echo json_encode($dataJson);
    }
}
