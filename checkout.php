<?php
	session_start()
?>

<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="cart.css">
</head>
<body>
	<div class="container">
		<h1 class="purchase text-white">Review your order-</h1>
		<div class="table-responsive">
					<table class="table">
						<tr><th colspan="5"><h3>Order Details</h3></th></tr>
						<tr>
							<th width="40%">Product Name</th>
							<th width="20%">Quantity</th>
							<th width="20%">Price</th>
							<th width="20%">Total</th>
						</tr>
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
						</tr>
						<?php 
							$total = $total + ($product['quantity'] * $product['price']);
							endforeach
							?>
							<tr>
							<td width="40%"><b>Total</b></td>
							<td width="20%"></td>
							<td width="20%"></td>
							<td width="20%"><b>£<?php echo number_format($total, 2) ?></b></td>
							</tr>
							<tr>
								<td colspan="5" align="center">
									<a href="cart.php" class="btn-info change">Change Order</a>
								</td>
							</tr>
							<?php
						endif;
						?>
				</table>
			</div>
			<div id="checkoutform">
				<h1 class="purchase text-white">Delivery Details-</h1>
				<!--if time, I would validate. For an example form, go to tdavies.co.uk/form/index.php-->
				<!--Further down the line, with more API experience, I would implement suggestions (e.g. cities,suggestion as you type) and look into location finders with post codes-->
				<form class="form-group">
					<label>Name</label>
					<br>
					<input type="text" name="name">
				</form>
				<form class="form-group">
					<label>Email</label>
					<br>
					<input type="email" name="email">
				</form>
				<form class="form-group">
					<label>Phone</label>
					<br>
					<input type="tel" name="phone">
				</form>
				<form class="form-group">
					<br>
					<label>Address Line 1</label>
					<br>
					<input type="text" name="deladd1">
				</form>
				<form class="form-group">
					<label>Address Line 2</label>
					<br>
					<input type="text" name="deladd2" id="tallinput">
				</form>
				<form class="form-group">
					<label>City</label>
					<br>
					<input type="text" name="delcity">
				</form>
				<form class="form-group">
					<label>Postcode</label>
					<br>
					<input type="text" name="delpc">
				</form>

				<!--If more time, I'd consider this on a different page for better user experience and security-->
				<!--I'd also have less line breaks and more CSS styling-->
				<h1 class="purchase text-white">Payment Details-</h1>
				<form class="form-group">
					<label>Card Type</label>
					<br>
					<input type="text" name="name">
				</form>
				<form class="form-group">
					<label>Cardholder Name</label>
					<br>
					<input type="text" name="cardholder">
				</form>
				<form class="form-group">
					<label>Card Number</label>
					<br>
					<input type="number" name="cardnumber">
				</form>
				<form class="form-group">
					<label>Expiry Date</label>
					<br>
					<input type="date" name="exp">
				</form>
				<form class="form-group">
					<!--If time, I'd do a 'what's this?' hover-->
					<label class="cvv">CVV</label>
					<br>
					<input type="text" name="cvv">
				</form>
				<br>
				<label>Billing Address (if different to delivery address)</label>
				<br>
					<br>
					<label>Line 1</label>
					<br>
					<input type="text" name="billadd1">
				</form>
				<form class="form-group">
					<br>
					<label>Line 2</label>
					<br>
					<input type="text" name="billadd1" id="tallinput">
				</form>
				<form class="form-group">
					<label>City</label>
					<br>
					<input type="text" name="billcity">
				</form>
				<form class="form-group">
					<label>Postcode</label>
					<br>
					<input type="text" name="billpc">
				</form>
				<div class="confirm text-right">
				<a href="#" class="btn-success">Confirm Payment</a>
				<!--Would link to a payment confirmation page, where the session would be destroyed-->
			</div>
		</div>
	</body>
</html>