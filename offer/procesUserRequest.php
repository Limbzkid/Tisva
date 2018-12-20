<?php
/**
 * Processing page, which takes request from user and process it and display output back to user
 *
 */
//header('content-type:text/html;charset=utf-8');
//header('Content-type: application/json');
include_once "includes/include.php";
//ini_set('display_errors', 'On');// enable or disable public display of errors (use 'On' or 'Off')
//echo "test";
$filtering = new FilterClass();
$tokenExists = 0;
//removeEverythingFromSession($_SESSION);
//print_r($_SESSION);
//Filtering out junk, lol testers :P :)
$filtered = $filtering::filterXSS($_POST);
$encryptedText = simple_encrypt($filtered["extras"]);
//$encryptedText ="lNLVLqakkGEjJ+BKV9yvnKqn/2DBZL6kQBL0EcdFfXM=";
$tokenExists =checkIfITokenAlreadyExists($encryptedText);
//echo $encryptedText;
//echo "<br>";
$decryptedText = simple_decrypt($encryptedText);
//$tokenExists = 1;
//var_dump($filtered);
// Comparing securecode in session with secure code coming from post, if someone tries to access this page from outside, exit will get call
if (isset($filtered['code'])) {
	if ($encryptedText != $filtered['code'] || $tokenExists == "1") {
		//Someone is trying to use this script from outside
		//echo "in if";
		$errorMessage = "Don't play with me";
		$errorArray = array();
		$errorArray = array("error_type" => "security", "message" => $errorMessage);
		echo json_encode($errorArray); // For displaying messsage to our page
		exit;
	} else {
		//echo "i m here";
		$formDataValidate = true;
		$formFileDataValidate = true;

		$check_name = "/^[A-Za-z0-9.' ]{3,50}$/";
		// $emailValidRegex ="/^([\w]+)(.[\w]+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/"; perfect
		$check_email = "/^([a-zA-Z0-9.@-_]+\s?)*$/";

		$insertedID = "";
		$errorMessage = "";
		$errorArray = array();

		// Run validations for checking emptiness of form
		// This will be useful if javascript is not working and someone tries to inject data from external sources
		foreach ($filtered as $key => $val) {

			unset($_SESSION[$key . "_error"]); // Unsetting old validation values from session
			$_SESSION[$key] = $val;
			if ($filtered[$key] == "") {
				// Check if fields are empty
				$_SESSION[$key . "_error"] = "This is required field";
				$errorMessage = "This is required field";
				$formDataValidate = false;
				break;
			}

			// Validating customer name
			if ($key == "user_name") {
				if (!preg_match($check_name, $val)) {
					$_SESSION[$key . "_error"] = "Please enter valid name";
					$errorMessage = "Please enter valid name";
					$formDataValidate = false;
					break;
				}
			}

			// Validating customer email
			if ($key == "user_email") {
				if (!preg_match($check_email, $val)) {
					$_SESSION[$key . "_error"] = "Please enter valid email";
					$errorMessage = "Please enter valid email";
					$formDataValidate = false;
					break;
				}
			}

		}

		$errorArray = array("error_type" => "form", "message" => $errorMessage);

		if ($formDataValidate) {
			//print_r($filtered);
			//$unique_id = "toybcdew";
			$allocationStatus = "0"; // This should be 0 to check wheather given id is allocable
			$updatedAllocationStatus = "1"; //This will be the final status of allocated unique id
			$user_name = $filtered["user_name"];
			$user_email = $filtered["user_email"];
			$user_suggestion = $filtered["user_suggestion"];
			$date_of_submission = date("Y-m-d h:i:s");

			// Data collection and image uploading process starts here

			// Check if unique id exists at tables
			//$numberOfRows = checkIfIdFromCustomerExists($unique_id);

			// If unique id exists check if it's available for allocation, if not then show appropriate message to user
			//$checkForAllocation = checkIfIdFromCustomerExistsForAllocation($unique_id, $allocationStatus);

			$activePDOConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE); // Don't autocommit single statement

			try {

				// Checking for integrity of data, running ACID procedure

				$activePDOConnection->beginTransaction(); // Begining transaction, which is one of the safe way to assure data integrity

				// Inserting data to customer table
				$insertUserData = "INSERT INTO " . TBL_USER_FEEDBACK . " (user_name, user_email, user_suggestion, date_of_submission,token)
								VALUES (:user_name, :user_email, :user_suggestion,:date_of_submission, :encryptedText  )";
				$stmt = $activePDOConnection->prepare($insertUserData);
				$insertUserDataOperation = $stmt->execute(array(":user_name" => $user_name, ":user_email" =>
					$user_email, ":user_suggestion" => $user_suggestion, ":date_of_submission" => $date_of_submission, ":encryptedText"=> $encryptedText ));
				$insertedID = $activePDOConnection->lastInsertId();
				$stmt->closeCursor();
				if (!$insertUserDataOperation) {
					throw new Exception("There is some problem occured in system, rolling back please re-enter your details", 1);
				} else {

					$activePDOConnection->commit(); // Woa, Everything goes fine let's commit this transaction
					removeEverythingFromSession($_SESSION); // Remove everything from session, because we are going to need empty from
					$errorArray = array("error_type" => "success", "message" => "sucessfull");

				}

			} catch (exception $e) {

				// Show exception message if required
				$exceptionMessage = $e->getMessage();
				$errorArray = array("error_type" => "exception", "message" => $exceptionMessage);
				$activePDOConnection->rollBack(); // Rollng back everything if it's not going the way it should be
			}

			//$updateAllocationStatus =

		}

		// This is for non-js browswer because it won't be contain ajaxVal, which is triggered by javascript, Woa this thing can be run without javascript
		if (!isset($filtered["ajaxVal"])) {
			header("location:index.php"); // This requires some tweaks, for showing thnak you message
		} else {
			$securityCode = generateSecurityString();
			$errorArray["csrf_token"] = $securityCode;
			$user_name = $filtered["user_name"];
			$user_email = $filtered["user_email"];
			$user_suggestion = $filtered["user_suggestion"];
			$hostname = getenv('HTTP_HOST');
			$mailSent = "";
			if ($hostname == "10.132.150.4:8081") {
				$mailSent = sendMail_local($user_name, $user_email, $user_suggestion);
			} else {
				$mailSent = sendMail_server($user_name, $user_email, $user_suggestion);
			}

			if ($mailSent) {
				$errorArray["mail_error"] = "success";
			} else {
				$errorArray["mail_error"] = "failed";
			}
			echo json_encode($errorArray); // For displaying messsage to our page
		}
	}
} else {
	echo "You cannot access this file";
}