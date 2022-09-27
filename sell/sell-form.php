<?php
session_start();
require '../config/config.php';

// A Gaint If statement/ if the user is logged in, do the usual things. 
// Check password, etc.
// Else, redirect user out of the page
if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]){
	header("Location: ../home/home.php");
}
else{
	// Do the usual thing

	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	// Types:
	$sql_types = "SELECT * FROM types;";
	$results_types = $mysqli->query($sql_types);
	if ( $results_types == false ) {
		echo $mysqli->error;
		exit();
	}

	// Get the user_id
	$username = $_SESSION["username"];
	$sql_user = "SELECT id FROM users WHERE username='" . $username . "'";
	$results_user = $mysqli->query($sql_user);
	if ( $results_user == false ) {
		echo $mysqli->error;
		exit();
	}
	$user_id = $results_user->fetch_assoc();  
	$user_id = $user_id["id"];
	//echo $user_id;

	// Close DB Connection
	$mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sell Goods | ourDeal</title>
    <link rel="stylesheet" href="../stylesheet/nav.css">
    <link rel="stylesheet" href="../stylesheet/sell-form.css">
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.hidden{
			display: none;
		}
	</style>
</head>
<body>

    <?php include '../nav/nav.php'; ?>
	
    <div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Sell My Good</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

    
	<div class="container">

		<form action="sell_confirmation.php" method="POST" enctype="multipart/form-data">

			<div class="form-group row">
				<label for="product-id" class="col-sm-3 col-form-label text-sm-right">Product Name: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="product-id" name="product">
					<small id="name-error" class="invalid-feedback invalid-text">Product Name is required.</small>
				</div>
			</div> <!-- .form-group -->

            <div class="form-group row">
				<label for="type_id" class="col-sm-3 col-form-label text-sm-right">Product Type: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<select name="type_id" id="type-id" class="form-control">

						<?php while( $row = $results_types->fetch_assoc() ): ?>

							<option value="<?php echo $row['id']; ?>">
								<?php echo $row['type']; ?>
							</option>

						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="image" class="col-sm-3 col-form-label text-sm-right">Product Picture:</label>
				<div class="col-sm-9">
                    <!-- <input type="file" class="form-control-file" id="product_pic"> -->
                    <input class="form-control" type="file" id="image" name="image">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="description-id" class="col-sm-3 col-form-label text-sm-right">Product Description:</label>
				<div class="col-sm-9">
                    <!-- <input type="text" class="form-control input-large" id="title-id" name="title"> -->
                    <textarea class="form-control" id="description-id" name="description" rows="3"></textarea>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="price-id" class="col-sm-3 col-form-label text-sm-right">Price($): <span class="text-danger">*</span></label>
				<div class="col-sm-9">
                    <input type="number" class="form-control" id="price-id" name="price">
					<small id="price-error" class="invalid-feedback invalid-text">Price is required.</small>
				</div>
			</div> <!-- .form-group -->

            <div class="form-group row">
				<label for="bargain-id" class="col-sm-3 col-form-label text-sm-right">Allow Bargain: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<select name="bargain_id" id="bargain-id" class="form-control">
						<option value="1">Yes</option>
                        <option value="2">No</option>
					</select>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row hidden">
				<label for="user-id" class="col-sm-3 col-form-label text-sm-right">User ID: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
                    <input type="number" class="form-control" id="user-id" name="user_id" value=<?php echo $user_id; ?>>
				</div>
			</div> <!-- .form-group -->



            <div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->

		</form>

	</div> <!-- .container -->


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"
    ></script>
	<script>
		// JS should always be the first line of defense
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#product-id').value.trim().length == 0 ) {
				document.querySelector('#product-id').classList.add('is-invalid');
			} else {
				document.querySelector('#product-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#price-id').value.trim().length == 0 ) {
				document.querySelector('#price-id').classList.add('is-invalid');
			} else {
				document.querySelector('#price-id').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>
</body>
</html>