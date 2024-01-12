<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    //Insert Vendor
    /*
    Sample Request Body
    {
        "name":"JandJ",
        "main_email":"main_email@email.com",
        "cc_email_1":"cc1@email.com",
        "cc_email_2":"cc2@email.com",
        "cc_email_3":"cc3@email.com",
        "contact_1":"0464646464",
        "contact_2":"4646533535",
        "address":"jandj, Landon."
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/vendor/create

    */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'main_email' => 'required|email|unique:vendors,main_email',
            'cc_email_1' => 'email|nullable',
            'cc_email_2' => 'email|nullable',
            'cc_email_3' => 'email|nullable',
            'contact_1' => 'string',
            'contact_2' => 'string|nullable',
            'address' => 'string|nullable'
        ]);

        $vendor = Vendor::create([
            'name' => $fields['name'],
            'main_email' => $fields['main_email'],
            'cc_email_1' => $fields['cc_email_1'],
            'cc_email_2' => $fields['cc_email_2'],
            'cc_email_3' => $fields['cc_email_3'],
            'contact_1' => $fields['contact_1'],
            'contact_2' => $fields['contact_2'],
            'address' => $fields['address']
        ]);

        $response = [
            'status'=>201,
            'message'=>'Vendor Create Sucesss',
            'user' => $vendor,
        ];

        return response($response, 201);
    }

    //View Vendors
    /*
    Sample URI
    http://192.168.8.185:8000/api/vendor/view
    
    */
    public function retrive()
	{
        $vendor = Vendor::all();
        $response = [
            'status'=>200,
            'vendor'=>$vendor
        ];
        
        return response($response, 200);
	}

    //Find Vendor
    /*
    Sample URI
    http://192.168.8.185:8000/api/vendor/view/1

    */
    public function find($id)
	{
        $vendor = Vendor::withTrashed()->find($id);

        if($vendor){
            $response = [
                'status'=>200,
                'vendor'=>$vendor
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No vendor for provided vendor id'
            ];

            return response($response, 204);            
        }
	}

    //Update Controller
    /*
    Sample Request Body
    {
        "name":"JandJ",
        "main_email":"main_email@email.com",
        "cc_email_1":"cc1@email.com",
        "cc_email_2":"cc2@email.com",
        "cc_email_3":"cc3@email.com",
        "contact_1":"0464646464",
        "contact_2":"4646533535",
        "address":"jandj, Landon."
    }

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/vendor/update/1

    */
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'main_email' => 'required|email|unique:vendors,main_email,'.$id,
            'cc_email_1' => 'email|nullable',
            'cc_email_2' => 'email|nullable',
            'cc_email_3' => 'email|nullable',
            'contact_1' => 'string',
            'contact_2' => 'string|nullable',
            'address' => 'string|nullable'
        ]);

        $vendor = Vendor::find($id);

        if($vendor){
            $vendor->name=$request->name;
            $vendor->main_email=$request->main_email;
            $vendor->cc_email_1=$request->cc_email_1;
            $vendor->cc_email_2=$request->cc_email_2;
            $vendor->cc_email_3=$request->cc_email_3;
            $vendor->contact_1=$request->contact_1;
            $vendor->contact_2=$request->contact_2;
            $vendor->address=$request->address;
    
            $vendor->save();
    
            $vendor = Vendor::find($id);
    
            $response=[
                'status'=>200,
                'message'=>'Vendor Updated Sucesss',
                'vendor'=>$vendor
            ];
    
            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No vendor for provided vendor id'
            ];

            return response($response, 204);
        }
    }

    //Delete vendor
    /*
    Sample URI
    http://192.168.8.185:8000/api/vendor/delete/1

    */
    public function delete($id)
    {
        $vendor = Vendor::find($id);

        if($vendor){
            $vendor->delete();

            $response = [
                'status'=>200,
                'message'=>'Vendor delete sucesss',
                'user' => $vendor
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No vendor for provided vendor id'
            ];

            return response($response, 204);
        }
    }

}
