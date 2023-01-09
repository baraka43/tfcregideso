<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function communes()
    {
             $commune =  DB::table("communes")->select()->get();
            return [
                'data'=>$commune
            ];
    }


}
