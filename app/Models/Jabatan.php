<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Jabatan extends Model
{
    protected $table = 'jabatan';
    public $primaryKey = 'idjabatan';
    public $timestamps = false;
    public function user()
    {
        return $this->hasMany(User::class,'idjabatan','jabatan');
    }
}
