<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PlaceOrderRequest;
use Carbon\Carbon;
class CartController extends Controller
{
    public function addToCart($productId){
        $userId=Auth::id();
        DB::table('product_user')->insert(['product_id' => $productId,'user_id' => $userId]);
        return redirect(url()->previous());
    }    

    public function updateCartItems($orderId,Request $request){
        DB::table('product_user')->where('id','=',$orderId)->update(['count_of_items'=>$request->cartNumber]);
        return redirect(url()->previous());
    }

    public function deleteItemFromCart($itemId){
        $userId=Auth::id();
        DB::table('product_user')->where('user_id','=',$userId)->where('product_id','=',$itemId)->delete();
        return redirect(url()->previous());
    }

    public function orderCartItems(PlaceOrderRequest $request){
        DB::table('orders')->insert(['full_name' => $request->name,'city'=>$request->city,'address'=>$request->address,'tel'=>$request->tel,'mobile'=>$request->mobile,'cart_cost'=>9300,'delivery_charges'=>100,'order_notes'=>$request->note,'user_id'=>(Auth::id()), 'created_at'=>Carbon::now()]);
        $lastOrder=DB::table('orders')->select('id')->orderby('id','desc')->first();
        DB::table('product_user')->where('user_id','=',Auth::id())->where('order_id','=',NULL)->update(['order_id'=>$lastOrder->id]);
        $request->session()->forget('cart');
        return redirect('orders');
    }

}
