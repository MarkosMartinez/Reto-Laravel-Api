<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApiLugaresController extends Controller
{
    public function register(Request $request){
        $lugares = DB::select('SELECT nombre, lat, long FROM temperaturas_actuales');
        if(isset($lugares)){
            
        }
    }
}
