<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AllPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    } 
    public function check(User $user)
    {
        return ($user->jabatan == '2' ? Response::allow() : Response::deny('Anda harus login sebagai Kalab untuk mengakses fitur ini'));
    }
}
