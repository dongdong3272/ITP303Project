<?php
//var_dump($_POST);

require '../config/config.php';

// Second Defense: Do a server-side validation check. Make sure required fields have been submitted.
if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out all required fields.";
}
else{
	// Connect to the database and insert this user into the users database
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}
    // Check the users table and see if username or email address already exists
	$statement_registered = $mysqli->prepare("SELECT * FROM users 
	                                          WHERE username = ? or email = ?");
	$statement_registered->bind_param("ss", $_POST["username"], $_POST["email"]);
	$executed_registered = $statement_registered->execute();									  
	if($executed_registered){
		echo $mysqli->error;
	}
	// prepared statements for SELECT require an extra method to get result
	$statement_registered->store_result();
	// $statement_registered->num_rows will return how many results we get back
	$numrows = $statement_registered->num_rows;
	//echo "<br> $numrows";
	$statement_registered->close();
	if($numrows > 0){
		$error = "Username or email address has already been taken. Please choose another one.";
	}
	else{
		// Hash a password
		// 1st arg: the hashing algorithm
		// 2nd arg: the string you want to hash
		$password = hash("sha256", $_POST["password"]);
		//echo "<br>" . $password . "<br>"; 

        // Get the Phone number, which is optional
        if(!isset($_POST['phone']) || empty($_POST['phone']) ){
            $phone = null;
        }
        else{
            $phone = $_POST["phone"];
        }
        


		// Write SQL to insert this user into the table
		$statement = $mysqli->prepare("INSERT INTO users(username, email, password, phone) 
						VALUES(?,?,?,?)"
						);
		$statement->bind_param("ssss", $_POST["username"], $_POST["email"], $password, $phone);
		$executed = $statement->execute();
		if(!$executed){
			echo $mysqli->error;
		}
		$statement->close();

		$mysqli->close();
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration Confirmation | ourDeal</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        :root {
            --color-usc-yellow: #FFCC00;
            --color-usc-red: #990000 ;
            --color-usc-background: #faf9f2;
        }

        body{
            background-color: var(--color-usc-background) !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='487' height='243.5' viewBox='0 0 1600 800' style='&%2310; opacity: .45;&%2310;'%3E%3Cpath fill='%23fdb9a0' d='M1102.5 734.8c2.5-1.2 24.8-8.6 25.6-7.5.5.7-3.9 23.8-4.6 24.5-.2.3-16-12.3-21-17zm123.8-505.7c0-.1-4.9-9.4-7-14.2-.1-.3-.3-1.1-.4-1.6-.1-.4-.3-.7-.6-.9-.3-.2-.6-.1-.8.1l-13.1 12.3c-.2.2-.3.5-.4.8 0 .3 0 .7.2 1 .1.1 1.4 2.5 2.1 3.6 2.4 3.7 6.5 12.1 6.5 12.2.2.3.4.5.7.6.3 0 .5-.1.7-.3 0 0 1.8-2.5 2.7-3.6 1.5-1.6 3-3.2 4.6-4.7 1.2-1.2 1.6-1.4 2.1-1.6.5-.3 1.1-.5 2.5-1.9.4-.5.5-1.3.2-1.8zM33 770.3c0-.7-.5-1.2-1.2-1.2-.1 0-.3 0-.4.1-1.6.2-14.3.1-22.2 0-.3 0-.6.1-.9.4-.2.2-.4.5-.4.9 0 .2 0 4.9.1 5.9l.4 13.6c0 .3.2.6.4.9.2.2.5.3.8.3h.1c7.3-.7 14.7-.9 22-.6.3 0 .7-.1.9-.3.2-.2.4-.6.4-.9-.1-6.1-.1-13.2 0-19.1z' style='&%2310;'/%3E%3Cpath fill='%23fee272' d='M171.1 383.4c1.3-2.5 14.3-22 15.6-21.6.8.3 11.5 21.2 11.5 22.1-.1.3-20.3.1-27.1-.5zm425.3 328.4c-.1-.1-6.7-8.2-9.7-12.5-.2-.3-.5-1-.7-1.5-.2-.4-.4-.7-.7-.8-.3-.1-.6 0-.8.3L574 712c-.2.2-.2.5-.2.9 0 .3.2.7.4.9.1.1 1.8 2.2 2.8 3.1 3.1 3.1 8.8 10.5 8.9 10.6.2.3.5.4.8.4.3 0 .5-.2.6-.5 0 0 1.2-2.8 2-4.1 1.1-1.9 2.3-3.7 3.5-5.5.9-1.4 1.3-1.7 1.7-2 .5-.4 1-.7 2.1-2.4.3-.3.2-1.1-.2-1.6zm131.1-531.9c.6.2 1.3-.2 1.4-.8v-.4c.2-1.4 2.8-12.6 4.5-19.5.1-.3 0-.6-.2-.8-.2-.3-.5-.4-.8-.5-.2 0-4.7-1.1-5.7-1.3l-13.4-2.7c-.3-.1-.7 0-.9.2-.2.2-.4.4-.5.6v.1c-.8 6.5-2.2 13.1-3.9 19.4-.1.3 0 .6.2.9.2.3.5.4.8.5 5.8 1.3 12.7 2.9 18.5 4.3zm1-1.8c-.1-.1-.2-.2-.4-.2.2 0 .3.1.4.2z'/%3E%3Cg fill='%23eac5e7'%3E%3Cpath d='M699.6 472.7c-1.5 0-2.8-.8-3.5-2.3-.8-1.9 0-4.2 1.9-5 3.7-1.6 6.8-4.7 8.4-8.5 1.6-3.8 1.7-8.1.2-11.9-.3-.9-.8-1.8-1.2-2.8-.8-1.7-1.8-3.7-2.3-5.9-.9-4.1-.2-8.6 2-12.8 1.7-3.1 4.1-6.1 7.6-9.1 1.6-1.4 4-1.2 5.3.4 1.4 1.6 1.2 4-.4 5.3-2.8 2.5-4.7 4.7-5.9 7-1.4 2.6-1.9 5.3-1.3 7.6.3 1.4 1 2.8 1.7 4.3l1.5 3.3c2.1 5.6 2 12-.3 17.6-2.3 5.5-6.8 10.1-12.3 12.5-.4.2-.9.3-1.4.3zm40.8-51.3c1.5-.2 3 .5 3.8 1.9 1.1 1.8.4 4.2-1.4 5.3-3.7 2.1-6.4 5.6-7.6 9.5-1.2 4-.8 8.4 1.1 12.1.4.9 1 1.7 1.6 2.7 1 1.7 2.2 3.5 3 5.7 1.4 4 1.2 8.7-.6 13.2-1.4 3.4-3.5 6.6-6.8 10.1-1.5 1.6-3.9 1.7-5.5.2-1.6-1.4-1.7-3.9-.2-5.4 2.6-2.8 4.3-5.3 5.3-7.7 1.1-2.8 1.3-5.6.5-7.9-.5-1.3-1.3-2.7-2.2-4.1-.6-1-1.3-2.1-1.9-3.2-2.8-5.4-3.4-11.9-1.7-17.8 1.8-5.9 5.8-11 11.2-14 .4-.4.9-.6 1.4-.6zM261.3 590.9c5.7 6.8 9 15.7 9.4 22.4.5 7.3-2.4 16.4-10.2 20.4-3 1.5-6.7 2.2-11.2 2.2-7.9-.1-12.9-2.9-15.4-8.4-2.1-4.7-2.3-11.4 1.8-15.9 3.2-3.5 7.8-4.1 11.2-1.6 1.2.9 1.5 2.7.6 3.9-.9 1.2-2.7 1.5-3.9.6-1.8-1.3-3.6.6-3.8.8-2.4 2.6-2.1 7-.8 9.9 1.5 3.4 4.7 5 10.4 5.1 3.6 0 6.4-.5 8.6-1.6 4.7-2.4 7.7-8.6 7.2-15-.5-7.3-5.3-18.2-13-23.9-4.2-3.1-8.5-4.1-12.9-3.1-3.1.7-6.2 2.4-9.7 5-6.6 5.1-11.7 11.8-14.2 19-2.7 7.7-2.1 15.8 1.9 23.9.7 1.4.1 3.1-1.3 3.7-1.4.7-3.1.1-3.7-1.3-4.6-9.4-5.4-19.2-2.2-28.2 2.9-8.2 8.6-15.9 16.1-21.6 4.1-3.1 8-5.1 11.8-6 6-1.4 12 0 17.5 4 2.1 1.7 4.1 3.6 5.8 5.7z'/%3E%3Ccircle cx='1013.7' cy='153.9' r='7.1'/%3E%3Ccircle cx='1024.3' cy='132.1' r='7.1'/%3E%3Ccircle cx='1037.3' cy='148.9' r='7.1'/%3E%3Cpath d='M1508.7 297.2c-4.8-5.4-9.7-10.8-14.8-16.2 5.6-5.6 11.1-11.5 15.6-18.2 1.2-1.7.7-4.1-1-5.2-1.7-1.2-4.1-.7-5.2 1-4.2 6.2-9.1 11.6-14.5 16.9-4.8-5-9.7-10-14.7-14.9-1.5-1.5-3.9-1.5-5.3 0-1.5 1.5-1.5 3.9 0 5.3 4.9 4.8 9.7 9.8 14.5 14.8-1.1 1.1-2.3 2.2-3.5 3.2-4.1 3.8-8.4 7.8-12.4 12-1.4 1.5-1.4 3.8 0 5.3 1.5 1.4 3.9 1.4 5.3-.1 3.9-4 8.1-7.9 12.1-11.7 1.2-1.1 2.3-2.2 3.5-3.3 4.9 5.3 9.8 10.6 14.6 15.9l.2.2c1.4 1.4 3.7 1.5 5.2.2 1.7-1.2 1.8-3.6.4-5.2zM327.6 248.6l-.4-2.6c-1.5-11.1-2.2-23.2-2.3-37 0-5.5 0-11.5.2-18.5v-2.3c0-5 0-11.2 3.9-13.5 2.2-1.3 5.1-1 8.5.9 5.7 3.1 13.2 8.7 17.5 14.9 5.5 7.8 7.3 16.9 5 25.7-3.2 12.3-15 31-30 32.1l-2.4.3zm4.5-69.4c-.2 0-.3 0-.4.1-.1.1-.7.5-1.1 2.7-.3 1.9-.3 4.2-.3 6.3v2.4c-.2 6.9-.2 12.8-.2 18.3.1 12.5.7 23.5 2 33.7 11-2.7 20.4-18.1 23-27.8 1.9-7.2.4-14.8-4.2-21.3-3.9-5.5-10.9-10.6-15.9-13.3-1.4-.8-2.4-1.1-2.9-1.1zM516.3 60.8c-.1 0-.2 0-.4-.1-2.4-.7-4-.9-6.7-.7-.7 0-1.3-.5-1.4-1.2 0-.7.5-1.3 1.2-1.4 3.1-.2 4.9 0 7.6.8.7.2 1.1.9.9 1.6-.2.6-.7 1-1.2 1zm-10.2 9.7c-.5 0-1-.3-1.2-.8-.8-2.1-1.2-4.3-1.3-6.6 0-.7.5-1.3 1.2-1.3s1.3.5 1.3 1.2c.1 2 .5 3.9 1.1 5.8.2.7-.1 1.4-.8 1.6 0 .1-.2.1-.3.1zm-12-6.1c-.4 0-.8-.2-1-.5-.4-.6-.3-1.4.2-1.8 1.8-1.4 3.7-2.6 5.8-3.6.6-.3 1.4 0 1.7.6.3.6 0 1.4-.6 1.7-1.9.9-3.7 2-5.3 3.3-.2.2-.5.3-.8.3zm6.4-9.1c-.5 0-.9-.3-1.2-.7-.5-1-1.2-1.9-2.4-3.4-.3-.4-.7-.9-1.1-1.4-.4-.6-.3-1.4.2-1.8.6-.4 1.4-.3 1.8.2.4.5.8 1 1.1 1.4 1.3 1.6 2.1 2.6 2.7 3.9.3.6 0 1.4-.6 1.7-.1.1-.3.1-.5.1zm6.2-.3c-.3 0-.5-.1-.8-.2-.6-.4-.7-1.2-.3-1.8 1.2-1.7 2.3-3.4 3.3-5.2.3-.6 1.1-.9 1.7-.5.6.3.9 1.1.5 1.7-1 1.9-2.2 3.8-3.5 5.6-.2.2-.5.4-.9.4zm522.6 327.8c-.1 0-.2 0-.4-.1-2.4-.7-4-.9-6.7-.7-.7 0-1.3-.5-1.4-1.2 0-.7.5-1.3 1.2-1.4 3.1-.2 4.9 0 7.6.8.7.2 1.1.9.9 1.6-.2.6-.7 1-1.2 1zm-10.2 9.7c-.5 0-1-.3-1.2-.8-.8-2.1-1.2-4.3-1.3-6.6 0-.7.5-1.3 1.2-1.3s1.3.5 1.3 1.2c.1 2 .5 3.9 1.1 5.8.2.7-.1 1.4-.8 1.6 0 .1-.2.1-.3.1zm-12-6.1c-.4 0-.8-.2-1-.5-.4-.6-.3-1.4.2-1.8 1.8-1.4 3.7-2.6 5.8-3.6.6-.3 1.4 0 1.7.6.3.6 0 1.4-.6 1.7-1.9.9-3.7 2-5.3 3.3-.2.2-.5.3-.8.3zm6.4-9.1c-.5 0-.9-.3-1.2-.7-.5-1-1.2-1.9-2.4-3.4-.3-.4-.7-.9-1.1-1.4-.4-.6-.3-1.4.2-1.8.6-.4 1.4-.3 1.8.2.4.5.8 1 1.1 1.4 1.3 1.6 2.1 2.6 2.7 3.9.3.6 0 1.4-.6 1.7-.1.1-.3.1-.5.1zm6.2-.3c-.3 0-.5-.1-.8-.2-.6-.4-.7-1.2-.3-1.8 1.2-1.7 2.3-3.4 3.3-5.2.3-.6 1.1-.9 1.7-.5.6.3.9 1.1.5 1.7-1 1.9-2.2 3.8-3.5 5.6-.2.2-.5.4-.9.4zm310 196.4c-1.4 0-2.9-.2-4.5-.7-8.4-2.7-16.6-12.7-18.7-20-.4-1.4-.7-2.9-.9-4.4-8.1 3.3-15.5 10.6-15.4 21 0 1.5-1.2 2.7-2.7 2.8-1.5 0-2.7-1.2-2.7-2.7-.1-6.7 2.4-12.9 7-18 3.6-4 8.4-7.1 13.7-8.8.5-6.5 3.1-12.9 7.4-17.4 7-7.4 18.2-8.9 27.3-10.1l.7-.1c1.5-.2 2.9.9 3.1 2.3.2 1.5-.9 2.9-2.3 3.1l-.7.1c-8.6 1.2-18.4 2.5-24 8.4-3 3.2-5 7.7-5.7 12.4 7.9-1 17.7 1.3 24.3 5.7 4.3 2.9 7.1 7.8 7.2 12.7.2 4.3-1.7 8.3-5.2 11.1-2.4 1.6-5 2.6-7.9 2.6zm-18.7-26.7c.1 1.5.4 3 .8 4.4 1.7 5.8 8.7 14.2 15.1 16.3 2.8.9 5.1.5 7.2-1.1 2.7-2.1 3.2-4.8 3.1-6.6-.1-3.2-2-6.4-4.8-8.3-5.7-3.9-14.7-5.8-21.4-4.7z'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat:no-repeat;
            background-size: 100% 120vh;
            /*text-align: center;*/
            background-position: center;
        }
        .big-text{
            font-size: 45px;
        }
        .our-text{
            font-family: 'Libre Caslon Text', serif;
            font-size: 23px;
        }
        .login-btn{
            font-family: 'Libre Caslon Text', serif;
            font-size: 20px;
            background-color: orange !important;
            border-color: orange !important;
        }
        .back-btn{
            font-family: 'Libre Caslon Text', serif;
            font-size: 20px;
            background-color: lightblue !important;
            border-color: lightblue !important;
        }

    </style>
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 big-text">Registration Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger our-text"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success our-text"><?php echo $_POST['username']; ?> was successfully registered.</div>
				<?php endif; ?>
		</div> <!-- .col -->
	</div> <!-- .row -->

	<div class="row mt-4 mb-4">
		<div class="col-12">
			<a href="../login/login.php" role="button " class="btn btn-primary login-btn">Login</a>
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light back-btn">Back</a>
		</div> <!-- .col -->
	</div> <!-- .row -->

</div> <!-- .container -->

</body>
</html>