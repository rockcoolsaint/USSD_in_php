<?php
	// configuration info
    $user = 'root';
    $pass = '';
    $db = new PDO( 'mysql:host=localhost;dbname=ussd', $user, $pass );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>