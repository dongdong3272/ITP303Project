<?php
session_start();

if ( !isset($_GET['product_id']) || empty($_GET['product_id']) ) {
	$error = "Invalid Product ID.";
} else {

	require '../config/config.php';

	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');


	$sql = "SELECT * 
					FROM products
					JOIN types
						ON products.type_id = types.id
                    JOIN users
                        ON products.user_id = users.id
					WHERE products.id = " . $_GET['product_id'] . ";";

	//echo "<hr>" . $sql . "<hr>";

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	// Since we only get 1 result (searching by primary key), we don't need a loop.
	$row = $results->fetch_assoc();

    //var_dump($row);

	$mysqli->close();

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Product Details | ourDeal</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../stylesheet/nav.css" />
    <link rel="stylesheet" href="../stylesheet/details.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous"
    />
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style></style>
</head>
<body>
    <?php include '../nav/nav.php'; ?>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Product Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if ( isset($error) && !empty($error) ) : ?>

					<div class="text-danger">
						<?php echo $error; ?>
					</div>

				<?php else : ?>

					<table class="table table-responsive">
                        <tr>
							<th class="text-right">Product Name:</th>
							<td>
                                <image src="<?php echo $row['image']; ?>" 
                                       alt="<?php echo $row['name']; ?>"
                                       class="product_pic"
                                >
                            </td>
						</tr>
						<tr>
							<th class="text-right">Product Name:</th>
							<td><?php echo $row['name']; ?></td>
						</tr>
						<tr>
							<th class="text-right">Product Price:</th>
							<td><?php echo $row['price']; ?></td>
						</tr>
						<tr>
							<th class="text-right">Product Type:</th>
							<td><?php echo $row['type']; ?></td>
						</tr>
						<tr>
							<th class="text-right">Product Description:</th>
							<td><?php echo $row['description']; ?></td>
						</tr>
						
						<tr>
							<th class="text-right">Allow Bargain:</th>
							<td>
                                <?php 
                                    if($row['allow_bargain'] == 1)
                                        echo "Yes"; 
                                    else 
                                        echo "No";
                                ?>
                            </td>
						</tr>
					</table>
	</div> <!-- .container -->

    <div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Seller Information</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

    <div class="container">
		<div class="row mt-4">
			<div class="col-12">
					<table class="table table-responsive">
						<tr>
							<th class="text-right">Username:</th>
							<td><?php echo $row['username']; ?></td>
						</tr>
						<tr>
							<th class="text-right">Email:</th>
							<td><?php echo $row['email']; ?></td>
						</tr>
                        <tr>
							<th class="text-right">Phone:</th>
							<td><?php echo $row['phone']; ?></td>
						</tr>
					</table>
	</div> <!-- .container -->

				<?php endif; ?>
    

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-3 mb-4">
			<div class="col-12">
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-primary">Back to Search Results</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"
    ></script>
</body>
</html>