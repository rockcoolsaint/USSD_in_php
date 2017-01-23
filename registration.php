<?php
    /*
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
    **/

	class Receiver{

    // Define required parameters to receive response

    /*
        decode the json data an get them to an array
        Get data from Json objects
        check the validity of the response
    **/
    /*
    public function __construct(){
        $array = json_decode(file_get_contents('php://input'), true);
        $this->sourceAddress = $array['sourceAddress'];
        $this->message = $array['message'];
        $this->requestId = $array['requestId'];
        $this->applicationId = $array['applicationId'];
        $this->encoding = $array['encoding'];
        $this->version = $array['version'];
        $this->sessionId = $array['sessionId'];
        $this->ussdOperation = $array['ussdOperation'];
        $this->vlrAddress = $array['vlrAddress'];

        if (!((isset($this->sourceAddress) && isset($this->message)))) {
            throw new Exception("Some of the required parameters are not provided");
        } else {
            // Success received response
            $responses = array("statusCode" => "S1000", "statusDetail" => "Success");
            header("Content-type: application/json");
            echo json_encode($responses);
        }
    }
    **/
    // Define DB parameter
    private $db;

    // Define required parameters to receive response
    private $text;
    private $phonenumber;
    private $serviceCode;

    // Define method for registration
    function __construct($db=NULL) {
        if(is_object($db))
        {
            $this->_db = $db;
        }
        else
        {
            $dsn = "mysql:host=localhost;dbname=ussd";
            $this->_db = new PDO($dsn, $user, $pass);
        }

        $this->text = $_GET['USSD_STRING'];
        $this->phonenumber = $_GET['MSISDN'];
        $this->serviceCode = $_GET['serviceCode'];
        
        // Verify number of user
    	// Register if fresh user and display main menu
    	// Reject user if verification fails
    	if (isset($this->phonenumber) && !empty($this->phonenumber)) {
            // Verify if number already exists in DB and display menu if true
            $sql = "SELECT * FROM users WHERE phone_no = :number";
            try {
                $query = $db->prepare($sql);
                $query->bindParam(':number', $this->phonenumber, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                if (count($results) == 1) {
                    // Display Menu
                    //$list = "<ol>";
                    $list = "1. MICRO-PENSIONS"."<br/>";
                    $list .= "2. MICRO INSURANCE"."<br/>";
                    $list .= "3. TRADING OF SHARES"."<br/>";
                    $list .= "4. PEER TO PEER LENDING"."<br/>";
                    $list .= "5. NON-GOVERNMENT BONDS";

                    $response = "CON"."<br/>"."$list";
                    echo "$response";
                } else {
                    // NIBSS verification
                    if (strlen($this->phonenumber) < 11) {
                        // request failed!
                        echo "END Sorry, this number ". $this->phonenumber ." failed verification.";
                    } 
                    else {  
                        // Insert record into DB
                        $sql = "INSERT INTO users(f_name, l_name, phone_no)
                            VALUES(:f_name, :l_name, :phone_no)";
                        if ($query = $db->prepare($sql)) {
                            $query->bindParam(":f_name", $levels[0], PDO::PARAM_STR);
                            $query->bindParam(":l_name", $levels[1], PDO::PARAM_STR);
                            $query->bindParam(":phone_no", $this->phonenumber, PDO::PARAM_STR);
                            $query->execute();

                            $list = "1. MICRO-PENSIONS"."<br/>";
                            $list .= "2. MICRO INSURANCE"."<br/>";
                            $list .= "3. TRADING OF SHARES"."<br/>";
                            $list .= "4. PEER TO PEER LENDING"."<br/>";
                            $list .= "5. NON-GOVERNMENT BONDS";

                            $response = "CON"."<br/>"."$list";
                            return "$response";
                            //return "END You have registered successfully";  
                        }
                    }
                }           
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    /*
        Define getters to return receive data
    **/
    /*
    public function getAddress(){
        return $this->sourceAddress;
    }

    public function getMessage(){
        return $this->message;
    }

    public function getRequestID(){
        return $this->requestId;
    }

    public function getApplicationId(){
        return $this->applicationId;
    }

    public function getEncoding(){
        return $this->encoding;
    }

    public function getVersion(){
        return $this->version;
    }

    public function getSessionId(){
        return $this->sessionId;
    }

    public function getUssdOperation(){
        return $this->ussdOperation;
    }
    **/

    public function getText(){
        return $this->text;
    }

    public function getPhoneNumber(){
        return $this->phonenumber;
    }

    public function getServiceCode(){
        return $this->serviceCode;
    }
}

?>