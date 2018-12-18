<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_meal extends Model 
{

    protected $table = 'order_meal';
    public $timestamps = true;
    protected $fillable = array('order_id', 'meal_id', 'price', 'qty', 'special_order');

}