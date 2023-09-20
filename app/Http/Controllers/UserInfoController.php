<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AccountUpdateRequest;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountUpdateRequest $request, $id)
    {
    
        $user=DB::table('user_info')->where('user_id','=',$id)->get();

        if(count($user)==0)
            DB::table('user_info')->insert(['city' => $request->city, 'address'=>$request->address, 'mobile'=>$request->mobile, 'user_id'=>$id]);
        
        else
            DB::table('user_info')->where('user_id','=', $id)->update(['city' => $request->city,'address'=>$request->address,'mobile'=>$request->mobile,'user_id'=>$id]);
        
        return redirect(url()->previous());
    }

   
}
