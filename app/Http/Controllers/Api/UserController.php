<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function guardarUbicaciones(Request $request)
{
    $user = Auth::user();
    $ubicaciones = $request->input('ubicaciones');
    if (!$ubicaciones || $ubicaciones == ",") $ubicaciones = "";

    $user->seleccionadas = $ubicaciones;
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Ubicaciones guardadas correctamente'
    ]);
}

public function obtenerUbicaciones(Request $request)
{
    $user = Auth::user();

    if ($user) {
        $ubicaciones = $user->seleccionadas;
        return response()->json([
            'success' => true,
            'ubicaciones' => $ubicaciones
        ]);
    } else {
        return response()->json([
            'success' => false,
            'error' => 'Usuario no autenticado'], 401);
    }
}


}
