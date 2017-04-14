#!/usr/bin/php5-cgi
<!DOCTYPE html>
<html>
<head>
	<title>TRABLR HOME</title>
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

<?php 
require_once("config.php");

$USER_ID=1;
?>

	<br>
	<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8"><h1>&nbsp;&nbsp;TRABLR - Getting from Point A to B</h1><br></div>
	<div class="col-sm-2"></div>
	</div>
	
	<div class="row"> <!-- FIRST ROW -->
		
		<div class="col-sm-2"></div>	
		
		<div class="col-sm-4" > 
				<div class="panel panel-success">
					<div class="panel-heading" style="font-size:150%;">
						<strong>Transit</strong> 
					</div>
					<div class="panel-body" style="height:180px"> <!--INNER PANEL BODY-->

					<form class="form-horizontal" role="form">
				
						<div class="form-group">
							<div class="col-sm-12">
							<select name="category" id="category" style="width:100%;height:33px;" ng-model="category_model" ng-init="category_model_fun()">
							<option value="-1">Select Start</option>

							<!-- $sql = "SELECT UF.*,TI.*
								FROM USER_FAVORITES AS UF
								LEFT JOIN TRANSIT_INFO AS TI
								ON UF.STOP_ID_START=TI.STOP_ID
								WHERE UF.USER_ID=$USER_ID ORDER BY UF.PRIORITY ASC;"; -->
					<?php 	
							// $sql = "SELECT DISTINCT A.LINE_ID,A.ROUTE_NAME,A.DIRECTION FROM TRANSIT_INFO AS A
							// 	JOIN (SELECT * FROM TRANSIT_INFO GROUP BY TRANSIT_ID) AS B
							// 	ON 	B.LINE_ID=A.LINE_ID
							// 	AND B.ROUTE_NAME=A.ROUTE_NAME
							// 	AND B.DIRECTION=A.DIRECTION
							// 	ORDER BY A.LINE_ID ASC, A.DIRECTION ASC;";

							$sql = "SELECT A.TRANSIT_ID,A.LINE_ID,A.ROUTE_NAME,A.DIRECTION FROM TRANSIT_INFO AS A
								JOIN (SELECT DISTINCT LINE_ID,ROUTE_NAME,DIRECTION FROM TRANSIT_INFO GROUP BY LINE_ID) AS B
								ON 	B.LINE_ID=A.LINE_ID
								AND B.ROUTE_NAME=A.ROUTE_NAME
								AND B.DIRECTION=A.DIRECTION
								ORDER BY A.LINE_ID ASC, A.DIRECTION ASC;";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_array($result)) { ?>
								<option value="<?php echo $row['TRANSIT_ID']; ?>"><?php echo $row['LINE_ID']." - ".$row['ROUTE_NAME']." (".$row['DIRECTION'].")"; ?></option>
					<?php  	} ?>

							</select>
							</div>

							<div class="col-sm-12">
							<select name="category" id="category" style="width:100%;height:33px;" ng-model="category_model" ng-init="category_model_fun()">
							<option value="-1">Select Start</option>

					<?php 	$sql = "SELECT * FROM TRANSIT_INFO;";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_array($result)) { ?>
								<option value="<?php echo $row['STOP_ID']; ?>"><?php echo $row['LINE_ID']." - ".$row['STOP_NAME']." (".$row['STOP_ID'].")"; ?></option>
					<?php  	} ?>

							</select>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-12">
							<select name="category" id="category" style="width:100%;height:33px;" ng-model="category_model" ng-init="category_model_fun()">
							<option value="-1">Select Destination</option>

					<?php 	$sql = "SELECT * FROM TRANSIT_INFO;";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_array($result)) { ?>
								<option value="<?php echo $row['STOP_ID']; ?>"><?php echo $row['LINE_ID']." - ".$row['STOP_NAME']." (".$row['STOP_ID'].")"; ?></option>
					<?php 	} ?>

							</select>
							</div>
						</div>
						
						<div class="form-group ">
							<div class="col-sm-12">
								<!--button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto;" ng-click="signinsubmit();"><strong>Route</strong></button-->
								
								<div class="btn-group">
								  <button type="button" class="btn btn-success">Route Now!</button>
								  <button type="button" class="btn btn-primary">Add as Route1</button>
								  <button type="button" class="btn btn-primary">Add as Route2</button>
								  <button type="button" class="btn btn-primary">Add as Route3</button>
								  <button type="button" class="btn btn-primary">Add as Route4</button>
								</div>
							</div>
						</div>
					
					</form>

					</div> <!--INNER PANEL BODY-->	

				</div><!--panel panel-default-->
		</div> 
		

		<div class="col-sm-4" > 
				<div class="panel panel-warning">
					<div class="panel-heading" style="font-size:150%;">
						<strong>Favorites</strong> 
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

							<input type="text" id="line_id_<?php echo $j; ?>" value="<?php echo $row['LINE_ID']; ?>" hidden>
							<input type="text" id="stop_id_start_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_START']; ?>" hidden>
							<input type="text" id="stop_id_end_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_END']; ?>" hidden>
							<button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="get_stop_monitoring_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_START']; ?>"><strong><?php echo $row['STOP_ID_START']." -> ".$row['STOP_ID_END']; ?></strong></button>
							<button class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="exit_<?php echo $j; ?>">EXIT</button>

				<?php 	}
						for ($i = $j; $i < 4; $i++) { ?>
					 		<button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto" value="-1"><strong>EMPTY</strong></button>
				<?php 	} ?>

						</div>
					</div> <!--INNER PANEL BODY-->

				</div><!--panel panel-default-->
		</div>
		
		<div class="col-sm-2"> </div> 
	</div> <!--FIRST ROW -->
	
	
	<br>
	<div class="row"> <!-- SECOND ROW -->
		<div class="col-sm-2"> </div> 
	
		<div class="col-sm-8" > 
				<div class="panel panel-primary">
					<div class="panel-heading" style="font-size:150%;">
						<strong>Information</strong> 
					</div>
					<div class="panel-body"> <!--INNER PANEL BODY-->
						
						<text class="col-sm-12" style="font-size:150%;" id="arrival_time_1">&nbsp;</text>
						<text class="col-sm-12" style="font-size:150%;" id="arrival_time_2">&nbsp;</text>
						<text class="col-sm-12" style="font-size:150%;" id="arrival_time_3">&nbsp;</text>
						<div class="col-sm-12" style="font-size:150%;"><span id="json_result">&nbsp;</span></div>

						<div class="col-sm-12" style="font-size:150%;">Source: Alameda</div>
						<div class="col-sm-12" style="font-size:150%;">Destination: San Jose</div>
						<div class="col-sm-12" style="font-size:150%;">Next Bus @: 3:21pm</div>
						<div class="col-sm-12" style="font-size:150%;">ETA: 3minutes</div>
						<!--div class="col-sm-12" style="font-size:150%;">Next Bus @: 3:21pm</div>
						<div class="col-sm-12" style="font-size:150%;">Next Bus @: 3:21pm</div-->
					</div> <!--INNER PANEL BODY-->	

				</div><!--panel panel-default-->
		</div> 
	
		<div class="col-sm-2"> </div> 
	</div> <!--SECOND ROW -->

</body>
</html>
