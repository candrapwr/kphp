<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function karyawan_list()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Karyawan"], ['name' => "List"]];
        return view('/content/karyawan/list', ['breadcrumbs' => $breadcrumbs]);
    }

    public function karyawan_kontrak()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Karyawan"], ['name' => "Kontrak"]];
        return view('/content/karyawan/kontrak', ['breadcrumbs' => $breadcrumbs]);
    }

    public function karyawan_gaji()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Karyawan"], ['name' => "Gaji"]];
        return view('/content/karyawan/gaji', ['breadcrumbs' => $breadcrumbs]);
    }

    public function karyawan_jatahcuti()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Karyawan"], ['name' => "Jatah Cuti"]];
        return view('/content/karyawan/jatahcuti', ['breadcrumbs' => $breadcrumbs]);
    }
}
