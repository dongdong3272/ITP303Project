<?php
session_start(); // have to call session_start() before anything else
require '../config/config.php';


// A Gaint If statement/ if the user is not logged in, do the usual things. 
// Check password, etc.
// Else, redirect user out of the page

if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]){
    // There are two ways for user to get to this page. If they simpliy clicked on a link to get to 
    // login.php, they use a GET request. Therefore the below statement will not be run
	
	// If the user is actually submitting the form, it would be via POST request. Therefore the below POST statement will run
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		// Users try to submit the form (not simply get to this page)
		// Then we check if username and password field have been checked
		if ( empty($_POST['username']) || empty($_POST['password']) ) {

			$error = "Please enter username and password.";

		}
		else {
			// User has provided an username and password
			// We need to check if username/password combination is correct 

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			// hash the user's password input
			$passwordInput = hash("sha256", $_POST["password"]);

			// Search the users table. See if there is record with the given name AND password
			$sql = "SELECT * FROM users
						WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordInput . "';";

			//echo "<hr>" . $sql . "<hr>";
			
			$results = $mysqli->query($sql);

			if(!$results) {
				echo $mysqli->error;
				exit();
			}

			if($results->num_rows == 1) {
				// If there is match, meaning that we found an account
				// Log the user in

				// Store some user info in session
				$_SESSION["logged_in"] = true;
				$_SESSION["username"] = $_POST["username"];

				// Redirect the user to the homepage
				// header() function make a GET request
				// header("Location: https://www.google.com");
				header("Location: ../home/home.php");
			
			}
			else {
				$error = "Invalid username or password.";
			}
		} 
	}
}
else{
	header("Location: ../home/home.php");
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | ourDeal</title>
    <link rel="stylesheet" href="../stylesheet/nav.css" />
    <link rel="stylesheet" href="../stylesheet/login.css" />
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
        .invalid-text{
            margin-left: 20px !important;
            font-family: 'Libre Caslon Text', serif;
        }
    </style>
</head>
<body>
	<?php include '../nav/nav.php'; ?>
    <div id="total_container">
        <!-- Big Title-->
        <div class="container">
            <div class="row">
                <h1 class="col-12 mt-4 mb-4 login_title">Login</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <!-- Log In form-->
        <div class="container">

            <form action="login.php" method="POST">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-9 ml-sm-auto invalid-text">
                        <!-- Show errors here. -->
                        <?php
                            if ( isset($error) && !empty($error) ) {
                                echo $error;
                            }
                        ?>
                    </div>
                </div> <!-- .row -->
                

                <div class="form-group row">
                    <label for="username-id" class="col-12 col-form-label text-sm-right login_sub_title">Username:</label>
                    <div class="col-12">
                        <input type="text" class="form-control login_text_input" id="username-id" name="username">
                        <small id="username-error" class="invalid-feedback invalid-text">Username is required.</small>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="password-id" class="col-12 col-form-label text-sm-right login_sub_title">Password:</label>
                    <div class="col-12">
                        <input type="password" class="form-control login_text_input" id="password-id" name="password">
                        <small id="password-error" class="invalid-feedback invalid-text">Password is required.</small>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary login_sub_title login_btn">Login</button>
                    </div>
                </div> <!-- .form-group -->
            </form>

            <div class="row">
                <div class="col-sm-9 ml-sm-auto login_sub_title">
                    Do not have an account? <a href="../register/register-form.php">Register now!</a>
                </div>
            </div> <!-- .row -->

        </div> <!-- .container -->
    </div>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"
    ></script>
    <script>
        // JS should always be the first line of defense
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#username-id').value.trim().length == 0 ) {
				document.querySelector('#username-id').classList.add('is-invalid');
			} else {
				document.querySelector('#username-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#password-id').value.trim().length == 0 ) {
				document.querySelector('#password-id').classList.add('is-invalid');
			} else {
				document.querySelector('#password-id').classList.remove('is-invalid');
			}
			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
    </script>
</body>
</html>