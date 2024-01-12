<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BreakdownStatus;
use App\Models\EmailCarbonCopyPerson;
use Carbon\Carbon;
use App\Http\Controllers\PHPMailerController;

class SheduleController extends Controller
{
    public function two_day_late_email() {
        //Get Uncompleated Records Older than 2 Days
        $breakdown = BreakdownStatus::with('breakdown')
            ->with('status')
            ->with('breakdown.product')
            ->with('breakdown.product.vendor')
            ->where('breakdown_statuses.status', "!=", 3)
            ->where('created_at', '<=', Carbon::now()->subSeconds(2)->toDateTimeString())
            //->toSql();
            ->get()
            ->toArray();

        //Get email auth level 2 CC people
        $people = EmailCarbonCopyPerson::where('cc_level', '2')->get();

        //Send emails
        $sent_recs = array();
        $all_email_list = array();
        if($breakdown){
            if($people){
                foreach ($breakdown as $record) {
                    //all email list
                    foreach($people as $person){
                        array_push($all_email_list, $person['email']);
                    }

                    //cclist
                    $cclist=null;
                    if(count($people)>1){
                        $cclist=array();
                        for ($i=1; $i < count($people); $i++) { 
                            array_push($cclist, $people[$i]['email']);
                        }
                    }

                    //Send Email
                    $data = ['period'=>'2 Days', 'breakdown'=>$record['breakdown'], 'status'=>$record['status'],'user'=>'System'];

                    $pHPMailerController = new PHPMailerController;
                    $email_sts = $pHPMailerController->composeEmail(
                        $people[0]['email'],
                        $cclist,
                        null,
                        "Breakdown Complaint Late Alert",
                        view("urgent_alert_to_authority", $data)
                    );

                    array_push($sent_recs, $record['breakdown']['id']);
                }
            }
        }

        $response = [
            'status'=>200,
            'message'=>'Sheduled Task Executed.',
            'records' => $sent_recs,
            'mail_list'=> $all_email_list
        ];

        return response($response, 200);
    }
}
