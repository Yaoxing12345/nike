<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
Use DB;
class BaseModel extends Model
{
    public static function boot()
    {   

        static::creating(function ($model) {
            self::_prepareAuditDataAndSave($model,'creating a new record');
         });

        static::updating(function ($model) {
            self::_prepareAuditDataAndSave($model,'updating a record');
        });

        static::deleting(function ($model) {
            self::_prepareAuditDataAndSave($model,'deleting a record');
        });

        parent::boot();
        
    }

    public static function _prepareAuditDataAndSave($model,$activity){

        $tableName = $model->table;
        $user = Auth::user();
        $userId =  $user->id;
        $jsonData = json_encode($model);
        $dataSet = array('user_id'=>$userId,
                         'table_name'=>$tableName,
                         'old_values'=>'',
                         'new_values'=>$jsonData,
                         'user_activity_log'=>$activity
                        );

        self::_storeAudit($dataSet);
    }

    public static function _storeAudit($dataSet){
            try{
                $res = DB::table('audit')->insert([
                    'user_id'=> $dataSet['user_id'],
                    'table_name' => !empty($dataSet['table_name']) ? $dataSet['table_name'] : NULL,
                    'old_values' => !empty($dataSet['old_values']) ? $dataSet['old_values'] : NULL,
                    'new_values' => !empty($dataSet['new_values']) ? $dataSet['new_values'] : NULL,
                    'user_activity_comment' => $dataSet['user_activity_log'],
                    'created_at' =>date('Y-m-d h:i:s'),
                    'updated_at' =>date('Y-m-d h:i:s'),
                ]);
            }catch(\Exception $e){

            }
    }
}

?>