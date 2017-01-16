<?php
	//require_once 'connection.php';
?>
<?php
	function register($number, $texts, $levels) {
		require 'connection.php';
		// Start registration process
		if (isset($number) && !empty($number)) {
			// Verify if number already exists in DB and display menu if true
			$sql = "SELECT * FROM users WHERE phone_no = :number";
			try {
				$query = $db->prepare($sql);
				$query->bindParam(':number', $number, PDO::PARAM_STR);
				$query->execute();
				$results = $query->fetchAll(PDO::FETCH_ASSOC);
				if (count($results) == 1) {
					// Display Menu
					$list = "<ol>";
					$list .= "<li>MICRO-PENSIONS</li>";
					$list .= "<li>MICRO INSURANCE</li>";
					$list .= "<li>TRADING OF SHARES</li>";
					$list .= "<li>PEER TO PEER LENDING</li>";
					$list .= "<li>NON-GOVERNMENT BONDS</li>";
					$list .= "</ol>";

					echo "CON $list";
				} else {
					// NIBSS verification
					if (strlen($number) < 11) {
						// request failed!
						return "END Sorry, this number ". $number ." failed verification.";
					} 
					else {	
						// Insert record into DB
						$sql = "INSERT INTO users(f_name, l_name, phone_no)
                			VALUES(:f_name, :l_name, :phone_no)";
                		if ($query = $db->prepare($sql)) {
				            $query->bindParam(":f_name", $levels[0], PDO::PARAM_STR);
				            $query->bindParam(":l_name", $levels[1], PDO::PARAM_STR);
				            $query->bindParam(":phone_no", $number, PDO::PARAM_STR);
				            $query->execute();
							return "END You have registered successfully";	
						}
					}
				}			
			} catch (Exception $e) {
				echo "Error: " . $e->getMessage();
			}
		} 
	}
?>