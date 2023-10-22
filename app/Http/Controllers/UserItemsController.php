<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class UserItemsController extends Controller
{
    public function getWishedProducts(){
		$wishedProducts=DB::table('user_wish_product')->where('user_id','=', Auth::id())->select('product_id')->get();
        return $wishedProducts;
    }


    public function getCartItems(){
        $cartItems=DB::table('product_user')->where('user_id','=', Auth::id())->where('order_id','=',NULL)->select('product_id')->get();
        return $cartItems;
    }

    public function getTrendingProducts(){

        //$products=Product::all();
        $products=Product::select("id")->get();
        $productsStatistics=[];

        foreach($products as $product){
            $cartcount=DB::table('product_user')->where('product_id','=',$product->id)->count();
            $wishedcount=DB::table('user_wish_product')->where('product_id','=',$product->id)->count();
            $productsStatistics[$product->id]=[$cartcount,$wishedcount];
        }
        return UserItemsController::getIdsOfTrendingProducts($productsStatistics);
    }

    private function getIdsOfTrendingProducts($productsStatistics){
        arsort($productsStatistics);
        $TrendingProductsIds=array_keys($productsStatistics);
        return array_slice($TrendingProductsIds,0,8);
    }

    public function getRecommendedProducts(){
        $recommendedCategories=UserItemsController::getRecommendedCategories();
        if( Auth::check() & count($recommendedCategories)>0){
            $recommendedProductsIds=[];
            foreach($recommendedCategories as $category){
                $recommendedProducts=DB::table('products')->where('category_name', '=', $category->category_name)->select('id')->paginate(8);
                foreach($recommendedProducts as $product)
                    $recommendedProductsIds[]=$product->id;
            }
            return array_slice($recommendedProductsIds,0,8);
        }
        return UserItemsController::getTrendingProducts();//return trending product if the user has not add or wish any product
    }

    private function getRecommendedCategories(){
        return DB::table('product_user')->join('products','product_user.product_id','=','products.id')
        ->where('product_user.user_id','=',Auth::id())
        ->select('products.category_name')
        ->groupBy('products.category_name')
        ->orderBy(DB::raw('count(products.id)'), 'desc')->get();
    }

    public function isThisItemAddedToCart($itemId){
        $countOfProduct=DB::table('product_user')->where('user_id','=',Auth::id())->where('product_id','=',$itemId)->where('order_id','=',NULL)->count();
        return $countOfProduct>0;
    }

    public function isThisItemWished($itemId){
        $countOfWished=DB::table('user_wish_product')->where('product_id','=',$itemId)->where('user_id','=',Auth::id())->count();
        return $countOfWished>0;
    }

}
