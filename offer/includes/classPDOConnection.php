<?php

class PDOConnectionClass {

	var $conn = null;

	private $message = '';

	/**
	 * Open the database connection
	 */
	public function __construct() {
		// open database connection
		$connectionString = sprintf("mysql:host=%s;dbname=%s",
			DB_HOST,
			DB_NAME);
		try {
			$this->conn = new PDO($connectionString,
				DB_USERNAME,
				DB_PASSWORD);

		} catch (PDOException $pe) {
			die($pe->getMessage());
		}
	}

	/**
	 * get message
	 * @return string the message of transfering process
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * set connection
	 * @return string the message of transfering process
	 */
	public function setConnection() {
		return $this->conn;
	}

	public function destroyConnection() {
		$this->conn = null;
	}

	/**
	 * close the database connection
	 */
	/*public function __destruct() {
// close the database connection
$this->conn = null;
}*/

}
