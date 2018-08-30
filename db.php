<?php 
			$connect = mysqli_connect('', '', '', '');
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
									<input type="submit" name="add_to_cart" class="btn btn-info" href="cart.php#order" value="Add to Cart">
								</div>
							</form>
						</div>	
						<?php
					endwhile;
				endif;
			endif;
			?>
