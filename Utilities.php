<?php
	class Utilities 
	{
		private static $initialized = false;
		private static function initialize() {
			if (self::$initialized)
					return;
			self::$initialized = true;
		}
			/*
		*	Insertions in database
		*
		*	@params PDO object $db string $sql, array $paramArray
		*/
		public static function insertRecord($db, $sql, $paramArray) {
			self::initialize();
			$result = array("hasError" => false, "errorText" => "No error!" );

			$stmt = $db->prepare($sql);
			for ($i = 0; $i < count($paramArray); $i++) {
				$stmt->bindParam($paramArray[$i][0],$paramArray[$i][1]);
			}
			if(!$stmt->execute()) {
				$result["hasError"] = true;
				$error = $stmt->errorInfo();
				$result["errorText"] = $error[2];
			}
			$stmt->closeCursor();

			return $result['hasError'];
		}

		


	}
?>