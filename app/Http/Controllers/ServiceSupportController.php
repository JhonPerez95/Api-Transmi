<?php

namespace App\Http\Controllers;

use App\Models\Service_support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use DateTime;

use Illuminate\Support\Facades\Validator;

class ServiceSupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $services = DB::table('service_supports')
                ->join('parkings','service_supports.parkings_id','parkings.id')
                ->join('users','service_supports.users_id','users.id')
                ->select('service_supports.id AS service_supports_id',
                                 'users.id AS user_id',
                                 'users.name AS user_name',
                                 'users.last_name AS user_last_name',
                                 'parkings.id AS parking_id',
                                 'parkings.name AS parking_name',
                                 'service_supports.id AS identificador',
                                 'service_supports.title AS title',
                                 'service_supports.description AS description',
                                 'service_supports.status AS status',
                                 'service_supports.answer AS answer',
                                 'service_supports.created_at AS created_at',
                )->get()->toArray();

            $dataServices = array();
            foreach($services as $s => $service) {
                $outService = array();
                $outService['service_supports_id'] = $service->service_supports_id;
                $outService['user_id'] = $service->user_id;
                $outService['user_name'] = $service->user_name . $service->user_last_name;
                $outService['parking_id'] = $service->parking_id;
                $outService['parking_name'] = $service->parking_name;
                $outService['title'] = $service->title;
                $outService['description'] = $service->description;
                $outService['status'] = $service->status;
                $outService['answer'] = $service->answer;
                $outService['created_at'] = substr($service->created_at, 0, 10);
                $outService['time'] = substr($service->created_at, 10, 9);

                $dataServices[] = $outService;
            }

            return response()->json(['message' => 'Success', 'response' => ['data' => $dataServices, 'errors' => [] ] ],200);
        } catch (QueryException $th) {
            Log::emergency($th);
            return response()->json(['message' => 'Internal Error', 'response' => ["errors" => [$th->getMessage()]]], 500);
        }
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
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = [
            "rules" => [
                'parking_id'  => 'required',
                'users_id'    => 'required',
                'title'       =>  'required',
                'description' => 'required',
            ],
            "messages" => [
                'parking_id.required'  => 'El campo parqueadero es requerido',
                'users_id.required'    => 'El campo usuario es requerido',
                'title.required'       => 'El campo titulo es requerido',
                'description.required' => 'El campo parqueadero es requerido',
            ],
        ];

        $validator = Validator::make($request->all(), $validation['rules'], $validation['messages']);

        if ($validator->fails()) {
            return response()->json(['response' => ['errors'=>$validator->errors()->all()], 'message' => 'Bad Request'], 400);
        }

        try {

            $service_return = Service_support::create([
                'parkings_id' => $request->parking_id,
                'users_id' => $request->users_id,
                'title' => $request->title,
                'description' => $request->description,
                'status' => 1
            ]);

            return response()->json(['message' => 'Success', 'response' => $service_return->id ],200);
        } catch (QueryException $th) {
            Log::emergency($th);
            return response()->json(['response' => ['errors' => [$th->getMessage()]], 'message' => 'Internal Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service_support  $service_support
     * @return \Illuminate\Http\Response
     */
    public function show(Service_support $service_support)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service_support  $service_support
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(Service_support::whereId($id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  \App\Models\Service_support  $service_support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Service_support::find($id);

            if (!$data) {
                return response()->json(['message' => 'Not Found', 'response' => ['id' => $request->id]], 404);
            }

            $data->status = $request->status;
            $data->answer = $request->answer;
            $data->update();
            return response()->json(['message' => 'Success', 'response' => ["data" => 'Actualizado Correctamente', "errors" => [] ] ], 200);

        } catch (QueryException $th){
            Log::emergency($th);
            return response()->json(['response' => ['errors' => [$th->getMessage()]], 'message' => 'Internal Error'], 500);
        }

    }

    /**
     * Update the status of Services help
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @param  \App\Models\Service_support  $service_support
     * @return \Illuminate\Http\Response
     */
    public function updateSelect(Request $request, $id, $status)
    {
        try {
            $data = Service_support::find($id);

            if (!$data) {
                return response()->json(['message' => 'Not Found', 'response' => ['id' => $id]], 404);
            }

            $data->status = $status;
            $data->update();
            return response()->json(['message' => 'Success', 'response' => ["data" => 'Actualizado Correctamente', "errors" => [] ] ], 200);

        } catch (QueryException $th){
            Log::emergency($th);
            return response()->json(['response' => ['errors' => [$th->getMessage()]], 'message' => 'Internal Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service_support  $service_support
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service_support $service_support)
    {
        //
    }
}
