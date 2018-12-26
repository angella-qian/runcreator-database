<?php

	require "config.php";

	if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) {
		// User is not logged.

		if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
			// Form was submitted.

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if ($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			$username = $_POST['username'];
			$password = hash('sha256', $_POST['password']);

			$sql = "SELECT * 
						FROM users
						WHERE username = '$username'
						AND password = '$password';";

			$results = $mysqli->query($sql);

			if ( !$results ) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}

			$mysqli->close();

			if ( empty($_POST['username']) || empty($_POST['password']) ) {
				// Empty variables
				$error = 'Please fill out username and password.';
			} elseif ( $results->num_rows == 1 ) {
				// Correct credentials
				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $_POST['username'];
				header('Location: home.php');
			} else {
				// Invalid credentials
				$error = 'Invalid credentials.';
			}
		}

	} else {
		// User is already logged in – redirect them to homepage.
		header('Location: home.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>RunCreator | Login</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    
    <!-- Bootstrapious Sidebar Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <link href="https://drive.google.com/uc?id=1VKcKNMoTGj6Jn2SPysUxtsNzj5Ou4xH2" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <style>
    	img {
    		margin: 20px auto 5px auto;
    	}
    	body {
    		text-align: center;
    	}
    	.container {
    		margin: 50px auto;
    		padding: 50px 50px;
    		width: 500px;
    		background-color: #FFF;
    	}
    	h2 {
    		margin-bottom: 0px;
    	}

	</style>
</head>
<body>

	<div class="container">
		<div class="row">
			<img src="https://drive.google.com/uc?id=1ugPAZevKbXsINqOvfl8NstvLuPn1_GzQ" alt="App Icon">
			<h2 class="col-12">Welcome to RunCreator!</h2>
			<p class="col-12">Please login to your account</p>
		</div> <!-- .row -->

		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-12 ml-sm-auto">
					<!-- Show errors here. -->
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->
			
			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-left">Username:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-left">Password:</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-12 mt-2">
					<button type="submit" class="btn btn-primary submit">Login</button>
				</div>
			</div> <!-- .form-group -->
		</form>

		<div class="row">
			<div class="col-sm-12 ml-sm-auto">
				<div><br/>Don't have an account?</div>
				<a href="register_form.php" class="redirect-link">Create an account</a>
			</div>
		</div> <!-- .row -->

	</div> <!-- .container -->
</body>
</html>