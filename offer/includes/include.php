<?php

session_start();

define('DEVELOPMENT_ENVIRONMENT', true);

// Defining ROOT
define('ROOT', dirname(dirname(__FILE__)));

//Defiining directory separator as it varires on some servers
define('DS', DIRECTORY_SEPARATOR);

// This file have Routine functions which makes us sure that our application is not going to expose even though server configured wrongly
include_once ROOT . DS . "includes" . DS . "routines.php";

// Setting error reporting parameteres, depending upon DEVELOPMENT_ENVIRONMENT constant's value
setReporting();

removeMagicQuotes();
unregisterGlobals();

include_once ROOT . DS . "includes" . DS . "config.php";

// Including configuration file
$hostname = getenv('HTTP_HOST');
if ($hostname == "localhost") {
	//include_once("config.php");
} else {
	//require_once("config_server.php");
}

// Including database tabels file, which contains constant names of database tables
include_once ROOT . DS . "includes" . DS . "db_tables.php";

// Including database filenames file, which contains constant names of files
include_once ROOT . DS . "includes" . DS . "filenames.php";

// Including database filenames file, which contains constant names of files
include_once ROOT . DS . "includes" . DS . "filter" . DS . "FilterClass.php";

// Including database filenames file, which contains constant names of files
//include_once(ROOT.DS."includes".DS."filter".DS."RestrictCSRF.php");

// Including connection file, which is use for database connection using PDO
include_once ROOT . DS . "includes" . DS . "classPDOConnection.php";

// Instatiating PDO
$objPDO = new PDOConnectionClass();
$activePDOConnection = $objPDO->setConnection();

// Including PHP Mailer class
include_once 'class.phpmailer.php';

// Including function file which contains all user define functions, specific to application
include_once ROOT . DS . "includes" . DS . "functions.php";

//exit;
?>