<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	try {
	    $conn = new PDO("mysql:host=$servername;dbname=sahamitr_coding;charset=utf8", $username, $password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   // echo "Connected successfully"; 
	}catch(PDOException $e){
	    echo "Connection failed: " . $e->getMessage();
	}

	function get_month_name($n){
		$month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม",
						"มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม",
						"พฤษจิกายน", "ธันวาคม");
		return $month[(int)($n-1)];
	}
?>