<?php if(!empty($_SESSION['shopping_cart'])):
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
									<a href="index.php" class="btn-info change">Change Order</a>
								</td>
							</tr>
							<?php
						endif;
						?>