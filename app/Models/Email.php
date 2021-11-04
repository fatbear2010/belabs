<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lab;
use App\Models\Jurusan;
use App\Models\User;
class Email extends Model
{
    //use HasFactory;
    protected $table = 'email';
    public $primaryKey = 'idemail';
    public $timestamps = false;

    public function user()
    {
        return $this->hasMany(Lab::class,'emailcek','idemail');
    }

}
