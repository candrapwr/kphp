<?php
 
namespace App\Http\Controllers;
 
use DB;
use Response;
use Illuminate\Http\Request;
 
class MapController extends Controller
{
    public function index(){
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Pohon"], ['name' => "BDH"]];
        return view('/content/map/front', ['breadcrumbs' => $breadcrumbs]);
    }

    public function get_geojson(Request $request)
    {
        $sql = "
        SELECT json_build_object(
            'type', 'FeatureCollection',
            'features', json_agg(ST_AsGeoJSON(p.*)::json)
            ) as json
        FROM pohon p 
        ";
        $data = DB::select($sql)[0];
        $response = Response::make($data->json, 200);
        $response->header('Content-Type', 'application/json');
        return $response;
    }
}