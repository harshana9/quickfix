<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailCarbonCopyPerson;

class EmailCarbonCopyPersonController extends Controller
{
    //Insert CC Person
    /*
    Sample Request Body
    {
        "person":"Jason",
        "email":"email",
        "cc_level":1
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8001/api/ccperson/create

    */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'person' => 'required|string|unique:email_carbon_copy_people',
            'email' => 'required|email',
            'cc_level' => 'in:1,2,3|nullable'
        ]);

        if(is_null($fields["cc_level"])){
            $fields["cc_level"]=1;
        }

        $emailCarbonCopyPerson = EmailCarbonCopyPerson::create([
            'person' => $fields['person'],
            'email' => $fields['email'],
            'cc_level' => $fields['cc_level']
        ]);

        $response = [
            'status'=>201,
            'message'=>'CC Person Create Sucesss'
        ];

        return response($response, 201);
    }

    //View CCPerson
    /*
    Sample URI
    http://192.168.8.185:8000/api/ccperson/view
    
    */
    public function retrive()
	{
        $emailCarbonCopyPerson = EmailCarbonCopyPerson::all();
        $response = [
            'status'=>200,
            'ccperson'=>$emailCarbonCopyPerson
        ];
        
        return response($response, 200);
	}

    //Find ccperson
    /*
    Sample URI
    http://192.168.8.185:8002/api/ccperson/view/1

    */
    public function find($id)
	{
        $emailCarbonCopyPerson = EmailCarbonCopyPerson::find($id);

        if($emailCarbonCopyPerson){
            $response = [
                'status'=>200,
                'ccperson'=>$emailCarbonCopyPerson
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No person for provided person id'
            ];

            return response($response, 204);            
        }
	}

    //Update Controller
    /*
    Sample Request Body
    {
        "person":"Jason",
        "email":"email",
        "cc_level":1
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/ccperson/update/1

    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'person' => 'required|string|unique:email_carbon_copy_people,person,'.$id,
            'email' => 'required|email',
            'cc_level' => 'in:1,2,3|nullable'
        ]);

        $emailCarbonCopyPerson = EmailCarbonCopyPerson::find($id);

        $emailCarbonCopyPerson->person=$request->person;
        $emailCarbonCopyPerson->email=$request->email;
        if(! is_null($request->cc_level)){
            $emailCarbonCopyPerson->cc_level=$request->cc_level;
        }

        $emailCarbonCopyPerson->save();

        $emailCarbonCopyPerson = EmailCarbonCopyPerson::find($id);

        $response=[
            'status'=>200,
            'message'=>'CCPerson Updated Sucesss'
        ];

        return response($response, 200);
    }

    //Delete status
    /*
    Sample URI
    http://192.168.8.185:8000/api/ccperson/delete/1

    */
    public function delete($id)
    {
        $emailCarbonCopyPerson = EmailCarbonCopyPerson::find($id);

        if($emailCarbonCopyPerson){
            $emailCarbonCopyPerson->delete();

            $response = [
                'status'=>200,
                'message'=>'CCPerson delete sucesss'
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No CCPerson for provided CCPerson id'
            ];

            return response($response, 204);
        }
    }
}
