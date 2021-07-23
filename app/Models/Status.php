<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    public $primaryKey = 'idstatus';
    public $timestamps = false;
    public function historys()
    {
        return $this->hasMany('App\History','idstatus','idhistory');
    }
}
