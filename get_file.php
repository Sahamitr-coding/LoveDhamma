<?php
	require('connect.php');

	$pattern_normal_input_form = '/(\d|[๐-๙]{3})+/';
	$digit = '/([0-9]|[๐๑๒๓๔๕๖๗๘๙]{3})+/';
	$special = '/^\W+$/';
	$match = '/([A-Z]{1,2})([0-9]{6,7})/';
    $username_character = '/^[a-z A-Z 0-9 \- \_][a-z A-Z 0-9 \- \_]+[a-z A-Z 0-9 \- \_]$/';


    echo preg_match($username_character, "123"). "<br>";
    echo preg_match($username_character, "AA12345"). "<br>";
    echo preg_match($username_character, "AA1กด23456"). "<br>";
    echo preg_match($username_character, "กดA12345"). "<br>";
    echo preg_match($username_character, "A1*$23456"). "<br>";
    echo preg_match($username_character, "AAAA_-12345"). "<br>";
    echo "PASSS";

	echo preg_match($match, "123"). "<br>";
    echo preg_match($match, "AA12345"). "<br>";
    echo preg_match($match, "AA123456"). "<br>";
    echo preg_match($match, "A12345"). "<br>";
    echo preg_match($match, "A123456"). "<br>";
    echo preg_match($match, "AAAA12345"). "<br>";
    echo "DIGIT";
    echo preg_match($digit, "123๖๖๖๖๖"). "<br>";
    echo preg_match($digit, "๗๗๗๗๗"). "<br>";
    echo preg_match($digit, "๓dki"). "<br>";
    echo preg_match($digit, "dkk๓"). "<br>";
    echo preg_match($digit, "กาก"). "<br>";
    echo preg_match($digit, "ขขAAA"). "<br>";
    echo "SPECIAL";
    echo preg_match($special, "123"). "<br>";
    echo preg_match($special, "๗๗๗"). "<br>";
    echo preg_match($special, "๓dki"). "<br>";
    echo preg_match($special, "dkk๓"). "<br>";
    echo preg_match($special, "FFกกกก"). "<br>";
    echo preg_match($special, "ขขAAA");
	

?>