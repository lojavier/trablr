#!/usr/bin/php5-cgi
<!-- http://www.codingcage.com/2015/01/user-registration-and-login-script-using-php-mysql.html -->
<?php
session_start();
if (!isset($_SESSION['USER_ID'])) {
	header("Location: index.php");
} else if (isset($_SESSION['USER_ID']) != "") {
	header("Location: home.php");
}

if (isset($_GET['logout'])) {
	unset($_SESSION['USER_ID']);
	session_unset();
	session_destroy();
	header("Location: index.php");
	exit;
}
?>