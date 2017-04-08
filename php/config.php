<?php
	define('DB_SERVER', '127.0.0.1');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'password');
	define('DB_DATABASE', 'TRABLR_DB');
	define('DB_PORT', '3306');
	$con = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE,DB_PORT);

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error() . "\n";
	}
?>
