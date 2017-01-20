<?php
    require_once 'connection.php';
    require_once 'registration.php';

    #We obtain the data which is contained in the post url on our server.

    //$text=$_GET['USSD_STRING'];
    //$phonenumber=$_GET['MSISDN'];
    //$serviceCode=$_GET['serviceCode'];

    $receiver = new Receiver($db); // Create the receiver object
    $text= $receiver->getText();
    $phonenumber = $receiver->getPhoneNumber();
    $serviceCode = $receiver->getServiceCode();
    //$serviceCode=$_GET['serviceCode'];
    //echo "$serviceCode";
    $level = explode("*", $text);

    if ($serviceCode =='*456*0' || $serviceCode == '*456') {
        if(!empty($level)) {
        	switch ($level[0]) {
        		case 1:
        			//  MICRO-PENSIONS
                    //$response = "MICRO-PENSIONS";
                    $response = "END The sum of ".$level[1]." has been transfered from user’s account to the account of the pension fund operator via the NIBSS interface. Your pension account has been updated, and a notification sent to your phone number with information to reflect the update.";
        		  break;

        		case 2:
                    // MICRO-INSURANCE
                    $response = "CON"."<br/>";
                    $response .= "1. LIFE ASSURANCE"."<br/>";
                    $response .= "2. HEALTH INSURANCE"."<br/>";
        		  break;

                case 3:
                    $response = "TRADING OF SHARES";
                  break;

                case 4:
                    $response = "PEER TO PEER LENDING";
                  break;

                case 5:
                    $response = "NON-GOVERNMENT BONDS";
                  break;
        		
        		default:
        			//registration
        		  break;
        	}
        }
    }

    echo $response;
?>


