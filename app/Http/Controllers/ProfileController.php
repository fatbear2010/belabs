<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;

use App\Models\Kategori;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_profile' => __('You are not allowed to change data for a default user.')]);
        }

        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        }

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    public function kategoriIndex()
    {
         $queryBuilder = Kategori::All(); 
        return view('admin.kategori.index',compact('queryBuilder'));
    }
    public function createkategoriIndex()
    {
         //$queryBuilder = Kategori::All(); ,compact('queryBuilder')
        return view('admin.kategori.create');
    }
    public function editKat(Kategori $kategori)
    {
         //$queryBuilder = Kategori::All(); ,compact('queryBuilder')
         //dd($kat);
        $data = $kategori;
        //dd($data);
        return view('admin.kategori.edit',compact('data'));
    }
    public function updateKat()
    {
         //$queryBuilder = Kategori::All(); ,compact('queryBuilder')
        return view('admin.kategori.create');
    }
    
}
