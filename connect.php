<?php
$mysqli = new mysqli("localhost", "root", "", "maps", "3306");

if ($mysqli -> connect_errno) {
	echo "<script>alert('Failed to connect to MySQL: " . $mysqli -> connect_error . "')</script>";
}

function escaped($arg) {
	return $GLOBALS['mysqli'] -> real_escape_string($arg);
}
?>