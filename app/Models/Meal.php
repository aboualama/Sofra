<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model 
{

    protected $table = 'meals';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'name', 'description', 'price', 'processing_time', 'img');

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

}