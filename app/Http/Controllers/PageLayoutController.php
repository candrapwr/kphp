<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageLayoutController extends Controller
{
    public function layout_empty()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout Empty"]];
        return view('/content/page-layouts/layout-empty', ['breadcrumbs' => $breadcrumbs]);
    }

    public function master_departemen()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Master"], ['name' => "Departemen"]];
        return view('/content/master/departemen', ['breadcrumbs' => $breadcrumbs]);
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
	
    public function layout_blank()
    {
        $pageConfigs = ['blankPage' => true];
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout Blank"]];
        return view('/content/page-layouts/layout-blank', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs]);
    }
}
