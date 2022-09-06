<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class RphController extends Controller
{
    public function index()
    {
        $data_bdh = DB::table('bdh')
        ->selectRaw('bdh.*,kph.kph_name')
        ->leftjoin('kph','kph.kph_id','=','kph.kph_id')
        ->get();
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Master"], ['name' => "BDH"]];
        return view('/content/master/rph', ['breadcrumbs' => $breadcrumbs, 'data_bdh' => $data_bdh]);
    }

    public function get_all()
    {
        $data = DB::table('rph')
        ->selectRaw('rph.*,bdh.bdh_name,kph.kph_name')
        ->leftjoin('bdh','bdh.bdh_id','=','rph.bdh_id')
        ->leftjoin('kph','kph.kph_id','=','bdh.kph_id')
        ->get();
        $dataJson['data'] = $data;
        echo json_encode($dataJson);
    }

    public function set_insert(Request $request)
    {
        if($request->hasFile('rph_geojson')){
            $file = $request->file('rph_geojson');
            $contents = file_get_contents($file->getPathName());
        }else{
            $contents = '';
        }

        if($request->input('update') != "1"){
            $data = DB::table('rph')
            ->insert([
                'rph_name'=> $request->input('rph_name'),
                'bdh_id'=> $request->input('bdh_id'),
                'rph_size'=> $request->input('rph_size'),
                'rph_polygon'=> $contents

            ]);
        }else{
            $data = DB::table('rph')
            ->where('rph_id', $request->input('dataId'))
            ->update([
                'rph_name'=> $request->input('rph_name_e'),
                'bdh_id'=> $request->input('bdh_id_e'),
                'rph_size'=> $request->input('rph_size_e')
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
        $data = DB::table('rph')
        ->where('rph_id', $request->input('dataId'))->delete();
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
        $data = DB::table('rph')
        ->selectRaw('rph.*,bdh.bdh_name,bdh.bdh_id,kph.kph_name,kph.kph_id')
        ->leftjoin('bdh','bdh.bdh_id','=','rph.bdh_id')
        ->leftjoin('kph','kph.kph_id','=','bdh.kph_id')
        ->where('rph_id', $request->input('dataId'))
        ->first();
        $dataJson['data'] = $data;
        echo json_encode($dataJson);
    }
}
