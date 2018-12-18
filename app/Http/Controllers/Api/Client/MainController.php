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

class MainController extends Controller
{   
         

    public function create_order(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'products'   => 'required|array',
            'restaurant_id' => 'required|integer',
            'notes'      => 'nullable|string|max:190',
            'offer'      => 'nullable|integer'
        ]);

        if($validator->fails())
        {
            return apiRes(400 , 'Validation error' , $validator->errors());
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
        $rest = Restaurant::findOrFail($request->input('restaurant'));
        $com = Commission::first();
        $products = $request->input('products'); 
        $order->order_status = 'pending';
        $order->client_decision = 'pending';
        $order->restaurant_decision = "pending";
        $price = 0;

        foreach($products as $product)
        {
            $price = $product['price'] * $product['quantity'] + $price;
        }
        $commission = $price*($com->commission/100);
        $total = $price + $rest->delivery_fee;
        $order->commission = $commission;
        $order->price = $price;
        $order->delivery_fee = $rest->delivery_fee;
        if($request->has('offer'))
        {
            $total = $total * ($discount/100);
        }
        $order->total = $total;
        auth('api_client')->user()->orders()->save($order);
        $order->products()->attach($products);
        
        return apiRes(200 , 'order created' , $order);
    }
 









 
}
