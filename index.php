<?php
    //require_once 'connection.php';
    require_once 'registration.php';

    #We obtain the data which is contained in the post url on our server.

    $text=$_GET['USSD_STRING'];
    $phonenumber=$_GET['MSISDN'];
    $serviceCode=$_GET['serviceCode'];

    $level = explode("*", $text);

    if (isset($serviceCode)) {
    	switch ($serviceCode) {
    		case '*456*0' || '*456':
    			// registration
                $response = register($phonenumber, $text, $level);
    			break;

    		//case '*456*1':

    		//	break;
    		
    		default:
    			//registration
    			break;
    	}
    }

    echo $response;
?>


