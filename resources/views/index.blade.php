<!DOCTYPE html>
<html lang="en">

 	<head>
 		<!-- Meta Tags -->
		<meta charset="UTF-8">
		<meta name="author" content="Kamran Mubarik">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Title -->
 		<title>E-Commerce Online Shop</title>
 		<!-- Style Sheet -->
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<!-- Javascript -->	
	<script type="text/javascript" src="js/jquery.min.js"></script>
		<link rel="stylesheet" href={{URL::asset('https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css')}}>
  		<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
  		<script>
		    $(document).ready(function(){
		      $('.slider').bxSlider({
				  auto: true,
				  autoControls: true,
				  stopAutoOnClick: true,
				  pager: true
				});
		    });
		 </script>

		 <style></style>
 	</head>
<body>

	<header>
		<div class="container">
			<div class="brand">
				<div class="logo">
					<a href="{{route('index')}}">
						<img src="img/icons/online_shopping.png">
						<div class="logo-text">
							<p class="big-logo">Ecommerce</p>
							<p class="small-logo">online shop</p>
						</div>
					</a>
				</div> <!-- logo -->
				<div class="shop-icon">
					@if(Auth::check())
					<div class="dropdown">
						<a href="{{ route('register') }}"><img src="img/icons/account.png"></a>
						<div class="dropdown-menu">
							<ul>
								<li><a href="{{ route('account') }}">My Account</a></li>
								<li><a href="{{route('orders')}}">My Orders</a></li>
							</ul>
						</div>
					</div>
					@endif

					@if(!Auth::check())
					<div class="dropdown">
						<a href="{{ route('register') }}"><img src="img/icons/account.png"></a>
					</div>
					@endif
					<div class="dropdown">
						<a href=""><img src="img/icons/heart.png"></a>
						<div class="dropdown-menu wishlist-item">
							<table border="1">
								<thead>
									<tr>
										<th>Image</th>
										<th>Product Name</th>
									</tr>
								</thead>
								<tbody>
									
								    <?php
								    use App\Models\Product;
									use App\Http\Controllers\UserItemsController;
									$userItemController=new UserItemsController();
								    $wishedProducts=$userItemController->getWishedProducts() ?>
								    @foreach($wishedProducts as $wishedProduct)
								    <?php $product=Product::findOrFail($wishedProduct->product_id); ?>
									<tr>
										<td><a href="product?productId={{$product->id}}"><img src="{{$product->image}}"></a></td>
										<td>{{$product->name}}</td>
									</tr>
								    @endforeach

								</tbody>
							</table>
						</div>
					</div>

					<div class="dropdown">
						<a href="{{route('cart')}}"><img src="img/icons/shopping_cart.png"></a>
						<div class="dropdown-menu cart-item">
							<table border="1">
								<thead>
									<tr>
										<th>Image</th>
										<th>Product Name</th>
										<th class="center">Price</th>
										
									</tr>
								</thead>
								<tbody>
								    <?php $cartItems=$userItemController->getCartItems() ?>
								    @foreach($cartItems as $item)
								    <?php $product=Product::findOrFail($item->product_id); ?> 
								    <tr>
								        <td><a href="product?productId={{$product->id}}"><img src="{{$product->image}}"></a></td>
								        <td>{{$product->name}}</td>
								        <td class="center">{{$product->price}}</td>
							        </tr>
								    @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- shop icons -->
			</div> <!-- brand -->

			<div class="menu-bar">
				<div class="menu">
					<ul>
						<li><a href="{{route('index')}}">Home</a></li>
						<li><a href="shop?cat=all&countOfProducts=6">Shop</a></li>
						<li><a href="{{route('about')}}">About</a></li>
						<li><a href="{{route('contact')}}">Contact</a></li>
					</ul>
				</div>
				<div class="search-bar">
					<form method=get action="{{route('search')}}" >
						<div class="form-group">
							<input type="text" class="form-control" id="search" name="search" placeholder="Search">
							<img src="img/icons/search.png">
							
						</div>
					</form>
				</div>
			</div> 
			
