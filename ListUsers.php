<?php
	include_once "Utilities.php";
	/*
	*/

	class ListUsers
	{
		//Database object
		private $db;

		//Constructor that defines a database if it's not passed with the call.
		public function __construct($dbObj=NULL) {
			if(is_object($dbObj)) {
				$this->db = $dbObj;
			} else {
				$this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
			}
		}


		private function userExists($userID) {
			$sql = "SELECT COUNT(*) as num_of_users FROM users WHERE users.u_id = :id";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":id",$userID);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return ($result["num_of_users"] != 0); 
		}

		/*
		*	Creates a User-Account
		*
		*	Returns a string
		*/
		public function createAccount() {
			$user = false;

			//If he/she doesn't have a record, make sure they get one!
			if(!$this->userExists($_SESSION["user"])) {
				
				//Create the user
				$sql = "INSERT INTO users (u_id, u_firstname, u_lastname) VALUES (:id, :first, :last)";
				$params = array (
						array(":id",$_SESSION["user"]),
						array(":first",$_SESSION["u_firstname"]),
						array(":last",$_SESSION["u_lastname"])
					);
				$user = Utilities::insertRecord($this->db,$sql,$params);

				//Give them a list to put items in
				$sql = "INSERT INTO lists (u_ID) VALUES (:id)";
				$params = array (
						array(":id",$_SESSION["user"])
					);
				Utilities::insertRecord($this->db,$sql,$params);
			} 

			return $user;
		}

		public function deleteAccount() {}

		public function getItems() {
			$sql = "SELECT * FROM items INNER JOIN lists ON lists.l_ID = items.l_ID WHERE lists.u_ID = :user";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":user",$_SESSION["user"]);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$stmt->closeCursor();
			return $result;
		}

	}
?>