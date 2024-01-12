<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Breakdown;
use App\Models\Status;
use App\Models\BreakdownStatus;
use App\Http\Controllers\PHPMailerController;

class MerchantAlertController extends Controller
{
    //Merchant Email Alert update
    /*
    Sample URI
    http://192.168.8.185:8002/api/manual/merchant_alert/3

    */
    public function status_update_email($id)
    {

        $breakdown = Breakdown::find($id);

        $breakdown = BreakdownStatus::with('breakdown')
        ->with('status')
        ->with('breakdown.product')
        ->with('breakdown.product.vendor')
        ->leftJoin('breakdowns', 'breakdowns.id', '=', 'breakdown_statuses.breakdown')
        ->where(function ($query) use($id) {
            $query
                ->where('breakdowns.id',$id);
        })
        ->first()
        ->toArray();

        if($breakdown){

            //Send Email
            $data = ['title'=>'Breakdown Complaint Update', 'breakdown'=>$breakdown['breakdown'], 'status'=>$breakdown['status'],'user'=>auth()->user()->first_name];

            $pHPMailerController = new PHPMailerController;
            $email_sts = $pHPMailerController->composeEmail(
                $breakdown["email"],
                null,
                null,
                "Breakdown Complaint Update",
                view("status_alert_to_merchant", $data)
            );

            $response = [
                'status'=>200,
                'message'=>'Alert sent to Merchant',
                'email' => $email_sts
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


    //Vendor Email Alert update
    /*
    Sample URI
    http://192.168.8.185:8002/api/manual/vendor_alert/3
    */
    public function status_update_email_to_vendor($id)
    {

        $breakdown = Breakdown::find($id);

        $breakdown = BreakdownStatus::with('breakdown')
        ->with('status')
        ->with('breakdown.product')
        ->with('breakdown.product.vendor')
        ->leftJoin('breakdowns', 'breakdowns.id', '=', 'breakdown_statuses.breakdown')
        ->where(function ($query) use($id) {
            $query
                ->where('breakdowns.id',$id);
        })
        ->first()
        ->toArray();

        if($breakdown){

            //Send Email
            $data = ['title'=>'Breakdown Complaint Status Update', 'breakdown'=>$breakdown['breakdown'], 'status'=>$breakdown['status'], 'remark'=>$breakdown['remark'],'user'=>auth()->user()->first_name];

            $cc_list = array();
            array_push($cc_list, $breakdown["breakdown"]["product"]["vendor"]["cc_email_1"]);
            array_push($cc_list, $breakdown["breakdown"]["product"]["vendor"]["cc_email_2"]);
            array_push($cc_list, $breakdown["breakdown"]["product"]["vendor"]["cc_email_3"]);

            $pHPMailerController = new PHPMailerController;
            $email_sts = $pHPMailerController->composeEmail(
                $breakdown["breakdown"]["product"]["vendor"]["main_email"],
                $cc_list,
                null,
                "Breakdown Complaint Status Update",
                view("status_info_to_vendor_email", $data)
            );

            $response = [
                'status'=>200,
                'message'=>'Alert sent to Vendor',
                'email' => $email_sts
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
}
