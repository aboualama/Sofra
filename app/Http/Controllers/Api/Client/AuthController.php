<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{ 
     
    public function register(Request $request)
    {
    	$data = $request->all(); 
    	$validator = validator()->make($data, [
            'name'               => 'required|min:6',
			'email'              => 'required|email|unique:clients', 
            'phone'              => 'required|numeric|unique:clients',
            'address'            => 'required',
			'area_id'            => 'required|numeric', 
			'password'           => 'required|confirmed|min:6|max:60|alpha_num',  
    	]); 
    	if ($validator->fails()) 
    	{
        	return responsejson(1 , $validator->errors()->first() , $validator->errors()); 
    	} 
        $request->merge(['password' => bcrypt($request->password)]);
    	$client = Client::create($request->all()); 
    	$client->api_token = str_random(60);
    	$client->save();
    	return responsejson(1 , 'OK' ,
                                      [
							    		 'Api_Token' => $client->api_token,
							    	 	 'Clinet' 	 => $client
							    	   ]); 
    }
 


    public function login(Request $request)
    {  
    	$validator = validator()->make($request->all(), [ 
  			'email'              => 'required|email', 
  			'password'           => 'required',
    	]); 
    	if ($validator->fails()) 
    	{
        	return responsejson(0 , $validator->errors()->first() , $validator->errors()); 
    	}  
    	$client = Client::where('email' , $request->email)->first();  
    	if($client)
    	{
    		if(Hash::check($request->password , $client->password)) // --  ranking is important (string, hashed)
    			{
    				return responsejson(1 , 'OK'  , [ 'Api_Token' => $client->api_token, 'Clinet' => $client ]); 
    			}
    		else 
          		{ 
    				return responsejson(0 , 'fails' , 'password is wrong'); 
    			}
    	} 
        return responsejson(0 , 'fails' , 'email is wrong');  
    }  



    public function profile (request $request)
    {   
        $client = client();   
        return responsejson(1 , 'OK' ,  $client);   

    }   
 


    public function update(request $request)
    {
        $client = client();  
        $data = $request->all(); 
        $validator = validator()->make($data, [   
            'name'               => 'required|min:6', 
            'email'              => 'required|email|unique:clients,email,'.$client->id,
            'phone'              => 'required|numeric|unique:clients,phone,'.$client->id,
            'address'            => 'required',
            'area_id'            => 'required|numeric',   
        ]); 
        if ($validator->fails()) 
        {
            return responsejson(0 , $validator->errors()->first() , $validator->errors()); 
        }  
        if ( ! $request->password == '')
        {
            $data['password'] = bcrypt($request->password);
        } 
        else
        {
            $data['password'] = $client->password;
        } 
        $client->update($data); 
        return responsejson(1 , 'OK' , $client ); 
    }     



    public function reset(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $client = Client::where('email',$request->email)->first();
        if ($client){
            $code = rand(1111,9999);
            $update = $client->update(['pin_code' => $code]);
            if ($update)
            { 
                return responseJson(1,'تم ارسال كود التفعيل',['pin_code_for_test' => $code]);
            }else
            {
                return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
            }
        }else{
            return responseJson(0,'لا يوجد أي حساب مرتبط بهذا البريد');
        }
    }

   


    public function password(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'pin_code' => 'required',
            'password' => 'confirmed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $client = Client::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();

        if ($client)
        {
            $client->password = bcrypt($request->password);
            $client->pin_code = null;

            if ($client->save())
            {
                return responseJson(1,'تم تغيير كلمة المرور بنجاح');
            }else
            {
                return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
            }
        }else{
            return responseJson(0,'هذا الكود غير صحيح');
        }
    }
}
