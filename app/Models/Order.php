<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('client_id', 'restaurant_id', 'delivery_cost', 'app_commission', 'payment_method', 'total', 'note', 'status');

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function maels()
    {
        return $this->belongsToMany(Meal::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }

}