<?php
session_start();
if (!empty($_REQUEST['captcha'])) 
{
	
    if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) 
	{
        print $errorsCaptcha=0;
    } 
	else 
	{
        print $errorsCaptcha=1;
    }
	
    unset($_SESSION['captcha']);
	return $errorsCaptcha;
}

?>