<!-- menu -->



		</div> <!-- container -->
	</header> <!-- header -->

	<div class="container">
		<main>
			<div class="slider">
				<div class="slide-1">
					<img src="img/slider/slide-1.jpg">
					<div class="slider-text">
						<h3>Sale 40% off</h3>
						<h2>Men's Watches</h2>
						<a href="shop?cat=all">Shop Now</a>
					</div>
				</div>
				<div class="slide-2">
					<img src="img/slider/slide-2.jpg">
					<div class="slider-text">
						<h3>Sale 20% off</h3>
						<h2>Women's Fashion</h2>
						<a href="shop?cat=all">Shop Now</a>
					</div>
				</div>
				<div class="slide-3">
					<img src="img/slider/slide-3.jpg">
					<div class="slider-text">
						<h3>Sale 50% off</h3>
						<h2>Women's Collection</h2>
						<a href="shop?cat=all">Shop Now</a>
					</div>
				</div>		
			</div> <!-- slider -->

			<div class="new-product-section">
				<div class="product-section-heading">
					<h2>Tranding Products <img src="img/icons/increase.png"></h2>
					<h3>Most selling product for the month</h3>
				</div>
				<?php
				use App\Models\Category;
				$trendingProductsIds=$userItemController->getTrendingProducts(); ?>
				<div class="product-content">
				@foreach($trendingProductsIds as $productId)
				<?php
				$product=Product::findOrFail($productId);
				$itemAddedFlag=$userItemController->isThisItemAddedToCart($productId);?>
				<div class="product">
						<a href="product?productId={{$product->id}}">
							<img src="{{$product->image}}">
						</a>
						<div class="product-detail">
							<h3>{{$product->category_name}}</h3>
							<h2>{{$product->name}}</h2>
							@if(! $itemAddedFlag)
							<a href="add-to-cart/{{$product->id}}" style="background-color:white">Add to Cart</a>
							@endif
							@if($itemAddedFlag)
							<a href="{{route('delete_item',['itemId'=>"{$productId}"])}}" style="background-color:#F0E68C">Delete From Cart</a>
							@endif
							<p>{{$product->price}} $</p>
						</div>						
					</div>
				@endforeach
					
				</div>
			</div> <!-- New Product Section -->

			<div class="collection">
				<div class="men-collection">
					<h2>Men's Collection</h2>
				</div>
				<div class="women-collection">
					<h2>Women's Collection</h2>
				</div>
			</div> <!-- Collection Section -->

			<?php $recommendedProductsIds=$userItemController->getRecommendedProducts(); ?>
			<div class="new-product-section">
				<div class="product-section-heading">
					<h2>Recommend Products <img src="img/icons/good_quality.png"></h2>
					<h3>OUR BEST PRODUCTS RECOMMENDED FOR YOU</h3>
				</div>

				<div class="product-content">
					@foreach($recommendedProductsIds as $productId)
					<?php
					$product=Product::findOrFail($productId);
					$itemAddedFlag=$userItemController->isThisItemAddedToCart($productId)?>
					<div class="product">
						<a href="product?productId={{$product->id}}">
							<img src={{$product->image}}>
						</a>
						<div class="product-detail">
							<h3>{{$product->category_name}}</h3>
							<h2>{{$product->name}}</h2>
							@if(! $itemAddedFlag)
							<a href="add-to-cart/{{$product->id}}" style="background-color:white">Add to Cart</a>
							@endif
							@if($itemAddedFlag)
							<a href="{{route('delete_item',['itemId'=>"{$productId}"])}}" style="background-color:#F0E68C">Delete From Cart</a>
							@endif
							<p>{{$product->price}} $</p>
						</div>						
					</div>
					@endforeach
					
				</div>
			</div> <!-- Recommend Product Section -->
		</main> <!-- Main Area -->
		<?php 
		    $searchResult=session()->get('result');
		    if(isset($searchResult)): ?>
		<div class="search-result" style="">
		<?php foreach($searchResult as $result): ?>
			<?php $categoryName=$result->category_name; ?>
			
			<div class="single-result">
				<div class="category-res"><a class="category-result-a" href="shop?cat={{$categoryName}}">{{$categoryName}}</a></div>
				<div class="product-res">
				<a class="product-res-a" href="product?productId={{$result->id}}">
					<div class="product-res-head">
						<div>{{$result->name}}</div>
						<div>{{$result->price}} $</div>
					</div>
					<div class="product-res-desc">{{$result->description}}</div></a>
			</div>
			</div>
			<?php endforeach ?>	
        </div>
		<?php session()->forget('result');endif ?>
	</div>
	<footer>
		<div class="container">
			<div class="footer-widget">
				<div class="widget">
					<div class="widget-heading">
						<h3>Important Link</h3>
					</div>
					<div class="widget-content">
						<ul>
							<li><a href="{{route('about')}}">About</a></li>
							<li><a href="{{route('contact')}}">Contact</a></li>
							<li><a href="{{route('refund')}}">Refund Policy</a></li>
							<li><a href="{{route('term')}}">Terms & Conditions</a></li>
						</ul>
					</div>
				</div>
				<div class="widget">
					<div class="widget-heading">
						<h3>Information</h3>
					</div>
					<div class="widget-content">
						<ul>
							<li><a href="{{route('account')}}">My Account</a></li>
							<li><a href="{{route('orders')}}">My Orders</a></li>
							<li><a href="{{route('cart')}}">Cart</a></li>
							<li><a href="{{route('checkout')}}">Checkout</a></li>
						</ul>
					</div>
				</div>
				<div class="widget">
					<div class="widget-heading">
						<h3>Follow us</h3>
					</div>
					<div class="widget-content">
						<div class="follow">
							<ul>
								<li><a href="facebook.com"><img src="img/icons/facebook.png"></a></li>
								<li><a href="twitter.com"><img src="img/icons/twitter.png"></a></li>
								<li><a href="instagram.com"><img src="img/icons/instagram.png"></a></li>
							</ul>
						</div>						
					</div>
				</div>
			</div> <!-- Footer Widget -->
			<div class="footer-bar">
				<div class="copyright-text">
					<p>Copyright 2021 - All Rights Reserved</p>
				</div>
				<div class="payment-mode">
					<img src="img/icons/paper_money.png">
					<img src="img/icons/visa.png">
					<img src="img/icons/mastercard.png">
				</div>
			</div> <!-- Footer Bar -->
		</div>
	</footer> <!-- Footer Area -->
</body>
</html>
