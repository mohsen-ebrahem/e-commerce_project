<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{
    public function store(Request $request){
        $request->validate(['name'=>'bail|required','email'=>'bail|required|email','message'=>'bail|required']);
        Contact::create(['name'=>$request->name,'email'=>$request->email,'message'=>$request->message]);
        return redirect(url()->previous());
    }
}
