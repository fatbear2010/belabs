<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
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
