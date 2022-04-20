<?php
session_start();
if (isset($_GET["disconnect"])) {
	session_destroy();
	session_unset();
	header("location: login.php");
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 800)) {
	session_destroy();
	session_unset();
	header("location: login.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time
if (isset($_SESSION["id_user"])) {
	if ($_SESSION["connection_status"] != "connected")
		header("location: login.php");
} else {
	header("location: login.php");
}
