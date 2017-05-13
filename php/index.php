#!/usr/bin/php5-cgi
<?php
ob_start();
session_start();
require_once("config.php");

if (isset($_SESSION['USER_ID']) != "") {
	header("Location: home.php");
	exit;
}

$error = false;
$emailError = false;
$passError = false;
$nameError = false;

if( isset($_POST['btn-login']) ) { 
	// prevent sql injections/ clear user invalid inputs
	$email = trim($_POST['email']);
	$email = strip_tags($email);
	$email = htmlspecialchars($email);

	$pass = trim($_POST['pass']);
	$pass = strip_tags($pass);
	$pass = htmlspecialchars($pass);
	// prevent sql injections / clear user invalid inputs

	if (empty($email)) {
		$error = true;
		$emailError = "Please enter your email address.";
	} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
		$error = true;
		$emailError = "Please enter valid email address.";
	}

	if (empty($pass)) {
		$error = true;
		$passError = "Please enter your password.";
	}

	// if there's no error, continue to login
	if (!$error) {
		$password = hash('sha256', $pass); // password hashing using SHA256

		$res=mysqli_query($con,"SELECT USER_ID,PASSWORD FROM USER_INFO WHERE EMAIL='$email'");
		$row=mysqli_fetch_array($res);
		$count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

		if( $count == 1 && $row['PASSWORD']==$password ) {
			$_SESSION['USER_ID'] = $row['USER_ID'];
			header("Location: home.php");
		} else {
			$errMSG_A = "Incorrect Credentials, Try again...";
		}
	}
} else if ( isset($_POST['btn-signup']) ) {
	// clean user inputs to prevent sql injections
	$fname = trim($_POST['fname']);
	$fname = strip_tags($fname);
	$fname = htmlspecialchars($fname);

	$email = trim($_POST['email']);
	$email = strip_tags($email);
	$email = htmlspecialchars($email);

	$pass = trim($_POST['pass']);
	$pass = strip_tags($pass);
	$pass = htmlspecialchars($pass);

	// basic name validation
	if (empty($fname)) {
		$error = true;
		$nameError = "Please enter your first name.";
	} else if (strlen($fname) < 3) {
		$error = true;
		$nameError = "Name must have atleat 3 characters.";
	} else if (!preg_match("/^[a-zA-Z ]+$/",$fname)) {
		$error = true;
		$nameError = "Name must contain alphabets and space.";
	}

	//basic email validation
	if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
		$error = true;
		$emailError = "Please enter valid email address.";
	} else {
		// check email exist or not
		$query = "SELECT EMAIL FROM USER_INFO WHERE EMAIL='$email'";
		$result = mysqli_query($con,$query);
		$count = mysqli_num_rows($result);
		if ($count!=0) {
			$error = true;
			$emailError = "Provided Email is already in use.";
		}
	}
	// password validation
	if (empty($pass)){
		$error = true;
		$passError = "Please enter password.";
	} else if(strlen($pass) < 6) {
		$error = true;
		$passError = "Password must have atleast 6 characters.";
	}

	// password encrypt using SHA256();
	$password = hash('sha256', $pass);

	// if there's no error, continue to signup
	if( !$error ) {
		$query = "INSERT INTO USER_INFO(EMAIL,PASSWORD,FIRST_NAME) VALUES('$email','$password','$fname')";
		$res = mysqli_query($con,$query);

		if ($res) {
			$errTyp = "success";
			$errMSG_B = "Successfully registered, you may login now";
			unset($fname);
			unset($email);
			unset($pass);
		} else {
			$errTyp = "danger";
			$errMSG_B = "Something went wrong, try again later..."; 
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>TRABLR</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel='stylesheet' href='/stylesheets/style.css' /> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
</head>

<body>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8" style="text-align:center;margin:auto"><img src="trablr_logo.jpg" alt="TRABLR LOGO" style="width:100%;max-width:350px;"></div>
		<div class="col-sm-2"></div>
	</div>

	<div class="row"> <!--main row-->
	<div class="col-sm-4"></div> <!--left side column gap-->
	<div class="col-sm-4"> <!--main column-->
		
		<br><br>
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<!--div class="container"-->
					<ul class="nav nav-tabs" >
						<li class="active" style="width: 50%;font-size:auto;"><a data-toggle="tab" href="#signindiv"><span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;&nbsp;Sign in</a></li>
						<li style="width: 50%;font-size:auto;"><a data-toggle="tab" href="#registerdiv"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;&nbsp;Register</a></li>
					</ul>
				<!--/div-->
			</div>
			
			<div class="panel-body">
			<div class="tab-content">
			
				<div id="signindiv" class="tab-pane fade in active">
				<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
					
			<?php 	if ( isset($errMSG_A) ) { ?>
					<div class="form-group">
						<div class="col-sm-12">
						<div class="alert alert-danger">
    						<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG_A; ?>
                		</div>
                		</div>
	               	</div>
	        <?php 	} ?>

					<div class="form-group usernameDiv">
						<div class="col-sm-12">
							<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="text" name="email" class="form-control" id="inputUsername" placeholder="Email&#42;" />
							</div>
							<span class="text-danger"><?php echo $emailError; ?></span>
						</div>
					</div>
					
					<div class="form-group usernameDiv">
						<div class="col-sm-12">
							<div class="input-group">
                			<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" name="pass" class="form-control" id="inputsignPassword" placeholder="Password&#42;" />
							</div>
							<span class="text-danger"><?php echo $passError; ?></span>
						</div>
					</div>
					
					<div class="form-group ">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-block btn-primary" name="btn-login" style="display: block; width: 100%;font-size:auto;"><strong>Sign in</strong></button>
						</div>
					</div>
					
				</form>
				</div>
			
				<div id="registerdiv" class="tab-pane fade">
				<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
					
			<?php 	if ( isset($errMSG_B) ) { ?>
    				<div class="form-group">
	             		<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
	    					<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG_B; ?>
	                	</div>
             		</div>
			<?php 	} ?>
					<div class="form-group">
						<div class="col-sm-12">
							<div class="input-group">
                			<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email&#42;" />
							</div>
							<span class="text-danger"><?php echo $emailError; ?></span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-12">
							<div class="input-group">
                			<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" name="pass" class="form-control" id="inputregPassword" placeholder="Password&#42;" />
							</div>
							<span class="text-danger"><?php echo $passError; ?></span>
						</div>
					</div>
											
					<div class="form-group">
						<div class="col-sm-12">
							<div class="input-group">
                			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" name="fname" class="form-control" id="inputFN" placeholder="First name&#42;" style="font-size:auto;width:100%;" />
							</div>
							<span class="text-danger"><?php echo $nameError; ?></span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-block btn-primary" name="btn-signup" style="display: block; width: 100%;font-size:auto"><strong>Register</strong></button>
						</div>
					</div>
					
				</form>
				</div>
			
			</div> <!--tab-content div-->			
			</div> <!--panelbody-->
			
		</div> <!--panel panel-->
    
	</div> <!--main column-->	
	</div> <!--main row-->

</body>
</html>
<?php ob_end_flush(); ?>
