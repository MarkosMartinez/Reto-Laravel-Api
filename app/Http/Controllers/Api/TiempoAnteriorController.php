<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TiempoAnterior;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TiempoAnteriorController extends Controller
{
     /**
     * Devolver hitorico de temperaturas en rango de tiempo
     */

     public function devolver_historico(Request $request)
    {
        $fechaInicio = Carbon::parse($request->input('fecha_inicio'));
        $fechaFin = Carbon::parse($request->input('fecha_fin'));

        // Calcular la diferencia en horas, días y meses
        $diferenciaHoras = $fechaInicio->diffInHours($fechaFin);
        $diferenciaDias = $fechaInicio->diffInDays($fechaFin);
        $diferenciaMeses = $fechaInicio->diffInMonths($fechaFin);

        if ($diferenciaMeses >= 4) {
            $temperaturas = TiempoAnterior::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->groupBy(DB::raw('DATE_FORMAT(fecha, "%Y-%m-01")'), "nombre")
            ->select("nombre", DB::raw('ROUND(AVG(temperatura), 2) as temperatura'), DB::raw('DATE_FORMAT(fecha, "%Y-%m-01") as fecha'))
            ->get();

        } elseif ($diferenciaMeses >= 1) {
            $temperaturas = TiempoAnterior::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->groupBy(DB::raw('YEARWEEK(fecha, 1)'), "nombre")
            ->select("nombre", DB::raw('ROUND(AVG(temperatura), 2) as temperatura'), DB::raw('DATE_FORMAT(MIN(fecha), "%Y-%m-%d %H:%i") as fecha'))
            ->get();
        } elseif ($diferenciaDias >= 2) {
            $temperaturas = TiempoAnterior::whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->groupBy("nombre", DB::raw('DATE_FORMAT(fecha, "%Y-%m-%d 00:00")'))
                ->select("nombre", DB::raw('ROUND(AVG(temperatura), 2) as temperatura'), DB::raw('DATE_FORMAT(MIN(fecha), "%Y-%m-%d %H:%i") as fecha'))
                ->get();
        } elseif ($diferenciaHoras > 2) {
            $temperaturas = TiempoAnterior::whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->groupBy("nombre", DB::raw('DATE_FORMAT(fecha, "%Y-%m-%d %H:00")'))
                ->select("nombre", DB::raw('ROUND(AVG(temperatura), 2) as temperatura'), DB::raw('DATE_FORMAT(MIN(fecha), "%Y-%m-%d %H:%i") as fecha'))
                ->get();
        } else {
            // Consulta para devolver los registros cada 15 minutos (predeterminado)
            $temperaturas = TiempoAnterior::whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->select('Nombre', 'temperatura', 'fecha')
                ->get();
        }

        return response()->json($temperaturas);
    }     

}
