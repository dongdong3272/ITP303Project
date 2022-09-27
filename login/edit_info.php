<?php
session_start();

if ( !isset($_GET['user_id']) || empty($_GET['user_id']) ) {
	echo "Invalid User ID";
	exit();
}

require '../config/config.php';

// DB Connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');


$sql = "SELECT * FROM users WHERE id = " . $_GET["user_id"] . ";";
$results = $mysqli->query($sql);
if ( $results == false ) {
	echo $mysqli->error;
	exit();
}


$user = $results->fetch_assoc();

//var_dump($user);
// Close DB Connection
$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Form | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../stylesheet/nav.css" />
    <link rel="stylesheet" href="../stylesheet/edit_info.css" />
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous"
    />
	<style>
	    .add-margin{
            margin-top: 30px;
        }
        .sub-btn{
            background-color: orange !important;
            border-color: orange !important;
        }
        .reset-btn{
            background-color: lightblue !important;
            border-color: lightblue !important;
        }
        .back-btn{
            background-color: var(--color-usc-red) !important;
            border-color: var(--color-usc-red) !important;
        }

    </style>
</head>
<body>
    <?php include '../nav/nav.php'; ?>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Edit Your Personal Information</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">

		<form action="edit_confirmation.php" method="POST">

			
			<div class="form-group row">
				<label for="username" class="col-sm-3 col-form-label text-sm-right">
					Username: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-9">
					<input type="text" name="username" id="username" class="form-control" value="<?php echo $user['username']; ?>" disabled>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="email-id" class="col-sm-3 col-form-label text-sm-right">
					Email: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-9">
					<input type="email" name="email" id="email-id" class="form-control" value="<?php echo $user['email']; ?>">
                    <small id="name-error" class="invalid-feedback invalid-text">Product Name is required.</small>
				</div>
			</div> <!-- .form-group -->

		

			<div class="form-group row">
				<label for="phone-id" class="col-sm-3 col-form-label text-sm-right">
					Phone:
				</label>
				<div class="col-sm-9">
					<input type="number" name="phone" id="phone-id" class="form-control" value="<?php echo $user['phone']; ?>">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="ml-auto col-sm-9">
					<span class="text-danger font-italic">* Required</span>
				</div>
			</div> <!-- .form-group -->

			<input type="hidden" name="user_id" value="<?php echo $user["id"]; ?>">

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary sub-btn">Submit</button>
					<button type="reset" class="btn btn-light reset-btn">Reset</button>
				</div>
			</div> <!-- .form-group -->
            <div class="form-group row add-margin">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
                <a href="profile.php?user_id=<?php echo $user["id"]; ?>" role="button" class="btn btn-primary back-btn">Back to Profile</a>
				</div>
			</div> <!-- .form-group -->

		</form>
	</div> <!-- .container -->
</body>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"
    ></script>
    <script>
		// JS should always be the first line of defense
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#email-id').value.trim().length == 0 ) {
				document.querySelector('#email-id').classList.add('is-invalid');
			} else {
				document.querySelector('#email-id').classList.remove('is-invalid');
			}
			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>
</html>