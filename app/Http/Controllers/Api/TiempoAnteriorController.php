<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TiempoAnterior;
use Carbon\Carbon;

class TiempoAnteriorController extends Controller
{
     /**
     * Devolver hitorico de temperaturas en rango de tiempo
     */
    

    public function devolver_historico(Request $request)
    {
        // Obtener las fechas de inicio y fin del rango
        $fechaInicio = Carbon::parse($request->input('fecha_inicio'));
        $fechaFin = Carbon::parse($request->input('fecha_fin'));

        // Realizar la consulta a la base de datos
        $temperaturas = TiempoAnterior::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->select('Nombre', 'temperatura', 'fecha')
            ->get();

        // Devolver las temperaturas encontradas
        return response()->json($temperaturas);
    }

    /**
     * Simplificar los datos si hay demasiados
     */
    public function simplificar_historico()
    {
        
    }
}
