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