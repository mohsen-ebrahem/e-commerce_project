<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

use Illuminate\Database\Query\JoinClause;
class UserItemsController extends Controller
{
    public function getWishedProducts(){
        $userId=Auth::id();
		$wishedProducts=DB::table('user_wish_product')->where('user_id','=', $userId)->get();
        return $wishedProducts;
    }


    public function getCartItems(){
        $cartItems=DB::table('product_user')->where('user_id','=', Auth::id())->where('order_id','=',NULL)->get();
        return $cartItems;
    }

    public function getTrendingProducts(){

        $products=Product::all();
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
        if(count($recommendedCategories)>0){
            $recommendedProductsIds=[];
            foreach($recommendedCategories as $category){
                $recommendedProducts=Product::all()->where('category_id','=',$category->category_id);
                foreach($recommendedProducts as $product){
                    $recommendedProductsIds[]=$product->id;
                }
            }
            return array_slice($recommendedProductsIds,0,8);
        }
        return UserItemsController::getTrendingProducts();//return trending product if the user has not add or wish any product
    }

    private function getRecommendedCategories(){
        return DB::table('product_user')->join('products','product_user.product_id','=','products.id')
        ->join('categories',function(JoinClause $join){
            $join->on('products.category_id','=','categories.id')->where('product_user.user_id','=',Auth::id());
        })->select('products.category_id')->groupBy('products.category_id')->orderBy(DB::raw('count(products.id)'), 'desc')->get();
    }

    public function isThisItemAddedToCart($itemId){
        $countOfProduct=DB::table('product_user')->where('user_id','=',Auth::id())->where('product_id','=',$itemId)->where('order_id','=',NULL)->count();
        return $countOfProduct>0;
    }

    public function isThisItemWished($itemId){
        $countOfWished=DB::table('user_wish_product')->where('product_id','=',$itemId)->where('user_id','=',Auth::id())->count();
        return $countOfWished>0;
    }

    public function getShopProductsByCategoryName($categoryName, $countOfProducts){
                if($categoryName=='all')
			        return Product::paginate($countOfProducts);
				if($categoryName=="Men's clothes")
                    return Product::where('category_id','=','1')->paginate($countOfProducts);
				if($categoryName=="Men's shoes")
                    return Product::where('category_id','=','2')->paginate($countOfProducts);
				if($categoryName=="women's clothes")
                    return Product::where('category_id','=','3')->paginate($countOfProducts);
			
                return Product::where('category_id','=','4')->paginate($countOfProducts);
    }

}
