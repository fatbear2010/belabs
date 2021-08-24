<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jabatan;
use App\Models\Status;
class StatusJabatan extends Model
{
    protected $table = 'statusjabatan';
    
    public $timestamps = false;
    public function status()
    {
        return $this->belongsTo(Status::class,'idstatus','idstatus');
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class,'idjabatan','idjabatan');
    }
}
