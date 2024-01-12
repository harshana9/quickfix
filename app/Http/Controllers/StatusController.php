<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Status;


class StatusController extends Controller
{
    //Insert Status
    /*
    Sample Request Body
    {
        "status_name":"email",
        "description":"email sent to vendor",
        "auth_required":false
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8001/api/status/create

    */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'status_name' => 'required|string|unique:statuses',
            'description' => 'string|nullable',
            'auth_required' => 'boolean|nullable'
        ]);

        if(is_null($fields["auth_required"])){
            $fields["auth_required"]=false;
        }

        $status = Status::create([
            'status_name' => $fields['status_name'],
            'description' => $fields['description'],
            'auth_required' => $fields['auth_required']
        ]);

        $response = [
            'status'=>201,
            'message'=>'Status Create Sucesss'
        ];

        return response($response, 201);
    }

    //View Statuss
    /*
    Sample URI
    http://192.168.8.185:8000/api/status/view
    
    */
    public function retrive()
	{
        $status = Status::all();
        $response = [
            'status'=>200,
            'status'=>$status
        ];
        
        return response($response, 200);
	}

    //Find Status
    /*
    Sample URI
    http://192.168.8.185:8002/api/status/view/1

    */
    public function find($id)
	{
        $status = Status::withTrashed()->find($id);

        if($status){
            $response = [
                'status'=>200,
                'status'=>$status
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No status for provided status id'
            ];

            return response($response, 204);            
        }
	}

    //Update Controller
    /*
    Sample Request Body
    {
        "status_name":"email",
        "description":"email sent to vendor",
        "auth_required":false
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/status/update/1

    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_name' => 'required|string|unique:statuses,status_name,'.$id,
            'description' => 'string|nullable',
            'auth_required' => 'boolean|nullable'
        ]);

        if(is_null($request->auth_required)){
            $request->auth_required = false;
        }

        $status = Status::find($id);

        $status->status_name=$request->status_name;
        $status->description=$request->description;
        $status->auth_required=$request->auth_required;

        $status->save();

        $status = Status::find($id);

        $response=[
            'status'=>200,
            'message'=>'Status Updated Sucesss'
        ];

        return response($response, 200);
    }

    //Delete status
    /*
    Sample URI
    http://192.168.8.185:8000/api/status/delete/1

    */
    public function delete($id)
    {
        $status = Status::find($id);

        if($status){
            $status->delete();

            $response = [
                'status'=>200,
                'message'=>'Status delete sucesss'
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No status for provided status id'
            ];

            return response($response, 204);            
        }
    }
}
