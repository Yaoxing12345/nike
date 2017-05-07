<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends BaseModel{
    //
    protected $table = 'currency';

    protected $fillable = [
        'name', 'code','symbol','base_usd_amount','created_at','updated_at'
    ];
}
