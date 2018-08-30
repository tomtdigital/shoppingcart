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
								<a href="index.php?action=delete&id=<?php echo $product['id']; ?>">
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