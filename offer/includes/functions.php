<?php

/**
 *Common file for functions which use throughout application
 *Date: 30/11/2014
 *Author: Ganesh Sawant
 */

/**
 * [checkIfIdFromCustomerExists This function checks existance of unique_id ]
 * @param  [string] $unique_code [a unique_id which is entered by user ]
 * @return [integer]$existanseOfUniqueID [ 0 if not found and 1 if found match ]
 */
function checkIfIdFromCustomerExists($unique_code) {

	global $activePDOConnection; // Taking PDO connection inside function
	$existanseOfUniqueID = 0;

	$activePDOConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);

	$sql = 'SELECT * FROM ' . TBL_UNIQUE_CODES_MASTER . ' WHERE unique_code =:unique_code';
	$stmt = $activePDOConnection->prepare($sql);
	$stmt->execute(array(":unique_code" => $unique_code));
	$existanseOfUniqueID = $stmt->rowCount();
	$stmt->closeCursor();
	return $existanseOfUniqueID;
}

/**
 * [checkIfIdFromCustomerExistsForAllocation Checks if existing id is available for allocation]
 * @param  [string] $unique_code      [a unique_id which is entered by user]
 * @param  [integer] $allocationStatus [allocation status which is 0]
 * @return [integer] $existanseOfUniqueIDForAllocation [0 if not found and 1 if found match]
 */
function checkIfIdFromCustomerExistsForAllocation($unique_code, $allocationStatus) {

	global $activePDOConnection; // Taking PDO connection inside function
	$existanseOfUniqueIDForAllocation = 0;

	$activePDOConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);

	$sql = 'SELECT * FROM ' . TBL_UNIQUE_CODES_MASTER . ' WHERE unique_code =:unique_code AND allocation =:allocationStatus';
	$stmt = $activePDOConnection->prepare($sql);
	$stmt->execute(array(":unique_code" => $unique_code, ":allocationStatus" => $allocationStatus));
	$existanseOfUniqueIDForAllocation = $stmt->rowCount();
	$stmt->closeCursor();
	return $existanseOfUniqueIDForAllocation;
}

function checkIfCustomerEmailIdExists($customer_email) {

	global $activePDOConnection; // Taking PDO connection inside function
	$existanseOfUniqueIDForAllocation = 0;

	$activePDOConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);

	$sql = 'SELECT * FROM ' . TBL_CUSTOMER_LEADS . ' WHERE customer_email =:customer_email';
	$stmt = $activePDOConnection->prepare($sql);
	$stmt->execute(array(":customer_email" => $customer_email));
	$existanseOfUniqueIDForAllocation = $stmt->rowCount();
	$stmt->closeCursor();
	return $existanseOfUniqueIDForAllocation;
}

/**
 * [removeEverythingFromSession description]
 * @param  [SESSION Array] $session [passing SESSION Array into this function and unsetting everything after succesful data operation]
 * @return [none]          [description]
 */
function removeEverythingFromSession($session) {
	foreach ($session as $key => $value) {
		unset($_SESSION[$key]);
	}
}

/**
 * [generateSecurityString Generating encrypred key for current session]
 * @return [SESSION Array variable] [Setting session array with encrypted string, which will help us preventing attacks from bots and proxy servers ]
 */
function generateSecurityString() {
	$randomString = random_string(50);
	$currTimestamp = time();
	$timestamp = md5($currTimestamp . $randomString);
	/*if ($_SESSION['times'] == "" || !isset($_SESSION["times"])) {
	$_SESSION['times'] = $timestamp;
	}*/
	if (!isset($_SESSION["times"])) {
		$_SESSION['times'] = $timestamp;
	} else if ($_SESSION['times'] == "") {
		$_SESSION['times'] = $timestamp;
	}
	return $_SESSION['times'];
}

/**
 * [random_string Random key of alphabates and numericals as per length specifies]
 * @return [string] [Random alphanumeric key]
 */
function random_string($length) {
	$key = '';
	$keys = array_merge(range(0, 9), range('a', 'z'));

	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
	}

	return $key;
}

/**
 * [getAllRegions Get all regions of water heater sellers]
 * @return [array] [An array of all regions' ids and names]
 */
function getAllRegions() {
	global $activePDOConnection; // Taking PDO connection inside function
	$result = "";

	$activePDOConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);

	$sql = 'SELECT * FROM ' . TBL_DEALERS_REGIONS . ' WHERE status ="1"';
	$stmt = $activePDOConnection->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
	//$existanseOfUniqueIDForAllocation = $stmt->rowCount();
	$stmt->closeCursor();
	//return $existanseOfUniqueIDForAllocation;
	return $result;
}

/**
 * [getCitiesByRegionId description]
 * @param  [type] $region_id [description]
 * @return [type]            [description]
 */
function getCitiesByRegionId($region_id) {
	global $activePDOConnection; // Taking PDO connection inside function
	$result = "";

	$activePDOConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);

	$sql = 'SELECT DISTINCT(city) FROM ' . TBL_WATER_HEATER_DEALERS . ' WHERE region_id=:region_id';
	$stmt = $activePDOConnection->prepare($sql);
	$stmt->execute(array(":region_id" => $region_id));
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$existanseOfUniqueIDForAllocation = $stmt->rowCount();
	$stmt->closeCursor();
	//return $existanseOfUniqueIDForAllocation;
	return $result;
}

