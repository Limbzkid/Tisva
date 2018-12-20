<?php
//First of all, must be include the file class
require("FilterClass.php");

//Creating instance
$filtering =new FilterClass();

//Cleaning XSS mess
$filtered =$filtering::filterXSS($_POST);

// Hurray, Now you are secure
echo "<pre>";
print_r($filtered);
echo "</pre>";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <title> new document </title>
  <meta name="generator" content="editplus">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">
 </head>
 <script type="text/javascript">
 	function test(a,b,c)
 	{
 		var a=10;
 		var b=10;
 		c=a+b;
 	}
 </script>
 <body>
	<form method="POST">
		<input type="text" name="testing" id="testing"  />
		<input type="submit" name="cmdSubmit">
	</form>
 </body>
</html>
