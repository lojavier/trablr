<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
require_once("config.php");

$line_id = intval($_GET['line_id']);
$direction = strval($_GET['direction']);

$sql = "SELECT TRANSIT_ID,STOP_ID,LINE_ID,STOP_NAME FROM TRANSIT_INFO
	WHERE LINE_ID=".$line_id." AND DIRECTION='".$direction."'
	ORDER BY STOP_ID ASC;";
$result = mysqli_query($con,$sql);

echo "<select name='category' id='category' style='width:100%;height:33px;'>
		<option value='-1'>Select Start</option>";

while($row = mysqli_fetch_array($result)) {
	echo "<option value='".$row['STOP_ID']."'>".$row['LINE_ID']." - ".$row['STOP_NAME']." (".$row['STOP_ID'].")</option>";
}
mysqli_close($con);
?>

</body>
</html>
