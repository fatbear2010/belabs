<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function clean()
    {
        session()->put('cart',array());
        return "";
    }

    public function hapusPinjam(Request $request)
    {
        $id = substr($request->id,5);
        $index = intval(substr($request->id,1,4));
        $status = 0;

        $cart=Session()->get('cart');
        if(count($cart[$id]['pinjam'])<= 1)
        {
            unset($cart[$id]);
            $status = 0;
        }
        else{
            unset($cart[$id]['pinjam'][$index]);
            $status = 1;
        }

        if(count($cart)==0)
        {
            $status = 2;
        }
        
       
        //dd($cart);
        session()->put('cart',$cart);
        return $status;
    }

    public function hapusBarang(Request $request)
    {
        $id = substr($request->id,1);
        $status = 1;

        $cart=Session()->get('cart');
        unset($cart[$id]);
        
        if(count($cart)==0)
        {
            $status = 2;
        }
        session()->put('cart',$cart);
        return $status;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
}
