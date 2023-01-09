<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\BadasoBaseController;
use Uasoft\Badaso\Helpers\AuthenticatedUser;
use Uasoft\Badaso\Helpers\Config;

class FactureController extends BadasoBaseController
{
    public function gerateFacture()
    {
        DB::beginTransaction();
        $clients =  DB::table('clients')->select()->get();
        $nbr_facture = DB::table('factures')->select()
            ->where("annee", Config::get("currentYear"))
            ->where("mois", Config::get("currentMonth"))
            ->count('id');

        if ($nbr_facture == 0) {
            foreach ($clients as $key => $client) {
                DB::table('factures')->insert([
                    'client_id' => $client->id,
                    'etat' => 'intial',
                    'mois' => Config::get("currentMonth"),
                    'annee' => Config::get("currentYear"),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        DB::commit();

        return DB::table('factures')->select()->get();
    }

    public function setConsommation(Request $request)
    {
        DB::beginTransaction();
        $factures = $this->getFacture($request->idFacture)[0];

        $test = DB::table('factures')
            ->where('id', $request->idFacture)
            ->update([
                'consommation_mensuelle' => $request->consommation,
                'etat' => 'non_payé',
                'montant' => $factures->prix * $request->consommation
            ]);
        DB::commit();
    }

    public function setPayement(Request $request)
    {
        DB::beginTransaction();
        $factures = $this->getFacture($request->facture_id)[0];
        $pay = DB::table('paiements')->insert([
            'user_id' => AuthenticatedUser::getUser()->id,
            'facture_id' => $request->facture_id,
            'montant' => $factures->montant,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $test = DB::table('factures')
            ->where('id', $request->facture_id)
            ->update([
                'etat' => 'payé',
                'updated_at' => now()
            ]);
        DB::commit();
    }

    public function getFactureByClient(Request $request){

        $idClient =  $request->client_id  ? $request->client_id : 0;
        $factures = [];
        $factures = DB::select("SELECT  factures.*,factures.id as facture_id, clients.*,clients.id as client_id, categories.*, categories.designation as categorie FROM factures  
                                INNER JOIN clients ON factures.client_id = clients.id
                                INNER JOIN categories ON categories.id = clients.categorie_id
                                WHERE    clients.id = $idClient");

        return [
            "data" => $factures
        ];
    
    }

    public function getFacture($id)
    {

        $factures = [];
        $factures = DB::select("SELECT  factures.*,factures.id as facture_id, clients.*, categories.*, categories.designation as categorie FROM factures  
                                INNER JOIN clients ON factures.client_id = clients.id
                                INNER JOIN categories ON categories.id = clients.categorie_id
                                WHERE    factures.id = $id");
        return $factures;
    }
}
