<?php

namespace App\Http\Controllers\Api\Restaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{ 
     
    public function register(Request $request)
    {
    	$data = $request->all(); 
    	$validator = validator()->make($data, [
            'name'               => 'required|min:6',
			'email'              => 'required|email|unique:restaurants', 
            'phone'              => 'required|numeric|unique:restaurants', 
			'area_id'            => 'required|numeric', 
            'password'           => 'required|confirmed|min:6|max:60|alpha_num',  
			'status'             => 'required',  
    	]); 

    	if ($validator->fails()) 
    	{
        	return responsejson(1 , $validator->errors()->first() , $validator->errors()); 
    	} 

        $request->merge(['password' => bcrypt($request->password)]);
    	$restaurant = Restaurant::create($request->all()); 
    	$restaurant->api_token = str_random(60); 

        if (request()->hasFile('img')) 
        {  
            $public_path = 'uploads/img';
            $img_name = time() . '.' . request('img')->getClientOriginalExtension();
            request('img')->move($public_path , $img_name); 
        }else
        { 
            $img_name = 'default.jpg';  
        }  
        $restaurant['img']    =  $img_name; 
     
        $restaurant->save();
 
    	return responsejson(1 , 'OK' ,
                                      [
                                          'Api_Token'  => $restaurant->api_token,
                                          'Restaurant' => $restaurant
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
    	$restaurant = Restaurant::where('email' , $request->email)->first();  
    	if($restaurant)
    	{
    		if(Hash::check($request->password , $restaurant->password)) // --  ranking is important (string, hashed)
    			{
    				return responsejson(1 , 'OK'  , [ 'Api_Token' => $restaurant->api_token, 'Clinet' => $restaurant ]); 
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
        $restaurant = restaurant();   
        return responsejson(1 , 'OK' ,  $restaurant);   

    }   
 


    public function update(request $request)
    {
        $restaurant = restaurant();  
        $data = $request->all(); 
        $validator = validator()->make($data, [   
            'name'               => 'required|min:6', 
            'email'              => 'required|email|unique:restaurants,email,'.$restaurant->id,
            'phone'              => 'required|numeric|unique:restaurants,phone,'.$restaurant->id, 
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
                $data['password'] = $restaurant->password;
            } 
            if (request()->hasFile('img')) 
            {  
                 if($restaurant->img !==  'default.jpg'){
                    Storage::delete('img/'.$restaurant->img);    
                 }
                $public_path = 'uploads/img';
                $img_name = time() . '.' . request('img')->getClientOriginalExtension();
                request('img')->move($public_path , $img_name); 
                
            }else
            { 
                $img_name = 'default.jpg';  
            }  
        $restaurant['img']    =  $img_name; 
        $restaurant->update($data); 
        return responsejson(1 , 'OK' , $restaurant ); 
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

        $restaurant = Restaurant::where('email',$request->email)->first();
        if ($restaurant){
            $code = rand(1111,9999);
            $update = $restaurant->update(['pin_code' => $code]);
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

        $restaurant = Restaurant::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();

        if ($restaurant)
        {
            $restaurant->password = bcrypt($request->password);
            $restaurant->pin_code = null;

            if ($restaurant->save())
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
