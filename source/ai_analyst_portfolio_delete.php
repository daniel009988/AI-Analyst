<?php 
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: '.'ai_analyst_login.php'); //not logged in
	}
 //Abfrage der Nutzer ID vom Login
$user_id = $_SESSION['userid'];
$pf_name = 'SIMULATED PORTFOLIO';


$host    = "127.0.0.1";
$user    = "webuser";
$pass    = "Vpueokzq1";
$db_name = "42_schema";
//create connection
$connection = mysqli_connect($host, $user, $pass, $db_name);
	//test if connection failed
	if(mysqli_connect_errno()){
    	die("connection failed: "
		  	. mysqli_connect_error()
 			. " (" . mysqli_connect_errno()
 			. ")");
			}

$result = mysqli_query($connection,"DELETE FROM `42_schema`.`PORTFOLIOS_TABLE` WHERE `USER_ID`= $user_id AND `PORTFOLIO_NAME` = '$pf_name';");

header('Location: '.'ai_analyst_portfolios.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<body>


</body>
</html>