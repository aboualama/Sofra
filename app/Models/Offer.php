<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'name', 'description', 'price', 'offer_from', 'offer_to', 'img');

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

}