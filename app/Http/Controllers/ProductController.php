<?php

namespace App\Http\Controllers;
use App\Models\Product;

class ProductController extends Controller
{
    public function getShopProductsByCategoryName($categoryName, $countOfProducts){
        if($categoryName=='all')
            return Product::paginate($countOfProducts);
        return Product::where('category_name','=',$categoryName)->paginate($countOfProducts);
}
}
