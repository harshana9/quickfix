<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Breakdown;
use App\Models\BreakdownStatus;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\MerchantAlertController;

class BreakdownController extends Controller
{
    //Insert Breakdown
    /*
    Sample Request Body
    {
        "mid":"333",
        "merchant":"JhonDoe",
        "tid":"353535",
        "contact1":"011234535",
        "contact2":null,
        "email":"jhondoe@email.com",
        "error":"Not chraging",
        "product":"1"
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/breakdown/create

    */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'mid' => 'required|integer',
            'merchant' => 'required|string',
            'tid' => 'required|integer',
            'contact1' => 'required|string',
            'contact2' => 'string|nullable',
            'email' => 'email',
            'error' => 'string',
            'product' => 'required|exists:products,id'
        ]);

        $breakdown = Breakdown::create([
            'mid' => $fields['mid'],
            'merchant' => $fields['merchant'],
            'tid' => $fields['tid'],
            'contact1' => $fields['contact1'],
            'contact2' => $fields['contact2'],
            'email' => $fields['email'],
            'error' => $fields['error'],
            'product' => $fields['product']
        ]);

        //Find saved item with vendor data
        $breakdown = Breakdown::with('product')->with('product.vendor')->find($breakdown->id)->toArray();

        //Create Log
        $breakdownStatus = BreakdownStatus::create([
            'breakdown' => $breakdown['id'],
            'user' => Auth::id(),
            'status' => 1,
            'remark' => "Log by System auto"
        ]);

        //Send Email
        //to Vendor
        $data = ['title'=>'POS Issue', 'breakdown'=>$breakdown, 'user'=>auth()->user()->first_name];
        
        $cc_list = array();
        array_push($cc_list, $breakdown["product"]["vendor"]["cc_email_1"]);
        array_push($cc_list, $breakdown["product"]["vendor"]["cc_email_2"]);
        array_push($cc_list, $breakdown["product"]["vendor"]["cc_email_3"]);

        $pHPMailerController = new PHPMailerController;
        $email_sts = $pHPMailerController->composeEmail(
            $breakdown["product"]["vendor"]["main_email"],
            $cc_list,
            null,
            "POS Issue",
            view("bd_info_to_vendor_email", $data)
        );

        //To merchnat
        $merchantAlertController = new MerchantAlertController;
        $merchantAlertController->status_update_email($breakdown['id']);

        $response = [
            'status'=>201,
            'message'=>'Breakdown Create Sucesss',
            'breakdown' => $breakdown,
            'email' =>  $email_sts
        ];

        return response($response, 201);
    }

    /*
        Retrive data with pagination and search key
        http://192.168.8.185:8000/api/breakdown/search/{page_size}/{status}/{keyword}
    */

    public function retrive($page_size,$status,$keyword)
	{
        $breakdown = BreakdownStatus::query();

        $breakdown = $breakdown
        ->with('breakdown')
        ->with('status')
        ->with('breakdown.product')
        ->with('breakdown.product.vendor');

        $breakdown = $breakdown->leftJoin('breakdowns', 'breakdowns.id', '=', 'breakdown_statuses.breakdown')
        ->where(function ($query) use($keyword) {
            $query
                ->where('breakdowns.merchant', 'like', '%' . $keyword . '%')
                ->orWhere('breakdowns.tid', $keyword)
                ->orWhere('breakdowns.mid', $keyword);
          });

        if($status!="all"){
            $breakdown = $breakdown->where('breakdown_statuses.status',$status);
        }
        else{
            $breakdown = $breakdown->where('breakdown_statuses.status', "!=", '3');//exclude compleated
        }
        
        $breakdown = $breakdown->where('breakdown_statuses.status', "!=", '2');//exclude deletd
        $breakdown = $breakdown->paginate($page_size);

        $response = [
            'status'=>200,
            'breakdown'=>$breakdown
        ];

        return response($response, 200);
	}
    

    /*
        Retrive all data with pagination
        http://192.168.8.185:8000/api/breakdown/search/result_per_page/status
    */

    public function retrive_all($page_size, $status)
	{
        $breakdown = BreakdownStatus::query();

        $breakdown = $breakdown
        ->with('breakdown')
        ->with('status')
        ->with('breakdown.product')
        ->with('breakdown.product.vendor');

        if($status!="all"){
            $breakdown = $breakdown->where('breakdown_statuses.status',$status);
        }
        else{
            $breakdown = $breakdown->where('breakdown_statuses.status', "!=", '3');//exclude compleated
        }
        $breakdown = $breakdown->where('breakdown_statuses.status', "!=", '2');//exclude deleted
        //$breakdown = $breakdown->toSql();
        
        $breakdown = $breakdown->paginate($page_size);

        $response = [
            'status'=>200,
            'breakdown'=>$breakdown
        ];
        
        return response($response, 200);
	}

    //Find Breakdown
    /*
    Sample URI
    http://192.168.8.185:8000/api/breakdown/view/1

    */
    public function find($id)
	{
        //$breakdown = Breakdown::with('product')->with('product.vendor')->withTrashed()->find($id);

        $breakdown = BreakdownStatus::
        with('breakdown')
        ->with('status')
        ->with('breakdown.product')
        ->with('breakdown.product.vendor')
        ->leftJoin('breakdowns', 'breakdowns.id', '=', 'breakdown_statuses.breakdown')
        ->where('breakdowns.id',$id)
        ->first();
        //->toSql();

        if($breakdown){
            $response = [
                'status'=>200,
                'breakdown'=>$breakdown
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No breakdown for provided breakdown id'
            ];

            return response($response, 204);            
        }
	}


    //Delete breakdown
    /*
    Sample URI
    http://192.168.8.185:8000/api/breakdown/delete/1

    */
    public function delete($id)
    {
        $breakdown = Breakdown::find($id);

        if($breakdown){
            $breakdown->delete();

            //Delete Last Log Record
            $lastStatus = BreakdownStatus::where('breakdown', $breakdown->id)->first();

            if($lastStatus){
                $lastStatus->delete();
            }

            //Create Log
            $breakdownStatus = BreakdownStatus::create([
                'breakdown' => $breakdown['id'],
                'user' => Auth::id(),
                'status' => 2,
                'remark' => "Log by System auto"
            ]);

            $response = [
                'status'=>200,
                'message'=>'Breakdown delete sucesss',
                'breakdown' => $breakdown
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No breakdown for provided breakdown id'
            ];

            return response($response, 204);            
        }
    }


    //Log update
    /*
    Sample URI
    http://192.168.8.185:8000/api/breakdown/status_update/{id}

    
    Sample Requst Body
    {
        "status":"3",
        "remark":"Waiting for replacement to arrive",
        "notify_vendor":true
    }

    */
    public function status_update(Request $request, $id)
    {
        $fields = $request->validate([
            'status' => 'required|exists:statuses,id',
            'remark' => 'nullable|string',
            'notify_vendor' => 'boolean|nullable'
        ]);

        if(is_null($fields["notify_vendor"])){
            $fields["notify_vendor"]=false;
        }

        $breakdown = Breakdown::find($id);

        if($breakdown){
            //Delete Last Log Record
            $lastStatus = BreakdownStatus::where('breakdown', $breakdown->id)->first();

            if($lastStatus){
                $lastStatus->delete();
            }

            //Create Log
            $breakdownStatus = BreakdownStatus::create([
                'breakdown' => $breakdown['id'],
                'user' => Auth::id(),
                'status' => $fields['status'],
                'remark' => $fields['remark']
            ]);

            //Send Email
            //To merchnat
            $merchantAlertController = new MerchantAlertController;
            $merchantAlertController->status_update_email($breakdown['id']);

            if($fields["notify_vendor"]){
                //To Vendor
                $merchantAlertController->status_update_email_to_vendor($breakdown['id']);
            }
            
            $response = [
                'status'=>200,
                'message'=>'Breakdown status updated',
                'breakdown' => $breakdown
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No breakdown for provided breakdown id'
            ];

            return response($response, 204);            
        }
    }


    //Log History
    /*
        Retrive data with pagination and search key
        http://192.168.8.185:8000/api/breakdown/log_history/{breakdown_id}
    */

    public function log_history($breakdown_id)
	{
        $log = BreakdownStatus::query();

        $log = $log
        ->with('status')
        ->with('user')
        ->with('authorize')
        ->where('breakdown', $breakdown_id)
        ->get();
        //->toSql();

        $response = [
            'status'=>200,
            'breakdown'=>$log
        ];

        return response($response, 200);
	}
}
