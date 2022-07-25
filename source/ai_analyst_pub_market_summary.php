<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: '.'ai_analyst_login.php'); //not logged in
	}
 //Abfrage der Nutzer ID vom Login
$user_id = $_SESSION['userid'];
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$pf_name = 'SIMULATED PORTFOLIO';

//Requirements für StockChartTools:
require_once '../psmw/shortcode.php';
$templates = json_decode(file_get_contents('../psmw/templates/templates.json'), TRUE);
$env = json_decode(file_get_contents('../psmw/config/env.json'), TRUE);

//startdatechart übergeben? format: YYYY-MM-DD
$start_date = $_GET["startdatechart"];
if ($start_date=='') {$start_date='2018-01-03';}
//$start_date='2018-01-03';
include 'include_menu.php';
?>


			
			<!-- Main AREA -->
			
			<div class="container">
			<div class="container">
				<br>
				<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>Research Public AI companies</h4>
					</div> 

				<!-- WELCOME TEXT -->
				<p class="font-lato fs-15">A compilation of all public listed companies which are specialised in or create real product value with Artificial Intelligence.</p>

				<div class="card card-default" id="SUMMARY">
						<div class="card-heading card-heading-transparent">
							<h5><span><span>Available Sectors</span></h5>
				</div>			
				
				<div class="card-block">

				<!-- SECTIONS -->
				<div class="row">
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-cloud"></i>
									<h5>IT / PLATFORMS / ENABLERS</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=IT/PLATFORM/ENABLER">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-users"></i>
									<h5>HR / OUTSOURCING</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=HR/OUTSOURCING">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-user-secret"></i>
									<h5>CYBERSECURITY</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=CYBERSECURITY">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-medkit"></i>
									<h5>HEALTHCARE</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=HEALTHCARE">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-area-chart"></i>
									<h5>FINANCE</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=FINANCE">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-connectdevelop"></i>
									<h5>SEMICONDUCTORS</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=SEMICONDUCTOR">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-soundcloud"></i>
									<h5>CRM</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=CRM">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-space-shuttle"></i>
									<h5>DEFENSE</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=DEFENSE">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-whatsapp"></i>
									<h5>MOBILE / COMMUNICATION</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php#MOBILECOMMUNICATION">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-graduation-cap"></i>
									<h5>EDUCATION</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=EDUCATION">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-google"></i>
									<h5>LARGE CAPS</h5>
							</div>
							<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_stocks.php?category=LARGE CAP">Show companies</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
							<div class="box-icon-title">
								<i class="fa fa-search-plus"></i>
									<h5>ADVANCED SEARCH</h5>
							</div>
							<?php 
							if ($usertype==2) {echo '
								<p class="font-lato fs-15 fw-300"><i class="fa fa-lock"></i> Premium feature</p>
								';}
							?>
							<?php 
							if ($usertype<>2) {echo '
								<p align="center"><a href="ai_analyst_pe_search.php"><button type="button" class="btn btn-primary btn-sm">SEARCH</button></a></p>
								';}
							?>
						</div>
					</div>

				
			



					

					


				</div>

			</div>	
			</section>

			</div>
		</section>
	</div>



		</div>
		<!-- /wrapper -->

</body>
</html>