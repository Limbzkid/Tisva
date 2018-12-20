<?php
/**
 * Application wide constants
 *Date: 30/11/2014
 *Author: Ganesh Sawant
 */

//microsite name
define("HTTP_MICROSITE", ""); // Fill this space in case your site is in subdirectory

//microsite document name
define("DOCUMENT_MICROSITE", ""); // Fill this space in case your files are in subdirectory

// Servername
define("HTTP_SERVER_MICROSITE", "http://" . $_SERVER['HTTP_HOST'] . "/" . HTTP_MICROSITE);

// admin sub domain
define("HTTP_SERVER", HTTP_SERVER_MICROSITE);

// Base url for javascripts and other declarations
define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/" . HTTP_MICROSITE);

//microsite name
define("HTTP_MICROSITE_ADMIN", "usha_heater/admin");

// Servername
define("HTTP_SERVER_MICROSITE_ADMIN", "http://" . $_SERVER['HTTP_HOST'] . "/" . HTTP_MICROSITE_ADMIN);

// admin sub domain
define("HTTP_SERVER_ADMIN", HTTP_SERVER_MICROSITE_ADMIN);

// admin images
define("HTTP_SERVER_IMAGES", HTTP_SERVER . "/images");

// admin images
define("HTTP_SERVER_PDF", HTTP_SERVER . "/pdf");

// admin css
define("HTTP_SERVER_CSS", HTTP_SERVER . "/css");

// admin js
define("HTTP_SERVER_JS", HTTP_SERVER . "/js");

// admin uploads
define("HTTP_SERVER_UPLOADS", HTTP_SERVER . DS . "uploads");

// Physical path
define('DOCUMENT_SERVER', $_SERVER['DOCUMENT_ROOT'] . DS . DOCUMENT_MICROSITE);

// Physical path to images
define('DOCUMENT_IMAGES', DOCUMENT_SERVER . DS . "images");

// Physical path to images
define('DOCUMENT_PDF', DOCUMENT_SERVER . DS . "pdf");

// Physical path to uploads
define('DOCUMENT_UPLOADS', DOCUMENT_SERVER . DS . "uploads");

define('DOCUMENT_UPLOADS1', DOCUMENT_SERVER . DS . "uploads1");

// Physical path to uploads
define('DOCUMENT_INCLUDES', DOCUMENT_SERVER . DS . "includes");

// Physical path to uploads
define('DOCUMENT_MODULES', DOCUMENT_INCLUDES . DS . "modules");

// Define current page
define('CURRENT_PAGE', basename($_SERVER['PHP_SELF']));

//database host
define("DB_HOST", "localhost");

//database username
define("DB_USERNAME", "root");

//database password
define("DB_PASSWORD", "Ushaadmin");

//database name
define("DB_NAME", "tisva");

//from company emaill
define('COMPANY_FROM_EMAIL', "Ushacare_online@ushainternational.com");

//from company name
define('COMPANY_FROM_NAME', "Usha International Limited");

//Overriding php.ini timezone setting
date_default_timezone_set("Asia/Kolkata");

// log php errors
/*@ini_set('log_errors','On'); // enable or disable php error logging (use 'On' or 'Off')
@ini_set('display_errors','On'); // enable or disable public display of errors (use 'On' or 'Off')
@ini_set('error_log',DOCUMENT_SERVER.'/errata.log'); // path to server-writable log file*/

?>