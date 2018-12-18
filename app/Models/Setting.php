<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('facebook', 'twitter', 'instagram', 'about', 'commission_rate');

    protected $hidden = [
        'about',
    ];
}