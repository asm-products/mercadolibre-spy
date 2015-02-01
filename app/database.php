<?php

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}