<?php

use App\Http\Controllers\AvenueController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\QuartierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Uasoft\Badaso\Helpers\AuthenticatedUser;
use Uasoft\Badaso\Middleware\ApiRequest;
use Uasoft\Badaso\Middleware\BadasoCheckPermissions;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


$api_route_prefix = \config('badaso.api_route_prefix');
Route::group(['prefix' => $api_route_prefix, 'namespace' => 'Uasoft\Badaso\Controllers', 'as' => 'badaso.', 'middleware' => [ApiRequest::class]], function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::group(['prefix' => 'factures'], function () {
            Route::get('/genrate', [FactureController::class, 'gerateFacture']);
            Route::get('/set-consommation', [FactureController::class, 'setConsommation']);
            Route::get('/set-payement', [FactureController::class, 'setPayement']);
            Route::get('/client', [FactureController::class, 'getFactureByClient']);
        });

        Route::group(['prefix' => 'commune'], function () {
            Route::get('/', [CommuneController::class, 'communes']);
        });
        
        Route::group(['prefix' => 'quartier'], function () {
            Route::get('commune', [QuartierController::class, 'quartier']);
            Route::get('avenue', [QuartierController::class, 'avenue']);
        });
        Route::group(['prefix' => 'client'], function () {
            Route::get('/', [ClientController::class, 'index']);
        });
        Route::group(['prefix' => 'avenue'], function () {
            Route::get('facture', [AvenueController::class, 'factureInit']);
        });

    });
});
