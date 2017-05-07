<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends BaseModel{
    //
    protected $table = 'audit';

    protected $fillable = [
        'user_id', 'table_name','old_values','new_values','user_activity_log','created_at','updated_at'
    ];


    
}
