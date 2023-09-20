<?php

namespace App\Http\Controllers;
use App\Models\Product;

class ProductController extends Controller
{
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
