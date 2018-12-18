<?php



if(!function_exists('responsejson')){

	function responsejson($status , $message , $date=null){     	
 
        $response = [ 
			'status'  => $status,
			'message' => $message,
			'date'    => $date,
        ];

        return response()->json($response); 
    }  
  

if(!function_exists('client')){
	function client(){ 
		return Auth::guard('client')->user();
	}
} 
  

if(!function_exists('restaurant')){
	function restaurant(){ 
		return Auth::guard('restaurant')->user();
	}
} 
 
}

// @if(Auth::guard('admin')->check())
//     welcome  Admin 
// @elseif(Auth::guard('user')->check())
//    Welcome  User 
// @endif