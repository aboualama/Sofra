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
     
    public function cities(request $request)
    { 
        $cities = City::all();

        return responsejson(1 , 'ok' , $cities); 
    }
     

    public function area(request $request)
    { 
        $area = Area::where(function($query) use($request)
            { 
                if($request->has('city_id')) 
                {
                    $query->where('city_id' , $request->city_id);
                } 
            })->paginate(10);

        return responsejson(1 , 'ok' , $area); 
    }


      
    public function contact (request $request)
    { 
        $data = $request->all();
        $validator = validator()->make($request->all(), [
            'type'      => 'required|in:suggestion,complaint,inquiry',
            'name'      => 'required',
            'email'     => 'required|email',
            'phone'     => 'numeric', 
            'message'   => 'min:10']);

        if ($validator->fails()) 
        {
            return responsejson(1 , $validator->errors()->first() , $validator->errors()); 
        }     
        $report = Contact::create($data);   
        return responsejson(1 , 'OK' , $report); 
         
    }  


      
     
    public function page(request $request)
    { 
        $page = Page::where(function($query) use($request)
            { 
                if($request->has('title')) 
                {
                    $query->where('title' , $request->title);
                } 
            })->first();

        if(! $page)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No Page ');
        } 
        return responsejson(1 , 'OK' , $page);
    }

 
       
    public function setting()
    {   
        $setting = Setting::first(); 
        if(! $setting)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No Setting');
        } 
        return responsejson(1 , 'OK' , $setting);  
    }  
 
       
    public function about()
    {   
        $about = Setting::first()->pluck('about'); 
        if(! $about)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No Setting');
        } 
        return responsejson(1 , 'OK' , $about);  
    }  

 
     
    public function category(request $request)
    { 
        $category = Category::all();
        return responsejson(1 , 'OK' , $category);
    } 
      
     
    public function restaurants(request $request)
    { 
        $restaurant = Restaurant::where(function($query) use($request)
            { 
                if($request->has('area_id')) 
                {
                    $query->where('area_id' , $request->area_id);
                }   
                if($request->has('search')) 
                {
                    $query->where('name', 'like' ,'%'.$request->search.'%');
                } 
            })->get();

        if(! $restaurant)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No restaurant ');
        } 
        return responsejson(1 , 'OK' , $restaurant);
    }
      
     
    public function restaurant($id)
    { 
        $restaurant = Restaurant::where('id', $id)->with('area')->with('categories')->first();

        if(! $restaurant)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No restaurant ');
        } 
        return responsejson(1 , 'OK' , $restaurant);
    }
      
     
    public function meals()
    { 
        $meals = Meal::all();

        if(! $meals)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No meals ');
        } 
        return responsejson(1 , 'ok' , $meals); 
    }
      
     
    public function meals_restaurant(request $r)
    { 
        $meals_restaurant = Meal::where('restaurant_id', $r->restaurant_id)->get(); 

        if(! $meals_restaurant)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No meals ');
        }   
        return responsejson(1 , 'ok' , $meals_restaurant); 
    }
 
     
    public function offers()
    { 
        $offers = Offer::all();

        if(! $offers)
        {
            return responsejson( 0 , 'OPPs' , 'There Is No offers ');
        } 
        return responsejson(1 , 'ok' , $offers); 
    }









 
}
