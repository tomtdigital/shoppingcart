<?php
session_start();
//Check to see if the button has been submitted. Filter input sieves only this result out from the POSTs.
if(filter_input(INPUT_POST, 'add_to_cart')){
	//If the shopping cart doesn't exist...
	if(!isset($_SESSION['shopping_cart'])){
		//...create it with the first product (array key 0).
		//Each product is an associative array in itself, using submitted form data, based on attr name. 
		$_SESSION['shopping_cart'][0] = array(
			//id is GET due to it's presence in the action attribute.
			'id' => filter_input(INPUT_GET, 'id'),
			'name' => filter_input(INPUT_POST, 'name'),
			'price' => filter_input(INPUT_POST, 'price'),
			'quantity' => filter_input(INPUT_POST, 'quantity')
		);
		//Or, if a product is in the cart, create a new one-	
	} 	else {
		//Var tracks how many items there are in the cart-
		$count = count($_SESSION['shopping_cart']);
		//Var isolates the id column of the session array-
		$product_ids = array_column($_SESSION['shopping_cart'], 'id');
		//Checks if a product with this id does not exist in the cart-
		if(!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
			//The amount of products in the cart will be counted, and use that number for the next array key (creating a new product).
			$_SESSION['shopping_cart'][$count] = array(
				'id' => filter_input(INPUT_GET, 'id'),
				'name' => filter_input(INPUT_POST, 'name'),
				'price' => filter_input(INPUT_POST, 'price'),
				'quantity' => filter_input(INPUT_POST, 'quantity')
			);
		//If the product does exist in the cart...
		} else {
			//Loop through all the product ids...
			for($i = 0; $i < count($product_ids); $i++){
				//Whatever the product is, if it matches the id of what has just been submitted...
				if ($product_ids[$i] == filter_input(INPUT_GET, 'id')){
					//The quantity of this product will be redefined by increasing by the inputted quantity.
					$_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
				}
			}
		}
	}
}
//Removes any product with the id matching the get id. If more time, I'd look into + and - products.
if(filter_input(INPUT_GET, 'action') == 'delete'){
	foreach($_SESSION['shopping_cart'] as $key => $product) {
		if ($product['id'] == filter_input(INPUT_GET, 'id')){
			unset($_SESSION['shopping_cart'][$key]);
		}
	}
	$_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}


//print_r($_SESSION); //Was using this to check session array status

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Purchase Prints</title>
		<meta charset="utf-8">
    		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="cart.css">
		<meta property="og:title" content="PHP Shopping Cart" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://tdavies.co.uk/cart/cart.php" />
		<meta property="og:image" content="http://tdavies.co.uk/img/previewshop.jpg" />
		<meta property="og:description" content="Simple shopping cart test page" />
	</head>
	<body>
		<div class="container"  id="cart">
			<h1 class="purchase text-white">Exhibition Prints-</h1>
			<div class="row">
			<?php 
			$connect = mysqli_connect('10.169.0.176', 'tdaviesc_root', '51Ilovecup!', 'tdaviesc_cart');
			$query = 'SELECT * FROM products ORDER by id ASC';
			//Uses the above variables to connect to database and selects the contents of the products in ascending order
			$result = mysqli_query($connect, $query);
			//If a result is obtained from this query...
			if($result):
				//and there is content (the result creates at least one row)...
				if(mysqli_num_rows($result)>0):
					//a while loop will initiate the data, and store it inside a $product associative array through fetch_assoc
					while($product = mysqli_fetch_assoc($result)):
					?>
					<!--Product Images, Headings, and Quantity Input (while there are results)-->
						<div class="col-12 col-sm-6 col-lg-4">
							<!--Form posts product data. It posts to the cart.php file with the product id  (tagged 1-6 in DB)-->
							<form method="post" action="cart.php?action=add&id=<?php echo $product['id']; ?>">
								<div class="products">
									<img src="<?php echo $product['image']; ?>" id="photo" alt="exhibition photo print">
									<h4 class="text-info"><?php echo $product['name']; ?></h4>
									<h4>&pound <?php echo $product['price']; ?></h4>
									<input type="text" name="quantity" class="form-control" value="1">
									<input type="hidden" name="name" value="<?php echo $product['name']; ?>">
									<input type="hidden" name="price" value="<?php echo $product['price']; ?>">
									<input type="submit" name="add_to_cart" class="btn btn-info" value="Add to Cart">
								</div>
							</form>
						</div>	
						<?php
					endwhile;
				endif;
			endif;
			?>
			</div>
				<div style="clear:both"></div>
				<br>
				<?php $itemcount = sizeof($_SESSION['shopping_cart']); 
				if ($itemcount > 0):
				?>
					<h2 class="count">You have selected <span class="text-info"><?php echo $itemcount ?>x</span> photograph types.</h2>
				<br>
				<br>
				
				<div class="table-responsive" id="order">
					<table class="table">
						<tr><th colspan="5"><h3>Order Details</h3></th></tr>
						<tr>
							<th width="40%">Product Name</th>
							<th width="10%">Quantity</th>
							<th width="20%">Price</th>
							<th width="20%">Total</th>
							<th width="10%">Action</th>
						</tr>
				<?php endif ?>
						<?php 
						if(!empty($_SESSION['shopping_cart'])):
							$total = 0;
							//For each iteration of the cart array (giving them the id of product), create the following html- 
							foreach ($_SESSION['shopping_cart'] as $key => $product):
							?>		
							<tr>
								<td><?php echo $product['name']; ?></td>
								<td><?php echo $product['quantity']; ?></td>
								<td><?php echo $product['price']; ?></td>
								<td><?php echo number_format($product['quantity'] * $product['price'], 2/*ensures correct £.p display*/); ?></td>
							<td>
							<!--Linked to the delete product php above-->
								<a href="cart.php?action=delete&id=<?php echo $product['id']; ?>">
									<div class="btn-danger">Remove</div>
								</a>
							</td>
						</tr>
						<?php 
							//Works out a running total
							$total = $total + ($product['quantity'] * $product['price']);
							endforeach
							?>
							<tr>
							<td width="40%"><b>Total</b></td>
							<td width="10%"></td>
							<td width="20%"></td>
							<td width="20%"><b>&pound<?php echo number_format($total, 2) ?></b></td>
							<td width="10%"></td>
							</tr>
							<tr>
								<td colspan="5" align="center">
								<?php 
									//Will appear assuming there is at least one product
									if (isset($_SESSION['shopping_cart'])):
									if (count($_SESSION['shopping_cart']) > 0):
								?>
									<a href="checkout.php" class="btn-success">Checkout</a>
								<?php endif; endif ?>
								</td>
							</tr>
							<?php
						endif;
						?>
				</table>
			</div>
		</div>
	</body>
</html>
