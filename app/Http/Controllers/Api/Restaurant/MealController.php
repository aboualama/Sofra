<?php

namespace App\Http\Controllers\Api\Restaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Meal; 

class MealController extends Controller
{  
     



    public function create (Request $request)
    {  
        $data = $request->all(); 
        $validator = validator()->make($data, [
 
            'name'            => 'required',
            'description'     => 'required',
            'price'           => 'required',
            'processing_time' => 'required',  
        ]);

        if ($validator->fails()) 
        {
            return responsejson( 0 , $validator->errors()->first() , $validator->errors()); 
        } 

        if (request()->hasFile('img')) 
        {  
            $public_path = 'uploads/meal';
            $img_name = time() . '.' . request('img')->getClientOriginalExtension();
            request('img')->move($public_path , $img_name); 
        }else
        { 
            $img_name = 'default.jpg';  
        }  

        $data['restaurant_id'] =  restaurant()->id; 
        $data['img']           =  $img_name; 
        $meal = Meal::create($data);   
        return responsejson(1 , 'OK' , $meal ); 
    }  
 
}
