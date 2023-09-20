<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request){
        $searchResult=DB::table('products')->where('name','like','%'.$request->search.'%')->get();
        if(count($searchResult)>0)
            session(['result'=>$searchResult]);
        return redirect(url()->previous());
    }
}
