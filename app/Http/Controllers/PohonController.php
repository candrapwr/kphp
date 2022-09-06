<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PohonController extends Controller
{
    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Pohon"], ['name' => "BDH"]];
        return view('/content/pohon/list', ['breadcrumbs' => $breadcrumbs]);
    }

    public function get_qrcode()
    {
        $qrcode = QrCode::format('svg')->generate('aaaa');
        print_r($qrcode);
    }

    public function get_all()
    {
        $data = DB::table('pohon')
        ->get();
        $dataJson['data'] = $data;
        echo json_encode($dataJson);
    }

    public function set_insert(Request $request)
    {       
        if($request->hasFile('img_data')){
            $file = $request->file('img_data');
            $destinationPath = 'uploads/pohon';
            $fileName = time().'.jpg';
            $file->move($destinationPath,$fileName);
            //print_r($file->getRealPath());
        }else{
            $fileName = '';
        }
        //exit();

        if($request->input('update') != "1"){
            $data = DB::table('pohon')
            ->insert([
                'pohon_nama'=> $request->input('pohon_nama'),
                'pohon_jenis'=> $request->input('pohon_jenis'),
                'pohon_diameter'=> $request->input('pohon_diameter'),
                'pohon_tinggi'=> $request->input('pohon_tinggi'),
                'pohon_status'=> $request->input('pohon_status'),
                'pohon_tahun_tanam'=> $request->input('pohon_tahun_tanam'),
                'pohon_rentang_tumbuh'=> $request->input('pohon_rentang_tumbuh'),
                'pohon_lat'=> $request->input('pohon_lat'),
                'pohon_long'=> $request->input('pohon_long'),
                'pohon_kode'=> $request->input('pohon_kode'),
                'pohon_img'=> $fileName

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
        $data = DB::table('pohon')
        ->where('pohon_id', $request->input('dataId'))->delete();
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
        $data = DB::table('pohon')
        ->where('pohon_id', $request->input('dataId'))
        ->first();
        $qrcode = QrCode::format('svg')->generate($request->input('dataId'));
        $data->qr = (String) $qrcode;
        $dataJson['data'] = $data;
        echo json_encode($dataJson);
    }
}
