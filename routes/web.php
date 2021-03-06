<?php

use App\Custom\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserController;

use App\Http\Controllers\BicyController;
use App\Http\Controllers\BicyStatusController;
use App\Http\Controllers\BikerAuthController;
use App\Http\Controllers\BikerController;
use App\Http\Controllers\BikerStatusController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TypeBicyController;
use App\Http\Controllers\TypeDocumentController;
use App\Http\Controllers\TypeParkingController;
use App\Http\Controllers\TypeVisitController;
use App\Http\Controllers\UserAppController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\VisitStatusController;
use App\Http\Controllers\CasualController;


use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\AuthsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ParkingMaintenancesController;
use App\Http\Controllers\InventoryBiciesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ProvisionalStickerOrdersController;
use App\Http\Controllers\DetailedStickerOrderController;

use App\Http\Controllers\Auth\QuerierUserController;
use App\Http\Controllers\Auth\VigilantUserController;
use App\Http\Controllers\ServiceSupportController;

use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\WeWantJsonMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'web'], function () {

    Route::middleware(['auth:sanctum', WeWantJsonMiddleware::class])->group(function () {
        Route::get('user', function (Request $request) {
            return $request->user();
        });
        Route::post('checkToken', function (Request $request) {
            return response()->json(['test'=>$request->user()]);
        });

        Route::post('logout', [LoginController::class,'logoutApp']);

        Route::name('type.')->prefix('type')->group(function () {
            Route::resource('bicy', TypeBicyController::class);
            Route::resource('document', TypeDocumentController::class);
            Route::resource('parking', TypeParkingController::class);
            Route::resource('parent', ParentsController::class);
        });

        Route::name('status.')->prefix('status')->group(function () {
            Route::resource('bicy', BicyStatusController::class);
            Route::resource('visit', VisitStatusController::class);
        });

        Route::name('data.')->prefix('data')->group(function () {

            Route::resource('stickers', ProvisionalStickerOrdersController::class)->only(['index','show','store','update']);
            Route::resource('Dstickers', DetailedStickerOrderController::class)->only(['index','show','store','update']);
            Route::resource('permissions', PermissionsController::class)->only(['index','destroy']);
            Route::resource('auths', AuthsController::class)->only(['index','store','destroy']);
            Route::resource('roles', RolesController::class)->only(['index','edit','show','store','destroy']);
            Route::post('roles/asignToUser/{id}', [RolesController::class,'asignToUser']);
            Route::post('roles/revokeToUser/{id}', [RolesController::class,'revokeToUser']);
            Route::post('roles/authRoleTo/{id}', [RolesController::class,'authRoleTo']);
            Route::post('roles/unauthorizeRoleTo/{id}', [RolesController::class,'unauthorizeRoleTo']);
            Route::resource('bicy', BicyController::class)->except(['create']);
            Route::get('bicy/{parking_id}/create',[BicyController::class,'create']);
            Route::post('bicy/{id}', [BicyController::class,'update']);
            Route::post('bicyMassive', [BicyController::class,'massiveStore']);
            Route::resource('maintenance', ParkingMaintenancesController::class);
            Route::get('bicyparking/{id}', [BicyController::class, 'biciesinparking']);

            Route::post('biker/massiveRawMsg', [BikerController::class,'massiveRawTextMessage']);
            Route::resource('biker', BikerController::class);
            Route::post('biker/{id}', [BikerController::class, 'update']);
            Route::post('bikerMassive', [BikerController::class, 'massiveStore']);
            Route::get('biker-excel', [BikerController::class, 'export']);
            Route::get('biker/verificationCode/{phone}', [BikerController::class, 'getVerificationCode'] );
            Route::post('biker/parentVerificationCode/{id}', [ParentsController::class, 'getParentVerificationCode']);
            Route::put('biker/{id}/unblock', [BikerController::class, 'unblockBiker']);

            Route::resource('gender', GenderController::class);
            Route::resource('job', JobController::class);
            Route::resource('neighborhood', NeighborhoodController::class);
            Route::resource('level', LevelController::class);
            Route::resource('parking', ParkingController::class);
            Route::resource('station', StationController::class);
            Route::resource('visit', VisitController::class);
            Route::resource('young', BikerAuthController::class);
            Route::resource('inventory', InventoryController::class);
            Route::resource('inventoryBicy', InventoryBiciesController::class)->only(['store','destroy']);

            //Mesa de ayuda
            Route::resource('servicesupport', ServiceSupportController::class);
            Route::put('servicesupport/updateSelect/{id}/{status}', [ServiceSupportController::class, 'updateSelect']);

            //Report
            Route::post('reports',[ReportsController::class, 'show']);
            Route::get('reports/visits/dailyByMonths',[ReportsController::class, 'dailyVisitsByMonths']);
            Route::get('reports/visits/generalBikerByMonths',[ReportsController::class, 'generalBikerVisitsByMonths']);
            Route::get('reports/visits/detailedBikerByMonths',[ReportsController::class, 'detailedBikerVisitsByMonths']);
            Route::get('reports/visits/hourlyByDays',[ReportsController::class, 'hourlyVisitsByDays']);
            Route::get('reports/visits/abandonedBicies',[ReportsController::class, 'visitAbandonedBicies']);
            Route::get('reports/visits/webMapService',[ReportsController::class, 'webMapService']);
            Route::get('reports/visits/pernoctas',[ReportsController::class, 'pernoctas']);
        });

        Route::name('user.')->group(function(){
            Route::resource('user',UserController::class);
            Route::resource('vigilant',VigilantUserController::class);
            Route::resource('querier',QuerierUserController::class);
        });

     });

    Route::post('/login', [LoginController::class, 'loginApp']);
    Route::get('restorePasswordCode',[UserController::class,'getRestorePasswordCode'] );
    Route::put('restorePassword',[UserController::class,'restorePassword'] );
});

Route::get('/{any}', [SpaController::class, 'index'])->where('any', '.*');
