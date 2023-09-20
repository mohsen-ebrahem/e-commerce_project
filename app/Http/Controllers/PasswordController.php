<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
class PasswordController extends Controller
{

    public function create(){
        return view('change-password');
    }


    public function store(Request $request){
        $request->validate(['old_password'=>'required', 'new_password'=>'required', 'confirm_password'=>'required']);
        $authenticatedUserPassword=Auth()->user()->password;
        if(!Hash::check($request->old_password,$authenticatedUserPassword))
             return back()->withErrors(['password' => 'Invalid Password']);

        if(strcmp($request->old_password,$request->new_password)==0)
            return back()->withErrors(['new_password'=>'New password can not be the same as the old']);
        
        if(!strcmp($request->confirm_password,$request->new_password)==0)
            return back()->withErrors(['new_password'=>'The password confirmation does not match.']);
        
        $user=Auth()->user();
        $user->password=Hash::make($request->new_password);
        $user->save();
        return view('account');
    }

}
