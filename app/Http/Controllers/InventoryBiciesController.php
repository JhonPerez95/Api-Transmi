<?php

namespace App\Http\Controllers;

use App\Models\Bicy;
use App\Models\Inventory;
use App\Models\InventoryBicy;
use App\Models\Visit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InventoryBiciesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //log::info($request->all());

        $validation = [
            "rules" => [
                'inventories_id' => 'required|exists:inventories,id',
                'bicies_code' => 'required',
            ],
            "messages" => [
                'bicies_code.required' => 'El campo código de bicicleta(s) es requerido',
                'inventories_id.required' => 'El campo inventario es requerido',
                'inventories_id.exists' => 'El campo inventario no acerta ningún registro existente',
            ]
        ];

        $biciesIndexedById = [];
        try {

            $validator = Validator::make($request->all(), $validation['rules'], $validation['messages']);
            if ($validator->fails()) {
                return response()->json(['message' => 'Bad Request', 'response' => ['errors'=>$validator->errors()->all()]], 400);
            }

            $inventory = Inventory::find($request->inventories_id);

            // Inventory already closed/finished
            if(!$inventory->active) {
                return response()->json(['message' => 'Bad Request', 'response' => ['errors'=>['El inventario especificado ya ha sido cerrado.']]], 400);
            }

            $bicies = explode(',', $request->bicies_code);
            $success = [];
            $error = [];
            $cont = 0;
            $idBicies = [];
            foreach($bicies as $bicy) {

                if(array_key_exists($bicy,$error)  || array_key_exists($bicy,$success)){ continue; }

                $Bicy = Bicy::where('code',$bicy)->first();
                if(!$Bicy){
                    $error[$bicy] = 'Registro de bicicleta no encontrado'; continue;
                }

                $exists = InventoryBicy::where(['inventory_id' => $request->inventories_id, 'bicies_id'=>$Bicy->id]);
                if($exists->count()){
                    $error[$bicy] = 'La bicicleta ya se ha encuentra en el inventario recibido.'; continue;
                }

                $biciesIndexedById[$Bicy->id] = $Bicy;
                $idBicies[] = $Bicy->id;
                $inventoryBicy = InventoryBicy::create([ 'inventory_id' => $request->inventories_id, 'bicies_id' => $Bicy->id, ]);

                if($inventoryBicy->id){
                   $success[$bicy] = $inventoryBicy;
                   $cont++;
                }else{
                    $error[$bicy] = 'Error inesperado al guardar.';
                }
            }

            $totalRegistered = $cont;

            # Ciclas que registró el vigilante pero tienen visita activa en la app
            $nonActiveButRegistered = [];
            foreach($biciesIndexedById as $bike) {
                $visit = Visit::where([ 'parkings_id' => $inventory->parkings_id, 'bicies_id' => $bike->id, 'duration' => 0 ])->get();

                if(!$visit->count()){
                    $nonActiveButRegistered[] = $bike->id;
                }
            }

            # Consultamos todas las visitas activas de este cicloparqueadero
            $activeVisits = []; //Visitas activas
            $visits = Visit::where(['parkings_id' => $inventory->parkings_id, 'duration' => 0 ])->get(); //Ciclas con visita activa
            $countVisits = 0;
            foreach($visits as $visit){
                $currentBicy = $visit->bicies_id;
                $activeVisits[] = $currentBicy;
                $countVisits++;
            }

            $activeButNotRegistered = [];
            # Sacamos la difererencia de las ciclas que tienen una visita activa en la app pero el vigilante no escaneo
            $results = array_diff($activeVisits, $idBicies);
            foreach($results as $result){
                $activeButNotRegistered[] = $result;
            }

//            # Las ciclas que tienen una visita activa en la app pero el vigilante no registró
//            $activeButNotRegistered = [];
//            $visits = Visit::where(['parkings_id' => $inventory->parkings_id, 'duration' => 0 ])->get();
//            foreach($visits as $visit){
//                $currentBicy = $visit->bicies_id;
//                $activeButNotRegistered[] = $currentBicy;
//            }

            $inventory->totalRegistered = $totalRegistered;
            $inventory->nonActiveButRegistered = json_encode($nonActiveButRegistered);
            $inventory->activeButNotRegistered = json_encode($activeButNotRegistered);
            $inventory->codesInventoried = json_encode($idBicies);
            $inventory->active = '0';
            $inventory->save();

            //return response()->json(['message'=>count($success) ? 'Success' : 'Bad Request', 'response'=>['data'=>$success, 'errors'=>$error]], count($success) ? 201 : 400 );
            return response()->json(['message'=>'Success', 'response'=>['data'=>['inventory' => $inventory], 'errors'=>[]]],200);

        } catch (QueryException $ex) {
            return response()->json(['message' => 'Internal Error', 'response' => ['errors'=>$ex->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return response()->json(['message'=>'Not Found', 'response'=>['errors'=>['Método no encontrado.']]],404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $invBicy = InventoryBicy::find($id);
        if(!$invBicy){
            return response()->json(['message'=>'Not Found', 'response'=>['errors'=>['El registro bicicleta en inventario no ha sido encontrado']]],404);
        }

        if($invBicy->inventory->active == '0'){
            return response()->json(['message'=>'Bad Request', 'response'=>['errors'=>['El inventario ya ha sido cerrado']]],400);
        }

        $invBicy->delete();

        return response()->json(['message'=>'Success', 'response'=>['errors'=>[]]],200);
    }
}
