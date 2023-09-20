<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/index',function(){
    return view('index');
})->name('index');

Route::get('/shop',function(Request $request){
        return view('shop',['cat'=>$request->cat,'countOfProducts'=>$request->countOfProducts]);
})->name('shop');


Route::get('/about',function(){
        return view('about');
})->name('about');

Route::post('/update-info/{id}',[UserInfoController::class,'update'])->name('update-info');
Route::get('/contact',function(){
        return view('contact');
})->name('contact');

Route::get('/account',function(){
        return view('account');
})->name('account');

Route::get('/cart',function(){
       return view('cart');
})->name('cart')->middleware('auth');


Route::get('/checkout',function(){
       return view('checkout');
})->name('checkout')->middleware('checkifcartisempty');

Route::get('/add-to-cart/{productId}',[CartController::class,'addToCart'])->middleware('auth');

Route::get('/add-to-wish-list/{productId}',[WishListController::class,'addToWishList'])->middleware('auth');

Route::get('/delete-from-wish-list/{productId}',[WishListController::class,'deleteFromWishList'])->middleware('auth');


Route::get('/delete-item/{itemId}',[CartController::class,'deleteItemFromCart'])->name('delete_item')->middleware('auth');

Route::post('/place-order',[CartController::class,'orderCartItems'])->name('place_order');

Route::get('/orders',function(){
       return view('orders');
})->name('orders');

Route::get('/product',function(Request $request){
    return view('product',['productId'=>$request->productId]);
})->name('product');

Route::get('/order-details',function(Request $request){
    return view('order-details',['orderId'=>$request->orderId]);
});


Route::get('/refund',function(){
    return view('refund');
})->name('refund');

Route::get('/term',function(){
    return view('terms');
})->name('term');

Route::get('trending-products',[CartController::class,'getTrendingProducts'])->name('trend');

Route::post('/update-cart-items/{orderId}',[CartController::class,'updateCartItems'])->name('update-cart-items');
Route::get('/men-collection',[CartController::class,'getMensCollection'])->name('men-collection');

Route::get('/recs',[CartController::class,'getRecommendedProducts']);
Route::post('send-message',[ContactController::class,'store'])->name('sendMessage');



Route::get('/search',[SearchController::class,'search'])->name('search');


Route::get('/change-password',[PasswordController::class,'create'])->name('change-password');
Route::Post('/change-password',[PasswordController::class,'store'])->name('change-password');

require __DIR__.'/auth.php';
