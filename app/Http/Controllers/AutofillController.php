<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Breakdown;

class AutofillController extends Controller
{
    //Find by MID
    /*
    Sample URI
    http://192.168.8.185:8002/api/autofill/mid/1

    */
    public function find_by_mid($mid)
	{
        $breakdown = Breakdown::where('breakdowns.mid',$mid)->first();
        //->toSql();

        if($breakdown){
            $response = [
                'status'=>200,
                'breakdown'=>$breakdown
            ];

            return response($response, 200);
        }
	}

    //Find by MID
    /*
    Sample URI
    http://192.168.8.185:8002/api/autofill/tid/1

    */
    public function find_by_tid($tid)
	{
        $breakdown = Breakdown::where('breakdowns.tid',$tid)->first();
        //->toSql();

        if($breakdown){
            $response = [
                'status'=>200,
                'breakdown'=>$breakdown
            ];

            return response($response, 200);
        }
	}
}
