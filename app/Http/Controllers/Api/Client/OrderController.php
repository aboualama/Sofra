<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  
use App\Models\Area;
use App\Models\City; 
use App\Models\Contact; 
use App\Models\Page; 
use App\Models\Setting; 
use App\Models\Category; 
use App\Models\Restaurant; 
use App\Models\Offer; 
use App\Models\Meal; 

class OrderController extends Controller
{   
          

    public function create_order(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'maels.*.meal_id'  => 'required|exists:maels,id',
            'maels.*.quantity' => 'required',
            'restaurant_id'    => 'required|exists:restaurants,id',
            'payment_method'   => 'required',
            'address'          => 'required'
        ]);

        if($validator->fails())
        {
            return responsejson(0 , $validator->errors()->first() , $validator->errors());
        }


        $restaurant = Restaurant::find($request->restaurant_id);

        if($restaurant->status == 'close')
        {
           return responsejson(0 , 'Sorry : Restaurant is close now'); 
        }

        $order = client()->orders()->create([
            'restaurant_id'  => $request->restaurant_id,
            'notes'          => $request->notes,
            'status'         => 'pending',
            'address'        => $request->address,
            'payment_method' => $request->payment_method,  
        ]); 

        $cost = 0; 
        $delivery_fee = $restaurant->delivery_fee;

        foreach ($request->maels as $key) 
        {
            $mael = Meal::find($key['meal_id'])
        }

 
        $order = new Order;
        $order->notes = $request->input('notes');

        if($request->has('offer'))
        {
            $order->offer_id = $request->offer;
            $offer = Offer::findOrFail($request->input('offer'));
            $discount = $offer->discount;
        }
        if($request->has('offer'))
        {

            $order->discount = $discount;
        }
        $order->restaurant_id = $request->input('restaurant_id');
 







 
}