function getDealersByCityAndRegion($region_id, $city) {
	global $activePDOConnection; // Taking PDO connection inside function
	$result = "";
	$whereCondition = "";
	$arrToExecute = array();
	if ($city == "") {
		$whereCondition = "region_id=:region_id";
		$arrToExecute = array(":region_id" => $region_id);
	} else {
		$whereCondition = "region_id=:region_id AND city=:city";
		$arrToExecute = array(":region_id" => $region_id, ":city" => $city);
	}

	$activePDOConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);

	$sql = 'SELECT * FROM ' . TBL_WATER_HEATER_DEALERS . ' WHERE ' . $whereCondition;
	$stmt = $activePDOConnection->prepare($sql);
	$stmt->execute($arrToExecute);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$existanseOfUniqueIDForAllocation = $stmt->rowCount();
	$stmt->closeCursor();
	//return $existanseOfUniqueIDForAllocation;
	return $result;
}

function simple_encrypt($text) {
	global $salt;
	return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($salt), $text, MCRYPT_MODE_CBC, md5(md5($salt)))));
}

function simple_decrypt($text) {
	global $salt;

	//echo mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, "test", MCRYPT_MODE_CBC, md5(md5($salt)));
	//echo trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($salt), base64_decode($text), MCRYPT_MODE_CBC, md5(md5($salt))));
	return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($salt), base64_decode($text), MCRYPT_MODE_CBC, md5(md5($salt))));
}

function sendMail_local($user_name, $user_email, $user_suggestion) {

	$mail = new PHPMailer(); // defaults to using php "mail()"

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host = "smtp.apac-resources.com"; // SMTP server

	$mail->SMTPAuth = false; // enable SMTP authentication

	$mail->Port = 25; // set the SMTP port for the GMAIL server

	$mail->SetFrom(COMPANY_FROM_EMAIL, COMPANY_FROM_NAME);

	$mail->addAddress("gsmart07@gmaiil.com", "Ganesh Sawant");

	$mail->Subject = "Tisva site Feedback";

//$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";// optional, comment out and test
	$body = 'Dear Admin,<br><br>There is one enquiry, Details of enquiry are: <br><br><strong>Name:</strong> ' . $user_name . '<br><strong>Email:</strong> ' . $user_email . '<br> <strong>User Suggestion:</strong> ' . $user_suggestion;

	$mail->MsgHTML($body);

	if (!$mail->Send()) {
		//echo "Mailer Error: " . $mail->ErrorInfo;
		$maiilStatus = "0";
		$maiilError = $mail->ErrorInfo;
		//$updateMailStatus = updateInitialRegistrationMailStatus($maiilStatus, $maiilError, $user_id);
		return false;
	} else {
		//echo "Message sent!";
		//echo "<br/>";
		$maiilStatus = "1";
		$maiilError = "N.A.";
		//$updateMailStatus = updateInitialRegistrationMailStatus($maiilStatus, $maiilError, $user_id);
		return true;
	}
}

function sendMail_server($user_name, $user_email, $user_suggestion) {

	$mail = new PHPMailer(); // defaults to using php "mail()"

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host = "smtp.net4india.com"; // SMTP server

	$mail->SMTPAuth = false; // enable SMTP authentication

	$mail->Port = 25; // set the SMTP port for the GMAIL server

	$mail->SetFrom('customer_care@lifebytisva.com', 'Tisva');

	//$address = "gsmart07@gmail.com";
	$address = "customer_care@lifebytisva.com";
	$mail->AddAddress($address, "Tisva");
	/*$address1 = "gsmart07@gmail.com";
	$mail->AddAddress($address1, "Ganesh");
	$address2 = "jigna.siyal@indigo.co.in";
	$mail->AddAddress($address2, "Jigna");
	$address3 = "kajal_kiran@ushainternational.com";
	$mail->AddAddress($address3, "Kajal");*/


	$mail->Subject = "Tisva site Feedback";

//$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";// optional, comment out and test
	$body = 'Dear Admin,<br><br>There is one enquiry, Details of enquiry are: <br><br><strong>Name:</strong> ' . $user_name . '<br><strong>Email:</strong> ' . $user_email . '<br> <strong>User Suggestion:</strong> ' . $user_suggestion;

	$mail->MsgHTML($body);

	if (!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
		return false;
	} else {
		echo "Message sent!";
		return true;
	}

}

/**
 * [checkIfITokenAlreadyExists This function checks existance of unique_id ]
 * @param  [string] $token [a unique token generated by system to prevent automation attacks ]
 * @return [integer]$existanseOfUniqueID [ 0 if not found and 1 if found match ]
 */
function checkIfITokenAlreadyExists($token) {

	global $activePDOConnection; // Taking PDO connection inside function
	$existanseOfToken = 0;

	$activePDOConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);

	$sql = 'SELECT * FROM ' . TBL_USER_FEEDBACK . ' WHERE token =:token';
	$stmt = $activePDOConnection->prepare($sql);
	$stmt->execute(array(":token" => $token));
	$existanseOfToken = $stmt->rowCount();
	$stmt->closeCursor();
	return $existanseOfToken;
}

?>
