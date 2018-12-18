<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model 
{

    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable = array('client_id', 'restaurant_id', 'comment', 'review');



    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}