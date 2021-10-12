<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'type', 'data', 'status', 'created_at', 'updated_at'
    ];

    public function getDataAttribute($value){
        return json_decode($value);
    }

}
