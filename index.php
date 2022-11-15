<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1); // display error 

session_start();

include_once 'classes/Crud.php';
$result = $crubObj->getRecord();

// generating the session value
if(isset($_POST['add_cart'])){
	// adding logic to add special offers from array. Special logic array build from db table 
	$offerAmount = $_POST['quantity'] / $result['special_offers'][$_GET['id']][0]['so_unit'];
	if($offerAmount >= 1){
		if(is_float($offerAmount)){
			// logic to whole and fracttion number
			list($whole, $decimal) = explode('.', $offerAmount);
			$price = $result['special_offers'][$_GET['id']][0]['so_price'] * $whole;
			$price = $price + substr($decimal / 3, 0, 1) * $_POST['price'];
		}else{
			// logic to only whole number after divided by offer unit
			$price = $result['special_offers'][$_GET['id']][0]['so_price'] * $offerAmount;	
		}
		
	}else{
		// without any offer
		$price = $_POST['price'] * $_POST['quantity'];
	}

	if(isset($_SESSION['cart'])){
		$session_array_id = array_column($_SESSION['cart'], 'id');
		//if(!in_array($_GET['id'], $session_array_id)){
			$session_array = array(
			'id' => $_GET['id'],
			'name' => $_POST['name'],
			'price' => $price,
			'quantity' => $_POST['quantity']
			);
			$_SESSION['cart'][] = $session_array;
		//}
	}else{
		$session_array = array(
			'id' => $_GET['id'],
			'name' => $_POST['name'],
			'price' => $price,
			'quantity' => $_POST['quantity']
		);
		$_SESSION['cart'][] = $session_array;
	}
}

// clearing the session
if(isset($_GET['action'])){
	if($_GET['action'] == "clearcart"){
		unset($_SESSION['cart']);
	}

	if($_GET['action'] == "remove"){
		foreach($_SESSION['cart'] as $key => $value){
			if($value['id'] == $_GET['id']){
				unset($_SESSION['cart'][$key]);
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Checkout page</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-8">
					<h2>Shopping</h2>
					<div class="col-md-12">
						<div class="row">
							<?php foreach ($result['products'] as $result_products) { 
								/*echo "<pre>";
								print_r($result_products);exit;*/
							 ?>
								<div class="col-md-4">
								<form method="POST" action="index.php?id=<?php echo $result_products['product_id']; ?>">
									<img src="img/<?php echo $result_products['image']; ?>" style="height: 100px;">
									<h2 class="text-center"><?php echo  $result_products['title'];?></h2>
									<h2 class="text-center"><?php echo  number_format($result_products['unit_price'], 2);?></h2>
									<input type="hidden" name="name" value="<?php echo $result_products['title'];?>">
									<input type="hidden" name="price" value="<?php echo $result_products['unit_price'];?>">
									Quantity: <input style="width: 150px;" type="text" name="quantity" value="1">
									<div class="row">
									<div class="col-md-12 pull-left">
										<p>
										<?php
										echo 'Special Offer <br />'; 
										if(isset($result['special_offers'])){
											foreach($result['special_offers'][$result_products['product_id']] as $offers){
												echo 'Buy:'.$offers['so_unit'].', ';
												echo 'Price:'.$offers['so_price']."<br />"; 
											}
										}
										?>
										</p>	
									</div>
									</div>
									<input type="submit" name="add_cart" class="btn btn-info btn-block" value="Add to cart">

								</form>
								</div>
							<?php } ?>
						</div>
					</div>
					
				</div>
				<div class="col-md-4">
					<h2>Cart details</h2>
					<?php 

						$total = 0;

						$output = '';

						$output .= "
							<table class='table table-bordered table-striped'>
								<tr>
									<th>Product Name</th>
									<th>Product Price</th>
									<th>Product Quantity</th>
									<th>Total price</th>
									<th>Action</th>
								</tr>
							
						";

						if(!empty($_SESSION['cart'])){
							foreach($_SESSION['cart'] as $key => $value){
								$output .= "
									<tr>
										<td>".$value['name']."</td>
										<td>".$value['price']."</td>
										<td>".$value['quantity']."</td>
										<td>".number_format($value['price'], 2)."</td>
										<td>
											<a href='index.php?action=remove&id=".$value['id']."'>
												<button class='btn btn-danger btn-block'>Remove</button>
											</a>
										</td>
									</tr>
								";
								$total = $total + $value['price'];
							}
						}

						$output .= "
							<tr>
								<td colspan=2></td>
								<td><b>Total price</b></td>
								<td>".number_format($total, 2)."</td>
								<td>
									<a href='index.php?action=clearcart'>
										<button class='btn btn-warning'>Clear cart</button>
									</a>
								</td>
							</tr>
						";

						$output .= "</table>";
						echo $output;
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>