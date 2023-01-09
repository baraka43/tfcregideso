<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvenueController extends Controller
{
    public function factureInit(Request $request)
    {
        $idAvenue =  $request->idAvenue  ? $request->idAvenue : 0;
        $factures = [];
        $factures = DB::select("SELECT  factures.*,factures.id as facture_id, clients.*, categories.*, categories.designation as categorie FROM factures  
                                INNER JOIN clients ON factures.client_id = clients.id
                                INNER JOIN categories ON categories.id = clients.categorie_id
                                WHERE    clients.avenue_id = $idAvenue");

        return [
            "data" => $factures
        ];
    }
}
