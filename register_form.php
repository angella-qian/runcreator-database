<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>RunCreator | Register</title>

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
			<p class="col-12">Register for an account</p>
		</div> <!-- .row -->

		<form action="register_confirmation.php" method="POST">

			<div class="form-group row">
				<label for="username-id" class="col-sm-4 col-form-label text-sm-left">Username: <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="username-id" name="username">
					<small id="username-error" class="invalid-feedback">Username is required.</small>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="email-id" class="col-sm-4 col-form-label text-sm-left">Email: <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="email-id" name="email">
					<small id="email-error" class="invalid-feedback">Email is required.</small>
				</div>
			</div> <!-- .form-group -->	

			<div class="form-group row">
				<label for="password-id" class="col-sm-4 col-form-label text-sm-left">Password: <span class="text-danger">*</span></label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="password-id" name="password">
					<small id="password-error" class="invalid-feedback">Password is required.</small>
				</div>
			</div> <!-- .form-group -->

			<div class="row">
				<div class="ml-auto col-sm-3 text-sm-right">
					<span class="text-danger font-italic">* Required</span>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-12 mt-3">
					<button type="submit" class="btn btn-primary submit">Register</button>
				</div>
			</div> <!-- .form-group -->

			<div class="row">
				<div class="col-sm-12 ml-sm-auto">
					<div><br/>Already have an account?</div>
					<a href="login.php" class="redirect-link">Login to account</a>
				</div>
			</div> <!-- .row -->

		</form>
	</div> <!-- .container -->
	<script>
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