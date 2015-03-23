<?php
	include_once "Utilities.php";
	/*	
		Itemclass:
			Methods:
				Create item
				Delete item
				Update itemn

	*/
	class ListItems
	{
		private $db

		//Constructor that defines a database if it's not passed with the call.
		public function __construct($dbObj=NULL) {
			if(is_object($dbObj)) {
				$this->$db = $dbObj;
			} else {
				$this->$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
			}
		}

		private function getListID($id) {
			$sql = "SELECT l_ID FROM lists WHERE lists.u_ID = :id"
			$stmt = $this->$db->prepare($sql);
			$stmt->bindParam(":id",$id);
			$userID = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return $userID;
		}

		public function createItem($item) {
			$list = getListID($_SESSION["user"]);
			$sql = "INSERT INTO items (l_ID, i_text) VALUES (:list, :item)";
			$params = array(
					array(":list",$list),
					array(":item", $item)
				);
			return Utilities::insertRecord($this->$db,$sql,$params);
		}

		public function deleteItem($item) {
			$sql = "DELETE FROM items WHERE i_ID = :item"
			$stmt = $this->$db->prepare($sql);
			$stmt->bindParam(":id",$item);
			return $stmt->execute();
		}
	}
?>