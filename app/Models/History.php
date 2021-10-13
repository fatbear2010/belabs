<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    public $primaryKey = 'idhistory';
    public $timestamps = false;
    public function status()
    {
        return $this->belongsTo('App\Status','idstatus');
    }
    public function orders()
    {
        return $this->belongsTo('App\Order','idorder');
    }
    public function users()
    {
        return $this->belongsTo('App\User','idUser');
    }
}
