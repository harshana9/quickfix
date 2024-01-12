<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Breakdown;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /*
        http://192.168.8.185:8002/api/reports/frequents/pdf

        {
            "find":"tid"
            "times":"2",
            "date_from":"2023-12-14",
            "date_to":"2023-12-28",
            "order_by_1":"mid",
            "order_by_2":"tid",
            "order_by_1_order":"ASC",
            "order_by_2_order":"DESC"
        }

        explain:
        'find':tid s which breaks more than or equal to 2 times in given date ranage 
    */


    /*
    Order by options

    `mid`
    `merchant`
    `tid`
    */

    public function generatePDF(Request $request) {
        $fields = $request->validate([
            'find' => 'in:mid,tid|required',
            'times' => 'required|integer',
            'date_from' => 'date|nullable',
            'date_to' => 'date|nullable',

            'order_by_1' => 'in:mid,tid,merchant|nullable',
            'order_by_2' => 'in:mid,tid,merchant|nullable',
            'order_by_1_order' => 'in:ASC,DESC|required',
            'order_by_2_order' => 'in:ASC,DESC|required'
        ]);

        $col_name =$fields['find'];
        $times_per_period = $fields['times'];

        $results = Breakdown::query();
        $request = $results->with('product');
        $request = $results->with('product.vendor');
        $results = $results->select('breakdowns.*')
            ->from('breakdowns')
            ->join(DB::raw('(SELECT s.'.$col_name.'
                           FROM breakdowns as s
                           GROUP BY s.'.$col_name.'
                           HAVING COUNT(1) >= '.$times_per_period.'
                       ) as d'), function ($join) use ($col_name) {
                        $join->on("d.{$col_name}", '=', 'breakdowns.'.$col_name);
                    });

        if(isset($fields['date_from'])){
            if(! is_null($fields['date_from'])){
                $results = $results->where('breakdowns.created_at', ">=", $fields['date_from']);
            }
        }
        if(isset($fields['date_to'])){
            if(! is_null($fields['date_to'])){
                $results = $results->where('breakdowns.created_at', "<=", $fields['date_to']);
            }
        }

        if(isset($fields['order_by_1'])){
            if(! is_null($fields['order_by_1'])){
                $results = $results->orderBy($fields['order_by_1'], $fields['order_by_1_order']);
            }
        }

        if(isset($fields['order_by_2'])){
            if(! is_null($fields['order_by_2'])){
                $results = $results->orderBy($fields['order_by_2'], $fields['order_by_2_order']);
            }
        }

        
        $results = $results->get();

        $results = $results->toArray();

        $nowtime = Carbon::now();
        $nowtime->toDateTimeString();

        $data = array("title"=>"Frequent Breakdowns Report", "date"=>$nowtime, "dataset"=>$results);

       //print_r($data);

       $pdf = PDF::loadView('frequent_report', $data)->setPaper('a4', 'portrait');

       return $pdf->download('Frequent_Breakdowns.pdf');

       /*$response=[
        'status'=>200,
        'message'=>'Product Updated Sucesss',
        'product'=>$results
        ];

        return response($response, 200);*/


   }
}
