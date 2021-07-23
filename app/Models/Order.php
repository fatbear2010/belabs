<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $primaryKey = 'idorder';
    public $keyType = 'string';
    public $timestamps = false;
    
    public function historys()
    {
        return $this->hasMany('App\History','idorder','idhistory');
    }
    public function users()
    {
        return $this->belongsTo('App\User','idUser');
    }
   
}
