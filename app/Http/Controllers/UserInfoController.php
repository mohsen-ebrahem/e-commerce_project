<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
    public function update(AccountUpdateRequest $request)
    {
    
        $userId=Auth::id();
        $userCount=DB::table('user_info')->where('user_id','=',$userId)->count();

        if($userCount==0)
            DB::table('user_info')->insert(['city' => $request->city, 'address'=>$request->address, 'mobile'=>$request->mobile, 'user_id'=>$userId]);
        
        else
            DB::table('user_info')->where('user_id','=', $userId)->update(['city' => $request->city,'address'=>$request->address,'mobile'=>$request->mobile,'user_id'=>$userId]);
        
        return redirect(url()->previous());
    }

   
}
