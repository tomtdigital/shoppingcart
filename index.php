<?php include './cont.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Purchase Prints</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="cart.css">
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
			<?php include './db.php'; ?>	
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
							<th width="10%"></th>
						</tr>
				<?php endif ?>
				<?php include './basket.php'; ?>		
				</table>
			</div>
		</div>
	</body>
</html>
