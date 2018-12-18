<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'phone', 'address', 'password', 'area_id', 'api_token', 'pin_code'];



    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }



    protected $hidden = [
        'password', 'api_token','pin_code' 
    ];

}