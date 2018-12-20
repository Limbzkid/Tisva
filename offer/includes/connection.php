<?php
// mysql db connection

$con = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);

if (!$con){
die('Could not connect: ' . mysqli_error());
}

// Select database name
mysqli_select_db($con, DB_NAME);

?>