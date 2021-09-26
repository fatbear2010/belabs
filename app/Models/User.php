<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Jabatan;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = false;
    public $keyType = 'string';
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class,'jabatan','idjabatan');
    }
    public function laborans()
    {
        return $this->belongsToMany('App\Models\Lab','laboran','user','lab')
        ->withPivot('keterangan');
    }
    public function jabatan1()
    {
        return Jabatan::find($this->jabatan);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jabatan',
        'iduser',
        'vcode',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
