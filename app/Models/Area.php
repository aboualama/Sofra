<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model 
{

    protected $table = 'areas';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id');

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

}