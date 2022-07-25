<?php 
session_start();
 
$code = $_GET['code'];
if ($code==''){
	echo 'ACCESS DENIED.';
    exit();
}

if(isset($_GET['reset'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $loggedin = 0;

    //echo $username . '<br>';
    //echo $password . '<br>';
    //echo $code . '<br>';

    if (password_verify($username,$code)===false) {
    	echo 'DENIED. NOT YOUR EMAIL';
    	exit;
    }

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

	$password = password_hash($password, PASSWORD_DEFAULT);

	$sql = "UPDATE 42_schema.USERS_TABLE SET PASSWORD='".$password."' WHERE EMAIL = '" . $username . "';";
	if ($connection->query($sql) === TRUE) {
		header('Location: '.'ai_ip_analyst_login.php');
	}
	else {
	echo "Error: " . $sql . "<br>" . $connection->error;
	}

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/psmw/css/style.css" />
	<script src="/psmw/js/app.min.js"></script>

	<meta charset="utf-8" />
		<title>Oaklins Terminal Login</title>
		<meta name="description" content="" />
		<meta name="Author" content="42.CX Center of Excellence Daniel Mattes" />
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700" rel="stylesheet" type="text/css" />
	<!-- CORE CSS -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- THEME CSS -->
	<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/layout.css" rel="stylesheet" type="text/css" />
	
	<!-- PAGE LEVEL SCRIPTS -->
	<link href="assets/css/header-1.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/color_scheme/darkblue.css" rel="stylesheet" type="text/css" id="color_scheme" />

	<!-- REVOLUTION SLIDER -->
	<link href="assets/plugins/slider.revolution/css/extralayers.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/slider.revolution/css/settings.css" rel="stylesheet" type="text/css" />

	<!-- BACKGROUND IMAGE CSS -->
	<style>
		img.bg {
			/* Set rules to fill background */
			min-height: 100%;
			min-width: 1024px;
			
			/* Set up proportionate scaling */
			width: 100%;
			height: auto;
			
			/* Set up positioning */
			position: fixed;
			top: 0;
			left: 0;
		}
		
		@media screen and (max-width: 1024px){
			img.bg {
				left: 50%;
				margin-left: -512px; }
		}
		
		#page-wrap { position: relative; width: 400px; margin: 50px auto; padding: 20px; background: white; -moz-box-shadow: 0 0 20px black; -webkit-box-shadow: 0 0 20px black; box-shadow: 0 0 20px black; }
		p { font: 15px/2 Georgia, Serif; margin: 0 0 30px 0; text-indent: 40px; }
	</style>


</head>



<body class="smoothscroll enable-animation">
	
	<div id="wrapper">

	<!-- -->
			<section>
				<img src="assets/images/BACKGROUND-login.PNG" class="bg">
				
				<div class="container")>
					<br><br>
					
					<div class="row">

						<div class="col-md-6 offset-md-3">

							<!-- ALERT -->
							<?php
							if ($loggedin===0) {echo('
							<div class="alert alert-mini alert-danger mb-30">
								<strong>Oh snap!</strong> Account not activated or login incorrect!
							</div>');}?>
							<!-- /ALERT -->

							<div class="box-static box-border-top p-30" style="background:#F8F8F8;">
								<div class="box-title mb-30">
									<h2 class="fs-20">RESET PASSWORD</h2>
								</div>

								<form class="m-0" method="post" action="?reset=1&code=<?php echo $code; ?>" autocomplete="off">
									<div class="clearfix">
										Please enter your email and your new password below and click "RESET PASSWORD" to reset your password:<br><br>
										<!-- Email -->
										<div class="form-group">
											<input type="text" name="username" class="form-control" placeholder="Email" required="">
										</div>
										New password:<br><br>
										<!-- Password -->
										<div class="form-group">
											<input type="password" name="password" class="form-control" placeholder="Password" required="">
										</div>
											
									</div>
									
									<div class="row">
										
										<div class="col-md-6 col-sm-6 col-6">
											
											
											
										</div>
										
										<div class="col-md-6 col-sm-6 col-6 text-right">

											<button class="btn btn-primary">RESET PASSWORD</button>

										</div>
										
									</div>
									
								</form>

							</div>
							</div>
							

						</div>
					</div>
					
				</div>






			</section>
			<!-- / -->

			

			
	</div>
	<!-- /wrapper -->


		
		

		

		




</body>
</html>
