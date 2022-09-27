<?php
session_start();

// A Gaint If statement/ if the user is logged in, do the usual things. 
// Check password, etc.
// Else, redirect user out of the page
if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]){
	header("Location: ../home/home.php");
}
else{
	// Do the usual thing


    require '../config/config.php';
	// Get the personal info
	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
	}
	$sql = "SELECT * FROM users WHERE username = '" . $_SESSION["username"] ."';";


	//echo "<hr>" . $sql . "<hr>";

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}
	$user_info = $results->fetch_assoc();
	//var_dump($user_info);

	// Get all the products that is being sold by this user
	$user_id = $user_info["id"];
	$sql_products = "SELECT * FROM products WHERE user_id = " . $user_id .";";
	//echo "<hr>" . $sql_products . "<hr>";
	$results_products = $mysqli->query($sql_products);
	if ( !$results_products ) {
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
	<title>Profile | ourDeal</title>
    <link rel="stylesheet" href="../stylesheet/nav.css" />
    <link rel="stylesheet" href="../stylesheet/profile.css" />
	<link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
	<style>
		.product_pic {
			margin: 0;
			padding: 0;
			height : 100px;
		}
		/* -- Media queries to add CSS for bigger screens -- */
		/* iPad vertical is 768px. Media query set for screens >=768px */
		@media (min-width: 768px) {
			.product_pic{
				height : 150px;
			}
		}

		/* Small desktop starts at 992px. Media query set for screens >=992px */
		@media (min-width: 992px) {
			.product_pic{
				height : 200px;
			}
		}
	</style>
</head>
<body>
	<?php include '../nav/nav.php'; ?>
    <div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Manage Your Account</h1>
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
                    <!-- Need to change to php statement below  -->

					<table class="table table-responsive">
						<tr>
							<th class="text-right">Username:</th>
							<td> <?php echo $user_info["username"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Email:</th>
							<td> <?php echo $user_info["email"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Phone:</th>
							<td> <?php echo $user_info["phone"]; ?></td>
						</tr>
					</table>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->

        <!--  Edit Info Button    -->
		<div class="row mt-3 mb-4">
			<div class="col-12">
				<a href="edit_info.php?user_id=<?php echo $user_id; ?>" class="btn btn-warning">Edit Personal Info</a>
			</div> <!-- .col -->
		</div> <!-- .row -->


        <!-- Display all the products assocative with this account-->
        <div class="row">
            <h1 class="col-12 mt-4">Your Goods for Sale</h1>
		</div> <!-- .row -->

        <div class="row mt-4">
			<div class="col-12">

				<?php if ( isset($error) && !empty($error) ) : ?>
				<?php else : ?>
                    <!-- Tables contains data  -->

				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
						    <th></th>
                            <th>Product Picture</th>
							<th>Product Name</th>
							<th>Description</th>
							<th>Price</th>
							<th>Allow Bargain</th>
						</tr>
					</thead>
					<tbody>

					    <?php while($row = $results_products->fetch_assoc()): ?>
							<tr>
								<td>
									<a onclick= "return confirm('Are you sure you want to delete your product?');" 
									   href="delete.php?product_id=<?php echo $row['id'];?>&product_name=<?php echo $row['name']; ?>" 
									   class="btn btn-outline-danger delete-btn"
									>
									   Delete
									</a>
								</td>
								<td><img src="<?php echo $row["image"]?>" alt="<?php echo $row["name"]?>" class="product_pic"></td>
								<td><?php echo $row["name"]?></td>
								<td><?php echo $row["description"]?></td>
                                <td>$<?php echo $row["price"]?></td>
								<td>
									<?php if($row["allow_bargain"] == 1): ?>
									  Yes
									<?php else: ?>
									  No
									<?php endif; ?>
								</td>
						    </tr>
						<?php endwhile; ?>

					</tbody>
				</table>

				<?php endif; ?>

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