<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register | ourDeal</title>
	<link rel="stylesheet" href="../stylesheet/nav.css" />
    <link rel="stylesheet" href="../stylesheet/register-form.css" />
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
        #total_container{
            height: 635px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include '../nav/nav.php'; ?>
    <div id="total_container">
        <div class="container">
            <div class="row">
                <h1 class="col-12 mt-4 mb-4 register_title">User Registration</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">

            <form action="register_confirmation.php" method="POST">

                <div class="form-group row">
                    <label for="username-id" class="col-12 col-form-label text-sm-right register_sub_title">Username: <span class="text-danger">*</span></label>
                    <div class="col-12">
                        <input type="text" class="form-control register_text_input" id="username-id" name="username">
                        <small id="username-error" class="invalid-feedback invalid-text">Username is required.</small>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="email-id" class="col-12 col-form-label text-sm-right register_sub_title">Email: <span class="text-danger">*</span></label>
                    <div class="col-12">
                        <input type="email" class="form-control register_text_input" id="email-id" name="email">
                        <small id="email-error" class="invalid-feedback invalid-text">Email is required.</small>
                    </div>
                </div> <!-- .form-group -->	

                <div class="form-group row">
                    <label for="password-id" class="col-12 col-form-label text-sm-right register_sub_title">Password: <span class="text-danger">*</span></label>
                    <div class="col-12">
                        <input type="password" class="form-control register_text_input" id="password-id" name="password">
                        <small id="password-error" class="invalid-feedback invalid-text">Password is required.</small>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="password-id" class="col-12 col-form-label text-sm-right register_sub_title">Phone: </label>
                    <div class="col-12">
                        <input type="text" class="form-control register_text_input" id="phone-id" name="phone" placeholder="123-456-7890">
                        <!-- <small id="phone-error" class="invalid-feedback">Password is required.</small>  -->
                    </div>
                </div> <!-- .form-group -->

                <div class="row">
                    <div class="ml-auto col-sm-9">
                        <span class="text-danger font-italic register_sub_title">* Required</span>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary register_sub_title register_btn">Register</button>
                    </div>
                </div> <!-- .form-group -->

                <div class="row">
                    <div class="col-12 register_sub_title">
                        Already have an account? <a href="../login/login.php">Login in here</a>.
                    </div>
                </div> <!-- .row -->

            </form>
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

			if ( document.querySelector('#email-id').value.trim().length == 0 ) {
				document.querySelector('#email-id').classList.add('is-invalid');
			} else {
				document.querySelector('#email-id').classList.remove('is-invalid');
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