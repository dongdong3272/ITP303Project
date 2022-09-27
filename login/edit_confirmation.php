<?php
//var_dump($_POST);

if ( !isset($_POST['email']) || empty($_POST['email']) ) {

	// Missing required fields.
	$error = "Please fill out all required fields.";

} else {
	// All required fields provided.
	require '../config/config.php';

	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
	}

	if ( isset($_POST['phone']) && !empty($_POST['phone']) ) {
		// User selected album value.
		$phone= $_POST['phone'];
	} else {
		// User did not select album value.
		$phone = "";
	}

	$sql = "UPDATE users
					SET email = '" . $_POST['email'] . "'," .
                        "phone = '" . $phone . "'" . 
					" WHERE id = " . $_POST['user_id'] . ";";

	//echo "<hr>" . $sql . "<hr>";

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Confirmation | ourDeal</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../stylesheet/edit_confirmation.css" />
</head>
<body>
	
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Confirmation</h1>
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

		<div class="text-success">
			Your Personal Information was successfully edited.
		</div>

	<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>