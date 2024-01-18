<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TiempoActual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\LOG;

class TiempoActualController extends Controller
{

    public function obtenerTiempo(Request $request)
{
    $ubicacion = $request->input('ubicacion');
    $ubicacionesSeparadas = explode(',', $ubicacion);
    $resultado = [];
    LOG::info($ubicacionesSeparadas);
    $ubicacionesSeparadas = array_unique($ubicacionesSeparadas);
    foreach ($ubicacionesSeparadas as $ubicacion) {
        //return $ubicacion;
        $ubi = TiempoActual::find($ubicacion);
        //$resultado [] = $ubi;
        if(!$ubi){
            //return response()->json(['message'=>'error', 'codigo' => '500'], 500)->header('code', '500');
        }else{
            $resultado [] =[
                'nombre' => $ubicacion,
                'temperatura' => $ubi-> temperatura,
                'humedad' => $ubi->humedad,
                'tiempo' => $ubi->tiempo,
                'viento' => $ubi->viento,
                'latitud' => $ubi->latitud,
                'longitud' => $ubi->longitud,
            ];
        }
    }
    return response()->json($resultado);
}
}
