<!DOCTYPE html>
<html>
<head>
	<title>TRABLR HOME</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' href='/stylesheets/hr.css' />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>	
</head>

<body style="background-color :#F8F8F8">

<?php require_once("config.php"); ?>

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
						<strong>Transit </strong> 
						
					</div>
					<div class="panel-body" style="height:180px"> <!--INNER PANEL BODY-->

					<form class="form-horizontal" role="form">
				
						<div class="form-group">
							<div class="col-sm-12">
							<select name="category" id="category" style="width:100%;height:33px;" ng-model="category_model" ng-init="category_model_fun()">
							<option value="-1">Select Start</option>

					<?php 	$sql = "SELECT * FROM TRANSIT_INFO;";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_array($result)) {
								$stop_id=$row['STOP_ID'];
								$line_id=$row['LINE_ID'];
								$stop_name=$row['STOP_NAME']; ?>
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
							while($row = mysqli_fetch_array($result)) {
								$stop_id=$row['STOP_ID'];
								$line_id=$row['LINE_ID'];
								$stop_name=$row['STOP_NAME']; ?>
								<option value="<?php echo $row['STOP_ID']; ?>"><?php echo $row['LINE_ID']." - ".$row['STOP_NAME']." (".$row['STOP_ID'].")"; ?></option>
					<?php  	} ?>

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
						<strong>Favorites </strong> 
						
					</div>
					<div class="panel-body" style="height:180px"> <!--INNER PANEL BODY-->
						<div class="col-sm-12">
							<br>
							<button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto" ng-click="gotocheckout();"><strong>Route 1 (default)</strong></button>
							<button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto" ng-click="gotocheckout();"><strong>Route 2</strong></button>
							<button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto" ng-click="gotocheckout();"><strong>Route 3</strong></button>
							<button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto" ng-click="gotocheckout();"><strong>Route 4</strong></button>
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
						<strong>Information </strong> 
						
					</div>
					<div class="panel-body"> <!--INNER PANEL BODY-->
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
