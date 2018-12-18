<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 

class Controller extends Controller
{
             





    public function pagea (request $request)
    { 
        $data = $request->all();
        $validator = validator()->make($request->all(), [
            'title'      => 'required',
            'content'      => 'required', 
        ]); 
        if ($validator->fails()) 
        {
            return responsejson(1 , $validator->errors()->first() , $validator->errors()); 
        }     
        $page = Page::create($data);   
        return responsejson(1 , 'OK' , $page); 
         
    }  
  

































             
}
