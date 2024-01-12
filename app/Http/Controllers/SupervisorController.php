<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BreakdownStatus;
use App\Models\Breakdown;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    //Auth Queue Get
    /*
        Retrive all data with pagination
        http://192.168.8.185:8002/api/supervisor/auth_queue
    */

    public function retrive_all($page_size)
	{
        $records = BreakdownStatus::query();

        $records = $records
        ->with([
            'breakdown' => function ($query) {
                $query->withTrashed()->with('product.vendor');
            },
            'status'
        ])
        ->leftJoin('statuses', 'statuses.id', '=', 'breakdown_statuses.status')
        ->select('*', 'breakdown_statuses.id as log_id')
        ->whereNull('breakdown_statuses.authorize')
        ->where('statuses.auth_required', true);

        //$records = $records->toSql();

        $records = $records->paginate($page_size);

        $response = [
            'status'=>200,
            'breakdown'=>$records
        ];
        
        return response($response, 200);
	}


    /*
        Find single record
        http://192.168.8.185:8002/api/supervisor/auth_queue/find/{id}
    */

    public function find($id)
	{
        $records = BreakdownStatus::query();

        $records = $records
        ->with([
            'breakdown' => function ($query) {
                $query->withTrashed()->with('product.vendor');
            },
            'status'
        ])
        ->leftJoin('statuses', 'statuses.id', '=', 'breakdown_statuses.status')
        ->leftJoin('breakdowns', 'breakdowns.id', '=', 'breakdown_statuses.breakdown')
        ->whereNull('breakdown_statuses.authorize')
        ->where('statuses.auth_required', true)
        ->where('breakdowns.id', $id)
        ->first();

        //$records = $records->toSql();

        $response = [
            'status'=>200,
            'breakdown'=>$records
        ];
        
        return response($response, 200);
	}

    //Auth breakdown
    /*
    Sample URI
    http://192.168.8.185:8000/api/supervisor/auth/1

    ****Importnat****
    Id must be the status id (not breakdown id)

    */
    public function auth($id)
    {
        $breakdown_status = BreakdownStatus::find($id);

        if($breakdown_status){
            $breakdown_status->authorize = Auth::id();
            $breakdown_status->save();

            $response = [
                'status'=>200,
                'message'=>'Authorization Success'
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No status record for provided id'
            ];

            return response($response, 204);
        }
    }
}
