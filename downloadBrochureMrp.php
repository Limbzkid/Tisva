<?php
header("Content-type: application/pdf"); // add here more headers for diff. extensions
header("Content-Disposition: attachment; filename=\"".$_GET['file']."\""); 
if(isset($_GET['file']))
{
	//readfile('D:\wamp\www\kripa\tisva\site\sites\default\files\homepage\\'.$_GET['file']);	
	//readfile('http://'.$_SERVER['HTTP_HOST'].'/kripa/tisva/site/sites/default/files/homepage/'.$_GET['file']);
	//file:///D:/wamp/www/kripa/tisva/site/sites/default/files/homepage/Geo%20StratDear%20Example%20Lttr.pdf
		$path = pathinfo($_SERVER['SCRIPT_FILENAME']);
		readfile($path['dirname'].'/sites/default/files/homepage/'.$_GET['file']);
		//print ($path['dirname'].'/sites/default/files/homepage/'.$_GET['file']);
}	
?>