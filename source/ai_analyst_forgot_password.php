<?php 
session_start();

// email settings configuration
require('php/config.inc.php');
 
if(isset($_GET['forgot'])) {
    $username = $_POST['username'];
    
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

	$result = mysqli_query($connection,"SELECT * FROM 42_schema.USERS_TABLE WHERE VERIFIED=1 AND EMAIL = '" . $username . "';");
	$all_property = array();  //declare an array for saving property
	//showing property
	while ($property = mysqli_fetch_field($result)) {
    	array_push($all_property, $property->name);  //save those to array
		}
	$user = mysqli_fetch_array($result);
        
    //Überprüfung des Passworts
    if (($user !== false) && ($user['EMAIL'] == $username)) {
    	//send reset link
        $resetlink = password_hash($username, PASSWORD_DEFAULT);
        $verificationLink = "https://terminal.quantumterminal.com/ai_analyst_reset_password.php?code=" . $resetlink; //https://42.cx/website/
    
    $email_body = '
        Hello ' . $fullname .'!<br>
        <br>
        Please click on the link below to reset your password:<br>
        <br>
        <a href="'. $verificationLink. '">Reset my password</a><br>
        <br>
        Your Quantum Terminal team
    ';
    
    // SMTP
        if($config['use_smtp'] === true) {

            require('php/phpmailer/5.2.23/PHPMailerAutoload.php');
            require('php/phpmailer/5.2.23/class.phpmailer.php');


            $m = new PHPMailer();
            $m->IsSMTP();
            $m->SMTPDebug   = false;                    // enables SMTP debug information (for testing) [default: 2]
            $m->SMTPAuth    = true;                     // enable SMTP authentication
            $m->Host        = $config['smtp_host'];     // sets the SMTP server
            $m->Port        = $config['smtp_port'];     // set the SMTP port for the GMAIL server
            $m->Username    = $config['smtp_user'];     // SMTP account username
            $m->Password    = $config['smtp_pass'];     // SMTP account password
            $m->SingleTo    = true;
            $m->CharSet     = "UTF-8";
            $m->Subject     = "Quantum Terminal: reset password";
            $m->AltBody     = 'To view the message, please use an HTML compatible email viewer!';

            //$m->AddAddress($config['send_to'], $config['subject']);
            $m->AddAddress($username, '');
            $m->AddReplyTo($array['email'],   isset($array['name']) ? $array['name'] : $array['email']);
            $m->SetFrom($config['smtp_user'], isset($array['name']) ? $array['name'] : $array['email']);
            $m->MsgHTML("
                {$email_body}
                ---------------------------------------------------<br>
                
            ");

            if($config['smtp_ssl'] === true)
                $m->SMTPSecure = 'ssl';                 // sets the prefix to the server

            // @SEND MAIL
            if($m->Send()) {
                // email with verification link sent successfully!
                header("Location: reset_sent.php");
                exit();
                // die('sent');
                //if($is_ajax === false) {
                //    _redirect('#alert_success');
                //    exit;
                //} else {
                //    die('_success_');
                //}
            } else {
                // die($m->ErrorInfo); 
                if($is_ajax === false) {
                    _redirect('#alert_failed');
                    exit;
                } else {
                    die('_failed_');
                }
            }


        // mail()
        }


    

    //end send verifcation email
        header('Location: '.'ai_ip_analyst_login.php');
        //die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
    	$loggedin = 0;
        $errorMessage = "This email address was not recognized<br>";
    }

    //if ($username === 'guest' && $password === 'guest'){
    //    	$loggedin = 1;
    //    	$_SESSION['username'] = $username;
    //    	header('Location: '.'ai_analyst_home.php');
    //    }
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
		<title>Quantum Terminal Login</title>
		<meta name="description" content="" />
		<meta name="Author" content="Quantum Terminal" />
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



<body class="font-apple-system fs-12 text-white" background="assets/images/2.jpg" style="background-size: 100%; no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;" >
	
	<div id="wrapper">

	<!-- -->
			<section style="background-color: transparent;">
				
				
				<div class="container">
					<br><br>
					
					<div class="row">

						<div class="col-md-6 offset-md-3">

							<!-- ALERT -->
							<?php
							if ($loggedin===0) {echo('
							<div class="alert alert-mini alert-danger mb-30">
								<strong>Oh snap!</strong> Email address not recognized or not activated
							</div>');}?>
							<!-- /ALERT -->

							<div class="box-static box-border-top p-30" style="background:#3e454d;">
								<div class="box-title mb-30">
									<h2 class="fs-20 text-white">FORGOT PASSWORD</h2>
								</div>

								<form class="m-0" method="post" action="?forgot=1" autocomplete="off">
									<div class="clearfix text-white">
										Please enter your email address and click "FORGOT PASSWORD". You will then receive an email with instructions on how to reset your password:<br><br>
										<!-- Email -->
										<div class="form-group">
											<input type="text" name="username" class="form-control" placeholder="Email" required="">
										</div>
											
									</div>
									
									<div class="row">
										
										<div class="col-md-6 col-sm-6 col-6">
											
											
											
										</div>
										
										<div class="col-md-6 col-sm-6 col-6 text-right">

											<button class="btn btn-primary" style="background-color:orange">FORGOT PASSWORD</button>

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
