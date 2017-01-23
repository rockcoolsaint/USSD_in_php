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
                    if(count($level) > 1) {
                        //$response = "CON MICRO-PENSIONS"."<br/>";
                        //$response .= "Type contribution amount";
                        $response = "END The sum of ".$level[1]." has been transfered from user’s account to the account of the pension fund operator via the NIBSS interface. Your pension account has been updated, and a notification sent to your phone number with information to reflect the update.";
                        echo "$response";
                    } else {
                        $response = "CON MICRO-PENSIONS"."<br/>";
                        $response .= "Type contribution amount";
                    }

        		  break;

        		case 2:
                    // MICRO-INSURANCE
                    $response = "CON"."<br/>";
                    $response .= "1. LIFE ASSURANCE"."<br/>";
                    $response .= "2. HEALTH INSURANCE"."<br/>";
                    //echo "$response";
        		  break;

                case 3:
                    $response = "TRADING OF SHARES";
                    //echo "$response";
                  break;

                case 4:
                    $response = "PEER TO PEER LENDING";
                    //echo "$response";
                  break;

                case 5:
                    $response = "NON-GOVERNMENT BONDS";
                    //echo "$response";
                  break;
        		
        		default:
                    $list = "1. MICRO-PENSIONS"."<br/>";
                    $list .= "2. MICRO INSURANCE"."<br/>";
                    $list .= "3. TRADING OF SHARES"."<br/>";
                    $list .= "4. PEER TO PEER LENDING"."<br/>";
                    $list .= "5. NON-GOVERNMENT BONDS";

                    $response = "CON"."<br/>"."$list";    
        		  break;
        	}
        }
    }

    echo "$response";
    
?>


