<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuartierController extends Controller
{
    public function quartier(Request $request)
    {
       
        $quartiers = DB::table('quartiers')->select()->where("commune_id", $request->idCommune)->get();
        return [
            "data" => $quartiers
        ];
    }

    public function avenue(Request $request)
    {
       
        $quartiers = DB::table('avenues')->select()->where("quartier_id", $request->idQuartier)->get();
        return [
            "data" => $quartiers
        ];
    }
}
