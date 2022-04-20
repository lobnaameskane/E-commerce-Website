<?php
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 800)) {
	session_destroy();
	session_unset();
	header("location: index.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time
if (!isset($_SESSION["connection_status"])) {
	header("location: index.php");
}
