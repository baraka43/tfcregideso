<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $idAvenue = $request->avenue_id;
        $factures = [];
        $factures = DB::select("SELECT  categories.designation as categorie, clients.*, factures.*, categories.*, count(factures.id) as nbr_facture FROM clients 
        LEFT JOIN categories ON categories.id = clients.categorie_id
        left JOIN factures ON factures.client_id = clients.id
        where clients.avenue_id = $idAvenue
        GROUP BY clients.id 
        ");

        return [
            "data" => $factures
        ];
    }
}
