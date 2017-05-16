#!/usr/bin/php5-cgi
<?php
ob_start();
session_start();
require_once("config.php");

if ( !isset($_SESSION['USER_ID']) ) {
	header("Location: index.php");
	exit;
} else {
	$USER_ID=$_SESSION['USER_ID'];
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
	<!-- <link rel='stylesheet' href='/stylesheets/hr.css' /> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>

	<script src="js/main.js"></script>
</head>

<body style="background-color :#F8F8F8">

	<input type="text" id="user_id" value="<?php echo $USER_ID; ?>" hidden>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8" style="text-align:center;margin:auto"><img src="trablr_logo.jpg" alt="TRABLR LOGO" style="width:100%;max-width:350px;"></div>
		<div class="col-sm-2"></div>
	</div>
	
	<div class="row"> <!-- FIRST ROW -->
		
		<div class="col-sm-2"></div>
		
		<div class="col-sm-4" > 
				<div class="panel panel-success">
					<div class="panel-heading" style="font-size:150%;">
						<strong>SEARCH ROUTES</strong>
					</div>
					<div class="panel-body" style="height:auto;"> <!--INNER PANEL BODY-->
				
						<div class="form-group">
							<div class="col-sm-12">
							
							<form class="form-horizontal" role="form">
								<select name="select_route" id="select_route" style="width:100%;height:33px;">
								<option value="-1">Select Route</option>
					<?php 	$sql = "SELECT DISTINCT LINE_ID,ROUTE_NAME,DIRECTION FROM TRANSIT_INFO
									ORDER BY LINE_ID ASC, DIRECTION ASC;";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_array($result)) { ?>
								<option value="<?php echo $row['LINE_ID']."_".$row['DIRECTION']; ?>"><?php echo $row['LINE_ID']." - ".$row['ROUTE_NAME']." (".$row['DIRECTION'].")"; ?></option>
					<?php 	} ?>
								</select>
							</form>

							<div class="select_stop_id_start">
							<form class="form-horizontal" role="form">
								<select name="select_stop_id_start" id="select_stop_id_start" style="width:100%;height:33px;" disabled>
								<option value="-1">Select Start</option>
								<option value="2">Start ID = ?</option>
								</select>
							</form>
							</div>

							<div class="select_stop_id_end">
							<form class="form-horizontal" role="form">
								<select name="select_stop_id_end" id="select_stop_id_end" style="width:100%;height:33px;" disabled>
								<option value="-1">Select End</option>
								<option value="2">End ID = ?</option>
								</select>
							</form>
							</div>

							<div class="select_live_eta"></div>

								<!-- <button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto;" ng-click="signinsubmit();"><strong>Route</strong></button> -->
						
								<!-- <div class="btn-group"> -->
								  <!-- <button type="button" class="btn btn-success">Route Now!</button> -->
								  <!-- <button type="button" class="btn btn-primary">Add as Route1</button>
								  <button type="button" class="btn btn-primary">Add as Route2</button>
								  <button type="button" class="btn btn-primary">Add as Route3</button>
								  <button type="button" class="btn btn-primary">Add as Route4</button> -->
								<!-- </div> -->
							</div>
						</div>

					</div> <!--INNER PANEL BODY-->	

				</div><!--panel panel-default-->
		</div> 
		
		<div class="col-sm-4" > 
			<div class="panel panel-warning">
				<div class="panel-heading" style="font-size:150%;">
					<strong>FAVORITE ROUTES</strong>
				</div>
				<div class="panel-body" style="height:180px"> <!--INNER PANEL BODY-->
					<div class="col-sm-12">

			<?php 	$sql = "SELECT UF.*,TI.*
							FROM USER_FAVORITES AS UF
							LEFT JOIN TRANSIT_INFO AS TI
							ON UF.STOP_ID_START=TI.STOP_ID
							WHERE UF.USER_ID=$USER_ID ORDER BY UF.PRIORITY ASC;";
					$result = mysqli_query($con,$sql);
					$j = 0;
					while($row = mysqli_fetch_array($result)) {
						$j++; ?>

						<input type="text" id="favorites_id_<?php echo $j; ?>" value="<?php echo $row['FAVORITES_ID']; ?>" hidden>
						<input type="text" id="line_id_<?php echo $j; ?>" value="<?php echo $row['LINE_ID']; ?>" hidden>
						<input type="text" id="stop_id_start_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_START']; ?>" hidden>
						<input type="text" id="stop_id_end_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_END']; ?>" hidden>
						<button class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="get_stop_monitoring_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_START']; ?>"><strong><?php echo $row['STOP_ID_START']." -> ".$row['STOP_ID_END']; ?></strong></button>
						<button class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="exit_<?php echo $j; ?>">EXIT</button>

			<?php 	}
					for ($i = $j; $i < 4; $i++) { ?>
				 		<button class="btn btn-warning" style="display: block; width: 100%;font-size:auto" value="-1"><strong>EMPTY</strong></button>
			<?php 	} ?>

					</div>
				</div> <!--INNER PANEL BODY-->

			</div><!--panel panel-default-->
		</div>
		
		<div class="col-sm-2"> </div>
	</div> <!--FIRST ROW -->
	
	<div class="row"> <!-- SECOND ROW -->
		<div class="col-sm-2"> </div> 
	
		<div class="col-sm-8" >
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:150%;">
					<strong>LIVE ETA</strong>
				</div>
				<div class="panel-body"> <!--INNER PANEL BODY-->
					<table border="0"><tr><td>
						<text class="col-sm-12" style="font-size:150%;" id="arrival_time_1">&nbsp;</text>
					</td></tr><tr><td>
						<text class="col-sm-12" style="font-size:150%;" id="arrival_time_2">&nbsp;</text>
					</td></tr><tr><td>
						<text class="col-sm-12" style="font-size:150%;" id="arrival_time_3">&nbsp;</text>
					</td></tr><tr><td>
						<text class="col-sm-12" style="font-size:150%;" id="arrival_time_4">&nbsp;</text>
					</td></tr></table>
					<!--<div class="col-sm-12" style="font-size:150%;">Source: Alameda</div>
					<div class="col-sm-12" style="font-size:150%;">Destination: San Jose</div>
					<div class="col-sm-12" style="font-size:150%;">Next Bus @: 3:21pm</div>
					<div class="col-sm-12" style="font-size:150%;">ETA: 3minutes</div>
					<div class="col-sm-12" style="font-size:150%;">Next Bus @: 3:21pm</div>
					<div class="col-sm-12" style="font-size:150%;">Next Bus @: 3:21pm</div-->
				</div> <!--INNER PANEL BODY-->	

			</div><!--panel panel-default-->
		</div> 
	
		<div class="col-sm-2"> </div> 
	</div> <!--SECOND ROW -->

	<div class="row"> <!--THIRD ROW -->
		<div class="col-sm-2"> </div>
			<div class="col-sm-8">
				<div class="panel-body" align="center">
					<form class="form-horizontal" role="form" id="logout" method="get" action="/logout.php">
						<input type="text" name="logout" value="1" hidden>
					</form>
					<button type="submit" class="btn btn-success" form="logout">LOGOUT</button>
				</div>
			</div>
		<div class="col-sm-2"> </div>
	</div> <!--THIRD ROW -->

</body>
</html>
<?php ob_end_flush(); ?>
