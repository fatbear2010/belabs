<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
class Ambilbalik extends Model
{
    //use HasFactory;
    protected $table = 'ambilbalik';
    public $primaryKey = 'idambilbalik';
    public $keyType = 'string';
    public $timestamps = false;

}
