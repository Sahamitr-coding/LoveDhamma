<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	
	//$servername = "10.199.66.227";
	//$username = "Sec02_Saha";
	//$password = "H4s7cm39";


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

	function is_thai_numeric($n){
		$thai_digit = array('๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙');
		foreach ($thai_digit as $i) {
			if(strpos($n, $i) !== false){
				return 1;
			}
		}
		return 0;
	}
?>