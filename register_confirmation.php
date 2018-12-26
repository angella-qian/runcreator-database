<?php

session_start();

if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out all required fields.";
} else {
	// All required fields provided.

	$host = "300.itpwebdev.com";
    $user = "aqian_db_user";
    $pass = "uscitp2018";
    $db = "aqian_routes_db";
	$mysqli = new mysqli($host, $user, $pass, $db);

	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$username = $_POST['username'];
	$email = $_POST['email'];
	// $password = $_POST['password'];
	$password = hash('sha256', $_POST['password']);

	$sql_registered = "SELECT *
										FROM users 
										WHERE username = '$username'
										OR email = '$email';";

	$results_registered = $mysqli->query($sql_registered);

	if (!$results_registered) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$join_date = date("Y-m-d H:i:s");
	$access_level_id = 1;

	if ( $results_registered->num_rows > 0 ) {
		$error = "Username or email already registered.";
	} else {
		$sql = "INSERT INTO users (email, username, password, joinDate, accessLevelID)
		VALUES ('$email', '$username', '$password', '$join_date', $access_level_id);";

		// echo "<hr>$sql<hr>";

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

	}

	$mysqli->close();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>RunCreator | Confirmation</title>

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
			<p class="col-12">User Registration Status:</p>
		</div> <!-- .row -->

		<div class="row">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success"><?php echo $username; ?> was successfully registered.</div>
				<?php endif; ?>
		</div> <!-- .col -->
	</div> <!-- .row -->

	<div class="row mt-4 mb-4">
		<div class="col-12">
			<a href="login.php" role="button" class="btn btn-primary submit">Login</a>
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
		</div> <!-- .col -->
	</div> <!-- .row -->

</div> <!-- .container -->

</body>
</html>