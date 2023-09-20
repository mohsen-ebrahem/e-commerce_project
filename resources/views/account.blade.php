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

		<style>

			.profile{
				margin-top:60px;
			}
.account-logout{
	color: var(--darkStaleGray);
    border: 1px solid rgba(236, 240, 241,0.3);
    text-transform: uppercase;
    text-decoration: none;
    text-align: left;
    padding: 5px 8px;
    display: block;
	background:none;
	width: 244px;
    margin-left: -10px;
	cursor: pointer;
}

.account-logout:hover{
	background-color:var(--darkStaleGray);
	color:#F0E68C
}			
        </style>
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
					<form mothod=get action="{{route('search')}}">
						<div class="form-group">
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
			<?php
			use App\Models\User;
			$user=Auth::user();
			$userInfo=DB::table('user_info')->where('user_id','=',$user->id)->first(); ?>
			<div class="account-page">
				<div class="profile">
					<ul>
						<li><a href="{{ route('account') }}" class="active">Account <span>></span></a></li>
						<li><a href="{{ route('orders') }}">My Orders <span>></span></a></li>
						<li><a href="{{ route('change-password') }}">Change Password <span>></span></a></li>
						<li><form method="post" action="{{ route('logout') }}" style="margin-left:10px">
						@csrf	
						<input class="account-logout" type="submit" value="logout                                               >">
					    </form></li>
					</ul>
				</div>
				<div class="account-detail">
					<h2>Account</h2>
					<div class="billing-detail">

						<form method="post" action="{{route('update-info',['id'=>"{$user->id}"])}}" class="checkout-form">
						@csrf
							<div class="form-inline">
								<div class="form-group">
									<label>First Name</label>
									<input type="text" id="name" name="name" value="<?php print($user->name); ?>">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="text" id="email" name="email" value="<?php print($user->email); ?>">
								</div>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label>City</label>
									<select id="city" name="city" value="">
										<option value="Hama">Hama</option>
										<option value="Damascus">Damascus</option>
										<option value="Homs">Homs</option>
										<option value="Idlib">Idlib</option>
										<option value="Latakia">Latakia</option>
										<option value="Aleppo">Aleppo</option>
										<option value="Al-raqa">Al-raqa</option>
										<option value="Daraa">Daraa</option>
										<option value="Tartous">Tartous</option>
										<option value="dier-alzor">dier-alzor</option>
										<option value="swedaa">swedaa</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label>Address</label>
								<textarea style="resize:none" id="address" name="address" rows="3"><?php print($userInfo!=NULL? $userInfo->address:'');?></textarea>
							</div>
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" id="mobile" name="mobile"   value="<?php print($userInfo!=NULL? $userInfo->mobile:'');?>">
								</div>
							</div>
							<div class="form-group">
								<label></label>
								<input type="submit" id="update" name="update" value="Update">
							</div>
						</form>		
					</div>
				</div>				
			</div>		
		</main> <!-- Main Area -->
		<?php
		    use App\Models\Category;
		    $searchResult=session()->get('result');
		    if(isset($searchResult)): ?>
		    <div class="search-result" style="">
		    <?php foreach($searchResult as $result): ?>
			    <?php $categoryName=Category::findOrFail($result->category_id)->category_name;?>
			
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