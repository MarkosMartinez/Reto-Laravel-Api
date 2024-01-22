<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TiempoActual;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\LOG;

class TiempoActualController extends Controller
{

    public function obtenerTiempo(Request $request)
    {
        $ubicacion = $request->input('ubicacion');
        $ubicacionesSeparadas = explode(',', $ubicacion);
        $resultado = [];
        $ubicacionesSeparadas = array_unique($ubicacionesSeparadas);
        foreach ($ubicacionesSeparadas as $ubicacion) {
            $ubi = TiempoActual::find($ubicacion);
            if (!$ubi) {
                //return response()->json(['message'=>'error', 'codigo' => '500'], 500)->header('code', '500');
            } else {
                $resultado[] = [
                    'nombre' => $ubicacion,
                    'temperatura' => $ubi->temperatura,
                    'temperatura_real' => $ubi->temperatura_real,
                    'sensacion_termica' => $ubi->sensacion_termica,
                    'humedad' => $ubi->humedad,
                    'tiempo' => $ubi->tiempo,
                    'viento' => $ubi->viento,
                    'latitud' => $ubi->latitud,
                    'longitud' => $ubi->longitud,
                    'ultima_actualizacion' => $ubi->ultima_actualizacion
                ];
            }
        }
        return response()->json($resultado);
    }

    public function obtenerUbicaciones()
    {
        $ubicaciones = TiempoActual::All("nombre", "latitud", "longitud");
        return $ubicaciones;
    }
}
