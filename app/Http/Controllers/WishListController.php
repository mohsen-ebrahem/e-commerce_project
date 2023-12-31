<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function addToWishList($productId){
        DB::table('user_wish_product')->insert(['product_id' => $productId,'user_id' => Auth::id()]);
        return redirect(url()->previous());
    }

    public function deleteFromWishList($productId){
        DB::table('user_wish_product')->where('user_id','=', Auth::id())->where('product_id','=',$productId)->delete();
        return redirect(url()->previous());
    }
}
