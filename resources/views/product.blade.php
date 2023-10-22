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
		<!-- FancyBox -->
		<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
		<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js"></script>

		<!-- Optionally add helpers - button, thumbnail and/or media -->
		<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-buttons.css" type="text/css" media="screen" />
		<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js"></script>
		<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js"></script>

		<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen" />
		<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js"></script>
		<script>
		$(document).ready(function(){		
			$('.fancybox').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
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
					<form method=get action="{{route('search')}}">
						<div class= "form-group">
							<input type="text" class="form-control" name="search" placeholder="Search">
							<img src="img/icons/search.png">
						</div>
					</form>
				</div>
			</div> <!-- menu -->
		</div> <!-- container -->
	</header> <!-- header -->

	<div class="container">
		<main>
		
			<div class="single-product">
			    <?php
				use App\Models\Category;
				$product =Product::findOrFail($productId);
				$itemAddedFlag=$userItemController->isThisItemAddedToCart($productId); ?>
				<div class="images-section">
					<div class="larg-img">
						<img src="{{$product->image}}">
					</div>
					
				</div> <!-- End of Images Section-->
				
				<div class="product-detail">
					<div class="product-name">
						<h2>{{$product->name}}</h2>
					</div>
					<div class="product-price">
						<h3>{{$product->price}} $</h3>
					</div>
					<hr>
					<div class="product-description">
						<p>{{$product->description}}</p>
					</div>
					<hr>
					<div class="product-cart" style="display: flex; flex-direction: column;">
					@if(!$itemAddedFlag)
						<a class="cc" href="add-to-cart/{{$productId}}" style="background-color:white; margin-bottom: 25px; width:20%">Add to Cart</a>
					@endif
					@if($itemAddedFlag)
						<a class="cc" href="{{route('delete_item',['itemId'=>"{$productId}"])}}" style="background-color:#F0E68C; margin-bottom: 25px; width:20%">Added</a>
				    @endif
					<?php $itemWishedFlag=$userItemController->isThisItemWished($productId);?>
						
					@if(!$itemWishedFlag)
						<a  href="add-to-wish-list/{{$product->id}}" style="width: 8%;"><img class="cc" src="img/icons/heart.png"> </a>
					@endif
                    @if($itemWishedFlag)
						<a href="delete-from-wish-list/{{$product->id}}" style="width: 8%;"><img style="background-color:#F0E68C" class="cc" src="img/icons/heart.png"> </a>
				    @endif
								
					</div>
					<hr>
					<div class="product-meta">
						<p><b>Category: </b><a style="text-decoration:none;color:#2F4F4F" href="shop?cat={{$product->category_name}}&countOfProducts=6">{{$product->category_name}}</a></p>
						
					</div>
				</div> <!-- End of Product Detail-->
			</div>
			<hr>
			<?php
			$recommendedProducts=$userItemController->getRecommendedProducts();?>
			<div class="new-product-section">
				<div class="product-section-heading">
					<h2>Recommend Products <img src="img/icons/good_quality.png"></h2>
					<h3>OUR BEST PRODUCTS RECOMMENDED FOR YOU</h3>
				</div>
				<div class="product-content">
				@foreach($recommendedProducts as $singleProduct)
					<?php
					$product=Product::findOrFail($singleProduct);
					$itemAddedFlag=$userItemController->isThisItemAddedToCart($product->id);?>
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
							<a href="{{route('delete_item',['itemId'=>"{$singleProduct}"])}}" style="background-color:#F0E68C">Delete From Cart</a>
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
			<?php $categoryName=$result->category_name;?>
			
			<div class="single-result">
				<div class="category-res"><a class="category-result-a" href="shop?cat={{$product->category_name}}">{{$product->category_name}}</a></div>
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