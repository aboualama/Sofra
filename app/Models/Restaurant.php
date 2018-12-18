<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model 
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'area_id', 'email', 'password', 'delivery_time', 'delivery_method', 'minimum', 'delivery_fee', 'phone', 'whatsapp', 'img', 'status', 'api_token', 'pin_code');



    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
}