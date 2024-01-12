<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Register user
    /*
    Sample Request Body
    {
        "first_name":"Jhon",
        "last_name":"Doe",
        "email":"jhondoe2@email.com",
        "username":"jhon2",
        "password":"123",
        "password_confirmation":"123",
        "role":"admin"
    }

    * role is optional

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/user/create

    */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'in:admin,supervisor,user'
        ]);

        // Set default role to 'moderator' if not provided in the request
        
        $fields = array_merge($fields, ['role' => $fields['role'] ?? 'moderator']);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'username' => $fields['username'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role' => $fields['role']
        ]);

        $response = [
            'status'=>200,
            'message'=>'User Create Sucesss',
            'user' => $user,
        ];

        return response($response, 201);
    }

    //View Users
    /*
    Sample URI
    http://192.168.8.185:8000/api/user/view
    
    */
    public function retrive()
	{
        $user = User::all();
        $response = [
            'status'=>200,
            'user'=>$user
        ];
        
        return response($response, 200);
	}

    //Find User
    /*
    Sample URI
    http://192.168.8.185:8000/api/user/view/1

    */
    public function find($id)
	{
        $user = User::find($id);

        if($user){
            $response = [
                'status'=>200,
                'user'=>$user
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No user for provided user id'
            ];

            return response($response, 204);            
        }
	}

    //Update User (Own Profile Only)
    /*
    User Profile Update

    Headers
    "Accept":"application/json"

    Sample URI
    http://192.168.8.185:8000/api/user/update/1

    Request Body
    {
        "first_name":"Admin 1",
        "last_name":"Admin 1",
        "email":"admin1233@gmail.com",
        "password":"password",
        "password_confirmation":"password"
    }

    *All feilds are optional

    */

    public function update(Request $request, $id)
    {
        $current_user_id = Auth::id();

        if($current_user_id != $id){
            $response = [
                'status' => 401,
                'message' => 'Unauthorized user id'
            ];

            return response($response, 401);
        }

        $fields = $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email|unique:users,email,'.$id,
            'password' => 'string|confirmed'
        ]);

        if($request->first_name) {
            Auth::user()->first_name = $request->first_name;
        }
        if($request->last_name) {
            Auth::user()->last_name = $request->last_name;
        }
        if($request->email) {
            Auth::user()->email = $request->email;
        }
        if($request->password) {
            Auth::user()->password = bcrypt($request->password);
        }
        Auth::user()->save();

        $user = User::find($id);

        $response=[
            'status'=>200,
            'message'=>'Data Updated Sucesss',
            'user' => $user
        ];

        return response($response, 201);
    }

    //Delete User
    /*
    Sample URI
    http://192.168.8.185:8000/api/user/delete/1

    */

    public function delete($id)
    {
        $user = User::find($id);

        if($user){
            $user->delete();

            $response = [
                'status'=>200,
                'message'=>'User delete sucesss',
                'user' => $user
            ];

            return response($response, 200);
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No user for provided user id'
            ];

            return response($response, 204);            
        }
    }

    //Reset Password
    /*
    Sample URI
    http://192.168.8.185:8000/api/user/reset_password/1

    */
    public function reset_password($id)
    {
        $user = User::find($id);
        if($user){
            $user->password = bcrypt('password');
            $user->save();

            $response=[
                'status'=>200,
                'message'=>'Password Reset Sucesss'
            ];
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No user for provided user id'
            ];

            return response($response, 204); 
        }

        return response($response, 201);
    }

    //Update User Role
    /*

    Sample URI
    http://192.168.8.185:8000/api/user/update_role/1

    Sample Requst Body
    {
        "role":"user"
    }

    */
    
    public function update_role(Request $request, $id)
    {
        $fields = $request->validate([
            'role' => 'in:admin,supervisor,user'
        ]);

        $user = User::find($id);
        if($user){
            $user->role = $fields['role'];
            $user->save();

            $response=[
                'status'=>200,
                'message'=>'Change Role Sucesss'
            ];
        }
        else{
            $response = [
                'status'=>204,
                'message'=>'No user for provided user id'
            ];

            return response($response, 204); 
        }

        return response($response, 201);
    }
}