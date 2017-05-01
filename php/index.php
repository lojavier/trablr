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

$QUERY_ROUTE = false;
$QUERY_START_ID = false;
$QUERY_END_ID = false;
$START_ROUTE = false;
$line_id = false;
$direction = false;
$start_id = false;
$end_id = false;
if(isset($_GET['route']) && $_GET['route']!=-1) {
	$route = explode("_",$_GET['route']);
	for ($i = 0; $i < sizeof($route); $i++) {
		switch($i) {
			case 0:
				$QUERY_ROUTE = true;
				$line_id = $route[$i];
				break;
			case 1:
				$QUERY_ROUTE = true;
				$direction = $route[$i];
				break;
			case 2:
				$QUERY_START_ID = true;
				$start_id = $route[$i];
				break;
			case 3:
				$QUERY_END_ID = true;
				$end_id = $route[$i];
				break;
			case 4:
				$START_ROUTE = true;
				break;
			default:
				break;
		}
	}
}

$USER_ID=1;
?>

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
					<div class="panel-body" style="height:200px"> <!--INNER PANEL BODY-->

					<form class="form-horizontal" role="form">
				
						<div class="form-group">
							<div class="col-sm-12">
							<form id="route" method="get" action="http://127.0.0.1:8080/index.php">
							<select name="route" style="width:100%;height:33px;" onchange="this.form.submit()">
							<option value="-1">Select Route</option>
					<?php 	$sql = "SELECT DISTINCT LINE_ID,ROUTE_NAME,DIRECTION FROM TRANSIT_INFO
								ORDER BY LINE_ID ASC, DIRECTION ASC;";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_array($result)) {
						 		if( ($QUERY_ROUTE || $QUERY_START_ID || $QUERY_END_ID) && $row['LINE_ID']==$line_id && $row['DIRECTION']==$direction) { ?>
									<option value="<?php echo $row['LINE_ID']."_".$row['DIRECTION']; ?>" selected><?php echo $row['LINE_ID']." - ".$row['ROUTE_NAME']." (".$row['DIRECTION'].")"; ?></option>
					<?php  		} else { ?>
									<option value="<?php echo $row['LINE_ID']."_".$row['DIRECTION']; ?>"><?php echo $row['LINE_ID']." - ".$row['ROUTE_NAME']." (".$row['DIRECTION'].")"; ?></option>
					<?php  		}
						  	} ?>
							</select>
							</form>
							</div>
						</div>

					</form>
					<form class="form-horizontal" role="form">

						<div class="form-group">
							<div class="col-sm-12">
							<form id="route" method="get" action="http://127.0.0.1:8080/index.php">
					<?php 	$sql = "SELECT DISTINCT STOP_ID,STOP_NAME FROM TRANSIT_INFO
									WHERE LINE_ID=".$line_id." AND DIRECTION='".$direction."'
									ORDER BY STOP_NAME ASC;";
							if ($QUERY_START_ID || $QUERY_END_ID) { ?>
								<select name="route" style="width:100%;height:33px;" onchange="this.form.submit()">
								<option value="-1">Select Start</option>
					<?php		$result = mysqli_query($con,$sql);
								while($row = mysqli_fetch_array($result)) { 
									if ($row['STOP_ID']==$start_id) { ?>
									<option value="<?php echo $line_id."_".$direction."_".$row['STOP_ID']; ?>" selected><?php echo "(".$row['STOP_ID'].") ".$row['STOP_NAME']; ?></option>
					<?php 			} else { ?>
										<option value="<?php echo $line_id."_".$direction."_".$row['STOP_ID']; ?>"><?php echo "(".$row['STOP_ID'].") ".$row['STOP_NAME']; ?></option>
					<?php 			}
								}
							} elseif($QUERY_ROUTE) { ?>
								<select name="route" style="width:100%;height:33px;" onchange="this.form.submit()">
								<option value="-1">Select Start</option>
					<?php		$result = mysqli_query($con,$sql);
								while($row = mysqli_fetch_array($result)) { ?>
									<option value="<?php echo $line_id."_".$direction."_".$row['STOP_ID']; ?>"><?php echo "(".$row['STOP_ID'].") ".$row['STOP_NAME']; ?></option>
					<?php 		}
							} else { ?>
								<select name="route" style="width:100%;height:33px;" disabled>
									<option value="-1">Select Start</option>
					<?php 	} ?>
							</select>
							</form>
							</div>
						</div>

					</form>
					<form class="form-horizontal" role="form">
						
						<div class="form-group">
							<div class="col-sm-12">
							<form id="route" method="get" action="http://127.0.0.1:8080/index.php">
					<?php	$sql = "SELECT DISTINCT STOP_ID,STOP_NAME FROM TRANSIT_INFO
									WHERE LINE_ID=".$line_id." AND DIRECTION='".$direction."' AND STOP_ID<>".$start_id."
									ORDER BY STOP_NAME ASC;";
							if ($QUERY_END_ID || $START_ROUTE) { ?>
								<select name="route" style="width:100%;height:33px;" onchange="this.form.submit()">
								<option value="-1">Select Start</option>
					<?php		$result = mysqli_query($con,$sql);
								while($row = mysqli_fetch_array($result)) { 
									if ($row['STOP_ID']==$end_id) { ?>
									<option value="<?php echo $line_id."_".$direction."_".$start_id."_".$row['STOP_ID']."_START"; ?>" selected><?php echo "(".$row['STOP_ID'].") ".$row['STOP_NAME']; ?></option>
					<?php 			} else { ?>
										<option value="<?php echo $line_id."_".$direction."_".$start_id."_".$row['STOP_ID']."_START"; ?>"><?php echo "(".$row['STOP_ID'].") ".$row['STOP_NAME']; ?></option>
					<?php 			}
								}
							} elseif($QUERY_START_ID) { ?>
								<select name="route" style="width:100%;height:33px;" onchange="this.form.submit()">
								<option value="-1">Select Start</option>
					<?php		$result = mysqli_query($con,$sql);
								while($row = mysqli_fetch_array($result)) { ?>
									<option value="<?php echo $line_id."_".$direction."_".$start_id."_".$row['STOP_ID']."_START"; ?>"><?php echo "(".$row['STOP_ID'].") ".$row['STOP_NAME']; ?></option>
					<?php 		}
							} else { ?>
								<select name="route" style="width:100%;height:33px;" disabled>
									<option value="-1">Select Start</option>
					<?php 	} ?>
							</select>
							</form							</div>
						</div>

					</form>

					<!-- <form class="form-horizontal" role="form"> -->
						
						<div class="col-sm-4">
							<div class="col-sm-12">
					<?php 	if($START_ROUTE) { ?>
								<br>
								<input type="text" id="line_id_0" value="<?php echo $line_id; ?>" hidden>
								<input type="text" id="stop_id_start_0" value="<?php echo $start_id; ?>" hidden>
								<input type="text" id="stop_id_end_0" value="<?php echo $end_id; ?>" hidden>
								<button class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="get_stop_monitoring_0" value="<?php echo $start_id; ?>"><strong><?php echo $start_id." -> ".$end_id; ?></strong></button>
								<button class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="exit_0">EXIT</button>

								<!-- <script>
									$(function() {
										$('#get_stop_monitoring_0').click();
										$('#get_stop_monitoring_0').one('click', function() {});
									});
								</script> -->
					<?php	} ?>
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
					
					<!-- </form> -->

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

							<input type="text" id="line_id_<?php echo $j; ?>" value="<?php echo $row['LINE_ID']; ?>" hidden>
							<input type="text" id="stop_id_start_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_START']; ?>" hidden>
							<input type="text" id="stop_id_end_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_END']; ?>" hidden>
							<button class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="get_stop_monitoring_<?php echo $j; ?>" value="<?php echo $row['STOP_ID_START']; ?>"><strong><?php echo $row['STOP_ID_START']." -> ".$row['STOP_ID_END']; ?></strong></button>
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
	
	<div class="row"> <!-- SECOND ROW -->
		<div class="col-sm-2"> </div> 
	
		<div class="col-sm-8" >
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:150%;">
					<strong>LIVE ETA</strong>
				</div>
				<div class="panel-body"> <!--INNER PANEL BODY-->
					
					<text class="col-sm-12" style="font-size:150%;" id="arrival_time_1">&nbsp;</text>
					<text class="col-sm-12" style="font-size:150%;" id="arrival_time_2">&nbsp;</text>
					<text class="col-sm-12" style="font-size:150%;" id="arrival_time_3">&nbsp;</text>
					<div class="col-sm-12" style="font-size:150%;"><span id="json_result">&nbsp;</span></div>

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

	<!-- <?php 	if($START_ROUTE) { ?>
								<input type="text" id="line_id_0" value="<?php echo $line_id; ?>" hidden>
								<input type="text" id="stop_id_start_0" value="<?php echo $start_id; ?>" hidden>
								<input type="text" id="stop_id_end_0" value="<?php echo $end_id; ?>" hidden>
								<button  class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="get_stop_monitoring_0" value="<?php echo $start_id; ?>"><strong><?php echo $start_id." -> ".$end_id; ?></strong></button>
								<button class="btn btn-warning" style="display: block; width: 100%;font-size:auto" id="exit_0">EXIT</button>
								<script>test(0);</script>
					<?php	} ?> -->

</body>
</html>
