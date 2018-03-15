<html><body>
    
<?php
if (!empty($_REQUEST)) {
$pw= $_POST["txtPassword"];
$cpw = $_POST["txtConPassword"];
echo "password : $pw<br>";
echo "conpassword: $cpw";
}  
?>
</body></html> 