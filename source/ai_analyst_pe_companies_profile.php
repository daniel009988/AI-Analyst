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
$stock_symbol = $_GET['symbol'];
if ($start_date=='') {$start_date='2018-01-03';}
//$start_date='2018-01-03';
include 'include_menu.php';
?>

<!-- FIX TOOLTIP FLICKERING -->
<style>
    .tooltip {
  pointer-events: none;
}
</style>


			<!-- SCROLL TO TOP -->
		<a href="#" id="toTop"></a>
		<!-- PRELOADER 
		<div id="preloader">
			<div class="inner">
				<span class="loader"></span>
			</div>
		</div><!-- /preloaderADER -->

			
			<!-- Chart -->
			<div class="container">
				
					<div class="container">
					<br>
					<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4><?php echo $stock_symbol; ?> Profile</h4>
					</div>
					
					<!-- SECTION LINKS -->

					<a href='#SUMMARY' class="font-lato fs-15">SUMMARY</a>&nbsp;|&nbsp;
					<a href='#EXPERTS' class="font-lato fs-15">RATINGS</a>&nbsp;|&nbsp;
					<a href='#FUNDING' class="font-lato fs-15">FUNDING</a>&nbsp;|&nbsp;
					<a href='#DECKS' class="font-lato fs-15">PRESENTATIONS</a>&nbsp;|&nbsp;
					<a href='#NEWS' class="font-lato fs-15">NEWS</a>&nbsp;|&nbsp;
					<a href='#KEYPEOPLE' class="font-lato fs-15">KEYPEOPLE</a>&nbsp;|&nbsp;
					<a href='#TECHNOLOGY' class="font-lato fs-15">PATENTS</a>&nbsp;|&nbsp;
					<a href='#WEBTRACTION' class="font-lato fs-15">WEB</a>&nbsp;|&nbsp;
					<a href='#COMPETITION' class="font-lato fs-15">COMPETITION</a>&nbsp;|&nbsp;
					<a href='#MULTIPLES' class="font-lato fs-15">MULTIPLES</a>&nbsp;
					
					<a href="javascript:history.back()"><button type="button" class="btn btn-primary btn-sm">Go back</button></a>

					<br><br>
					<!-- CHART 
					<div class="card card-default" id="CHART">
						<div class="card-heading card-heading-transparent">
							<h2 class="card-title"><strong>CHART</strong></h2>
						</div>
						<div class="card-block">
						<div id="main" style="width: 1000px;height:650px;"></div>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>-->

				
					<!-- SUMMARY -->
					<div class="card card-default" id="SUMMARY">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa fa fa-home"></i><strong> SUMMARY</strong></h5>
						</div>
						<div class="card-block">

						<?php 
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
						//get results from database
						$result = mysqli_query($connection,"select Symbol,Name,Ranking, Country,Growthstage, Employees,Category,Website,SUBSTRING(Description,1,5000) AS Description, Launchdate, Founders, Employees, `Operating Status`, `Category Groups`, `Top 5 Investors`, `Total Funding Amount Currency (in USD)`, `Headquarters Location`, `IPqwery - Patents Granted`,`IPqwery - Trademarks Registered`,`IPqwery - Most Popular Patent Class`, `IPqwery - Most Popular Trademark Class`,`Aberdeen - IT Spend`,`Aberdeen - IT Spend Currency`,`Aberdeen - IT Spend Currency (in USD)`, `SimilarWeb - Monthly Visits`,`SimilarWeb - Average Visits (6 months)`,`SimilarWeb - Monthly Visits Growth`, `SimilarWeb - Visit Duration`,`SimilarWeb - Visit Duration Growth`,`SimilarWeb - Page Views / Visit`, `SimilarWeb - Page Views / Visit Growth`,`SimilarWeb - Bounce Rate`,`SimilarWeb - Bounce Rate Growth`, `SimilarWeb - Global Traffic Rank`,`SimilarWeb - Monthly Rank Change (#)`,`SimilarWeb - Monthly Rank Growth`, `Apptopia - Number of Apps`,`Apptopia - Downloads Last 30 Days`

							from COMPANIES_TABLE where Symbol= '$stock_symbol'");
						$all_property = array();  
						while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
						
						while ($row = mysqli_fetch_array($result)) {
								$companyname = $row['Name'];
								$companywebsite = $row['Website'];
								$companysymbol = $row['Symbol'];
								$growthstage = $row['Growthstage'];
								$operatingstatus = $row['Operating Status'];
								$companyranking = $row['Ranking'];
								$categorygroups = $row['Category Groups'];
								$description = preg_replace('/[[:^print:]]/', '', $row['Description']);
								$dealroom_launchdate = $row['Launchdate'];
								$dealroom_founders = $row['Founders'];
								$dealroom_employees = $row['Employees'];
								$topinvestors = $row['Top 5 Investors'];
								$totalfunding = $row['Total Funding Amount Currency (in USD)'];
								$hqlocation = $row['Headquarters Location'];
								// technology:
								$patentsgranted = $row['IPqwery - Patents Granted'];
								$tmregistered = $row['IPqwery - Trademarks Registered'];
								$patentclass = $row['IPqwery - Most Popular Patent Class'];
								$tmclass = $row['IPqwery - Most Popular Trademark Class'];
								$itspend = $row['Aberdeen - IT Spend'];
								$itspendcurr = $row['Aberdeen - IT Spend Currency'];
								$itspendusd = $row['Aberdeen - IT Spend Currency (in USD)'];
								// website and app traction:
								$web_visits = $row['SimilarWeb - Monthly Visits'];
								$web_visits_avg = $row['SimilarWeb - Average Visits (6 months)'];
								$web_visits_monthly_growth = $row['SimilarWeb - Monthly Visits Growth'];
								$web_visits_duration = $row['SimilarWeb - Visit Duration'];
								$web_visits_duration_growth = $row['SimilarWeb - Visit Duration Growth'];
								$web_pageviews_visit = $row['SimilarWeb - Page Views / Visit'];
								$web_pageviews_visit_growth = $row['SimilarWeb - Page Views / Visit Growth'];
								$web_bouncerate = $row['SimilarWeb - Bounce Rate'];
								$web_bouncerate_growth = $row['SimilarWeb - Bounce Rate Growth'];
								$web_globalrank = $row['SimilarWeb - Global Traffic Rank'];
								$web_monthlyrank_change = $row['SimilarWeb - Monthly Rank Change (#)'];
								$web_monthlyrank_growth = $row['SimilarWeb - Monthly Rank Growth'];
								$apps_number = $row['Apptopia - Number of Apps'];
								$apps_downloads = $row['Apptopia - Downloads Last 30 Days'];
								$name = $row['Name'];

								echo '<table width="100%" border="0"><tr>';
								echo '<td width="25%" valign="top"><h6>NAME</h6></td>';
								echo '<td width="25%" valign="top">
								<div class="font-lato fs-10"><b>' . $companysymbol . '</b></div>
								<p class="font-lato fs-15"><b>' . $row['Name'] . ' ';
								if ($companyranking>0) {echo '<i class="fa fa-trophy" style="color:#2980b9"></i>';}
								if ($companyranking=0) {echo '&nbsp;';}
								echo '</b><br><br><a href="' . $row['Website'] . '" target="_">' . $row['Website'] . '</a></p><td>';
								echo '<td width="25%" valign="top"><h6>CATEGORIES</h6></td>';
								echo '<td width="25%" valign="top"><p class="font-lato fs-15">' . $row['Category'] . '</p><td>';
								echo '</tr><tr>';
								
								echo '<td width="25%" valign="top"><h6>EMPLOYEES</h6></td>';
								echo '<td width="25%" valign="top"><p class="font-lato fs-15">' . $row['Employees'] . '</p><td>';

								
								echo '<td width="25%" valign="top"><h6>LAUNCH DATE</h6></td>';
								echo '<td width="25%" valign="top"><p class="font-lato fs-15">' . $dealroom_launchdate . '</p><td>';
					
								echo '</tr><tr>';
								echo '<td width="25%" valign="top"><h6>HQ LOCATION</h6></td>'; 
								echo '<td width="25%" valign="top"><p class="font-lato fs-15">' . $hqlocation . '<br>' . $row['Country'] . '</p><td>';
								echo '<td width="25%" valign="top">';
								
								echo '<h6>STATUS</h6></td>';
								echo '<td width="25%" valign="top"><p class="font-lato fs-15">' . $growthstage . ', ' . $operatingstatus . '</td>';
								echo '</tr>';
								echo '</table>';

								echo '<table width="100%"><tr>';
								echo '<td width="25%" valign="top"><h6>DESCRIPTION</h6></td>';
								echo '<td width="75%" valign="top"><div class="font-lato fs-15">' . $description . '</div><div class="font-lato fs-12">Tags: ' . $categorygroups . '</div></td>';
								echo '</tr>';
								
								//echo '<table width="100%"><tr>';
								//echo '<td width="25%" valign="top"><h6>WEBSITE</h6></td>';
								// website screenshot:
								//if ($companywebsite<>'') {
								//echo '<td width="35%"" valign="top">';
								//$use_cache = false;
								//$apc_is_loaded = extension_loaded('apc');
	
    							//if($apc_is_loaded) {
        						//	apc_fetch("thumbnail:".$site, $use_cache);
								//}
								//if(!$use_cache) {
								//	$siteURL = $companywebsite; 
								//	$googlePagespeedData = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$siteURL&screenshot=true");//decode json data
								//	$googlePagespeedData = json_decode($googlePagespeedData, true);//screenshot data
								//	$screenshot = $googlePagespeedData['screenshot']['data'];
								//	if($apc_is_loaded) {
            					//		apc_add("thumbnail:".$site, $screenshot, 2400);
								//	}
								//}
								//$screenshot = str_replace(array('_','-'),array('/','+'),$screenshot); //display screenshot image

								//echo '<div class="thumbnail image-hover-zoom">';
								//echo "<img class='img-fluid' src='data:image/jpeg;base64," . $screenshot . "' alt='' />";
								//echo '</div>';
								//}
								//echo '</td><td width="40%"" valign="top"></td>';
								echo '</table>';
								// website screenshot end

								echo '<td>';
								echo '</tr>';

								

		    					
		        				
		        				
		    					}
						?>

						<!-- BUY SHARES -->
						<div class="row">
							<div class="col-md-12">
								<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
									<div class="box-icon-title">
										<i class="fa fa-thumbs-o-up"></i>
									</div>
									<table width="100%">
										<tr>
											<td width="50%"><p class="font-lato fs-13" align="left">
												<span class="font-lato fs-12">Interested in this company?</span>
												<span class="block font-lato fs-16">Submit a request to buy shares in <?php echo $companyname; ?>
											</td>
											<td width="40%">
												<form class="m-0" method="post" action="buyshares.php" autocomplete="off">
													<input type="hidden" value="<?php echo "$companysymbol"; ?>" id="investmentsymbol" name="investmentsymbol" class="serch-input">
													<input type="hidden" value="<?php echo "$user_id"; ?>" id="userid" name="userid" class="serch-input">
													<div class="clearfix">
														<select class="form-control pointer" name="investment">
																				<option disabled="disabled" value="">--- Select investment range ---</option>
																			 	<option value="100000">$100,000 - $250,000</option>
																                <option value="250000">$250,000 - $500,000</option>
																                <option value="500000">$500,000 - $1,000,000</option>
																                <option value="1000000">$1,000,000 - $5,000,000</option>
																                <option value="5000000">$5,000,000 or more</option>
														</select>
													</div>
											</td>
											<td width="10%">
													<div class="col-md-6 col-sm-6 col-6 text-right">
														<button class="btn btn-primary">SUBMIT</button>
													</div>
												</form>
											</td>
										</tr>
									</table>

									
									
								
								</div>
							</div>
						</div>
				
						<!-- /BUY SHARES -->

						</div>

						<div class="card-footer card-footer-transparent">
						</div>
					</div>

					<!-- SCORING, RATINGS, EXPERTS -->
					<div class="card card-default" id="EXPERTS">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-line-chart"></i><strong> SCORINGS, EXPERT REVIEWS AND RATINGS</strong></h5><a href="ai_analyst_know_scoring.php"><div class="font-lato fs-12">Learn more <i class="fa fa-info-circle"></i></div></a>
						</div>
						<div class="card-block">

						<?php 
						if ($usertype==2) {echo '
							<img src="assets/images/scoring_locked.png" alt="" />
							<p class="font-lato fs-15"><i class="fa fa-lock"></i> This is a premium feature and only available for subscribers. <a href="ai_analyst_subscription.php#subscribe">Subscribe now</a> or learn more about <a href="ai_analyst_know_scoring.php">our scoring</a>.</p>

							';}
						?>

						<?php 
						if ($usertype<>2) {
								//get scorings from database:
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
								//get results from database
								$result = mysqli_query($connection,"select * from SCORING_TABLE where Symbol= '$stock_symbol'");
								$all_property = array();  
								while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
								
								while ($row = mysqli_fetch_array($result)) {
										//summary scores:
										$me_score = $row['me_score'];
										$fh_score = $row['fh_score'];
										$m_score = $row['m_score'];
										$ai_score = $row['ai_score'];
										$total_score = $row['total_score'];
										//sector funding momentum:
										$s_fm = $row['s_fm'];
										$s_fm_min = $row['s_fm_min'];
										$s_fm_max = $row['s_fm_max'];
										$s_fm_val = $row['s_fm_val'];
										$s_fm_score = $row['s_fm_score'];
										//sector exit momentum:
										$s_em = $row['s_em'];
										$s_em_min = $row['s_em_min'];
										$s_em_max = $row['s_em_max'];
										$s_em_val = $row['s_em_val'];
										$s_em_score = $row['s_em_score'];
										//sector investor quality:
										$s_iqlty = $row['s_iqlty'];
										$s_iqlty_industry = $row['s_iqlty_industry'];
										$s_iqlty_max = $row['s_iqlty_max'];
										$s_iqlty_score = $row['s_iqlty_score'];
										//sector investor quantity:
										$s_iqtty = $row['s_iqtty'];
										$s_iqtty_industry = $row['s_iqtty_industry'];
										$s_iqtty_max = $row['s_iqtty_max'];
										$s_iqtty_score = $row['s_iqtty_score'];
										//financial health - investor quality vs peers
										$fh_iqlty = $row['fh_iqlty'];
										$fh_iqlty_avg = $row['fh_iqlty_avg'];
										$fh_iqlty_max = $row['fh_iqlty_max'];
										$fh_iqlty_score = $row['fh_iqlty_score'];
										if ($fh_iqlty>$fh_iqlty_avg) {
											$fh_iqlty_1 = intval($fh_iqlty_avg/$fh_iqlty_max*100);
											$fh_iqlty_3 = intval($fh_iqlty_score);
											$fh_iqlty_2 = intval($fh_iqlty_3-$fh_iqlty_1);
											$fh_iqlty_4 = 0;
										}
										if ($fh_iqlty<$fh_iqlty_avg) {
											$fh_iqlty_1 = intval($fh_iqlty_score);
											$fh_iqlty_3 = intval($fh_iqlty_score);
											$fh_iqlty_2 = 0;
											$fh_iqlty_4 = intval(($fh_iqlty_avg/$fh_iqlty_max*100)-3-$fh_iqlty_1);
										}
										//financial heatlh financing position vs. peers
										$fh_fpos = $row['fh_fpos'];
										$fh_fpos_avg = $row['fh_fpos_avg'];
										$fh_fpos_max = $row['fh_fpos_max'];
										$fh_fpos_score = $row['fh_fpos_score'];
										if ($fh_fpos>$fh_fpos_avg) {
											$fh_fpos_1 = intval($fh_fpos_avg/$fh_fpos_max*100);
											$fh_fpos_3 = intval($fh_fpos_score);
											$fh_fpos_2 = intval($fh_fpos_3-$fh_fpos_1);
											$fh_fpos_4 = 0;
										}
										if ($fh_fpos<$fh_fpos_avg) {
											$fh_fpos_1 = intval($fh_fpos_score);
											$fh_fpos_3 = intval($fh_fpos_score);
											$fh_fpos_2 = 0;
											$fh_fpos_4 = intval(($fh_fpos_avg/$fh_fpos_max*100)-3-$fh_fpos_1);
										}
										//financial health financing position vs industry
										$fh_fposi = $row['fh_fposi'];
										$fh_fposi_avg = $row['fh_fposi_avg'];
										$fh_fposi_max = $row['fh_fposi_max'];
										$fh_fposi_score = $row['fh_fposi_score'];
										if ($fh_fposi>$fh_fposi_avg) {
											$fh_fposi_1 = intval($fh_fposi_avg/$fh_fposi_max*100);
											$fh_fposi_3 = intval($fh_fposi_score);
											$fh_fposi_2 = intval($fh_fposi_3-$fh_fposi_1);
											$fh_fposi_4 = 0;
										}
										if ($fh_fposi<$fh_fposi_avg) {
											$fh_fposi_1 = intval($fh_fposi_score);
											$fh_fposi_3 = intval($fh_fposi_score);
											$fh_fposi_2 = 0;
											$fh_fposi_4 = intval(($fh_fposi_avg/$fh_fposi_max*100)-3-$fh_fposi_1);
										}
										//financial health burn score
										$fh_burn = $row['fh_burn'];
										$fh_burn_avg = $row['fh_burn_avg'];
										$fh_burn_max = $row['fh_burn_max'];
										$fh_burn_min = $row['fh_burn_min'];
										$fh_burn_score = $row['fh_burn_score'];
										// momentum scocial media
										$mm_sm = $row['mm_sm'];
										$mm_sm_avg = $row['mm_sm_avg'];
										$mm_sm_max = $row['mm_sm_max'];
										$mm_sm_min = $row['mm_sm_min'];
										$mm_sm_score = $row['mm_sm_score'];
										if ($mm_sm>$mm_sm_avg) {
											$mm_sm_1 = intval($mm_sm_avg/$mm_sm_max*100);
											$mm_sm_3 = intval($mm_sm_score);
											$mm_sm_2 = intval($mm_sm_3-$mm_sm_1);
											$mm_sm_4 = 0;
										}
										if ($mm_sm<$mm_sm_avg) {
											$mm_sm_1 = intval($mm_sm_score);
											$mm_sm_3 = intval($mm_sm_score);
											$mm_sm_2 = 0;
											$mm_sm_4 = intval(($mm_sm_avg/$mm_sm_max*100)-3-$mm_sm_1);
										}
										// momentum partnerships
										$mm_pm = $row['mm_pm'];
										$mm_pm_avg = $row['mm_pm_avg'];
										$mm_pm_max = $row['mm_pm_max'];
										$mm_pm_min = $row['mm_pm_min'];
										$mm_pm_score = $row['mm_pm_score'];
										if ($mm_pm>$mm_pm_avg) {
											$mm_pm_1 = intval($mm_pm_avg/$mm_pm_max*100);
											$mm_pm_3 = intval($mm_pm_score);
											$mm_pm_2 = intval($mm_pm_3-$mm_pm_1);
											$mm_pm_4 = 0;
										}
										if ($mm_pm<$mm_pm_avg) {
											$mm_pm_1 = intval($mm_pm_score);
											$mm_pm_3 = intval($mm_pm_score);
											$mm_pm_2 = 0;
											$mm_pm_4 = intval(($mm_pm_avg/$mm_pm_max*100)-3-$mm_pm_1);
										}
										// momentum employment
										$mm_em = $row['mm_em'];
										$mm_em_avg = $row['mm_em_avg'];
										$mm_em_max = $row['mm_em_max'];
										$mm_em_min = $row['mm_em_min'];
										$mm_em_score = $row['mm_em_score'];
										if ($mm_em>$mm_em_avg) {
											$mm_em_1 = intval($mm_em_avg/$mm_em_max*100);
											$mm_em_3 = intval($mm_em_score);
											$mm_em_2 = intval($mm_em_3-$mm_em_1);
											$mm_em_4 = 0;
										}
										if ($mm_em<$mm_em_avg) {
											$mm_em_1 = intval($mm_em_score);
											$mm_em_3 = intval($mm_em_score);
											$mm_em_2 = 0;
											$mm_em_4 = intval(($mm_em_avg/$mm_em_max*100)-3-$mm_em_1);
										}
										// momentum news
										$mm_nm = $row['mm_nm'];
										$mm_nm_avg = $row['mm_nm_avg'];
										$mm_nm_max = $row['mm_nm_max'];
										$mm_nm_min = $row['mm_nm_min'];
										$mm_nm_score = $row['mm_nm_score'];
										if ($mm_nm>$mm_nm_avg) {
											$mm_nm_1 = intval($mm_nm_avg/$mm_nm_max*100);
											$mm_nm_3 = intval($mm_nm_score);
											$mm_nm_2 = intval($mm_nm_3-$mm_nm_1);
											$mm_nm_4 = 0;
										}
										if ($mm_nm<$mm_nm_avg) {
											$mm_nm_1 = intval($mm_nm_score);
											$mm_nm_3 = intval($mm_nm_score);
											$mm_nm_2 = 0;
											$mm_nm_4 = intval(($mm_nm_avg/$mm_nm_max*100)-3-$mm_nm_1);
										}
										// AI sector score
										$ai_s = $row['ai_s'];
										$ai_s_max = $row['ai_s_max'];
										$ai_s_score = $row['ai_s_score'];
										// AI focus score
										$ai_f = $row['ai_f'];
										$ai_f_avg = $row['ai_f_avg'];
										$ai_f_max = $row['ai_f_max'];
										$ai_f_min = $row['ai_f_min'];
										$ai_f_score = $row['ai_f_score'];
										// AI growth potential score
										$ai_gp_fund = $row['ai_gp_fund'];
										$ai_gp_fund_comp = $row['ai_gp_fund_comp'];
										$ai_gp_fund_score = $row['ai_gp_fund_score'];
										$ai_gp_num_comp = $row['ai_gp_num_comp'];
										$ai_gp_num_score = $row['ai_gp_num_score'];
										$ai_gp_score = $row['ai_gp_score'];
										// AI competence score
										$ai_c_pat = $row['ai_c_pat'];
										$ai_c_pat_peers_avg = $row['ai_c_pat_peers_avg'];
										$ai_c_pat_peers_max = $row['ai_c_pat_peers_max'];
										$ai_c_pat_peers_min = $row['ai_c_pat_peers_min'];
										$ai_c_pat_peers_score = $row['ai_c_pat_peers_score'];
										if ($ai_c_pat_peers_score>100) {$ai_c_pat_peers_score=100;}
									
								}
								
								echo '
								<div class="row">

								<div class="col-md-3" align="center">
								<h6>MARKET ENVIRONMENT SCORE</h6>
								<div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="100" data-percent="'.intval($me_score/10).'" data-width="10" data-animate="1700">
									<span class="fs-30">
										<span class="countTo" data-speed="1700">'.intval($me_score).'</span>
									</span>
								</div>
								</div>

								<div class="col-md-3" align="center">
								<h6>FINANCIAL HEALTH SCORE</h6>
								<div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="100" data-percent="'.intval($fh_score/10).'" data-width="10" data-animate="1700">
									<span class="fs-30">
										<span class="countTo" data-speed="1700">'.intval($fh_score).'</span>
									</span>
								</div>
								</div>

								<div class="col-md-3" align="center">
								<h6>MOMENTUM SCORE</h6>
								<div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="100" data-percent="'.intval($m_score/10).'" data-width="10" data-animate="1700">
									<span class="fs-30">
										<span class="countTo" data-speed="1700">'.intval($m_score).'</span>
									</span>
								</div>
								</div>

								<div class="col-md-3" align="center">
								<h6>ARTIFICIAL INTELLIGENCE SCORE</h6>
								<div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="100" data-percent="'.intval($ai_score/10).'" data-width="10" data-animate="1700">
									<span class="fs-30">
										<span class="countTo" data-speed="1700">'.intval($ai_score).'</span>
									</span>
								</div>
								<br><br>
								</div>

								</div>


								<div class="row">

								<div class="col-md-3">
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($s_fm_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">SECTOR FINANCING MOMENTUM <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="The funding momentum expresses the current funding momentum strength in the segment, based on 2-Quarter rolling mean, with the current quarter mean compared to the previous quarter mean"></i></p>
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($s_em_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">SECTOR EXIT MOMENTUM <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="The exit momentum expresses the current exit momentum strength in the segment, based on 2-Quarter rolling mean, with the current quarter mean compared to the previous quarter mean"></i></p>
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($s_iqlty_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">SECTOR INVESTOR QUALITY <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="The sector investor quality expresses the occurance of top investors in this segment, compared to the occurance of top investors in the entire industry. It provides a good indication if the sector is hot for top investors currently. The occurance is the average number of top investors per company in the peer group or in the entire industry."></i></p>

									<div class="progress">
										<div class="progress-bar" style="width:'.intval($s_iqtty_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">SECTOR INVESTOR QUANTITY <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="Sector Investor Quantity compares the average number of investors in a company of peers vs. the entire industry. A lower number of peers than the industry means that typically companies in this sector have less investors than the industry average. This is an indication that this sector is proportionally less attractive for investors. A higher number of peers than the industry means that typically companies in this sector have more investors than the industry average. This is an indication that this sector is proportionally more attractive for investors."></i></p>

								</div>

								<div class="col-md-3">
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($fh_iqlty_1).'%; background-color:#D3D3D3"></div>
										<div class="progress-bar" style="width:'.intval($fh_iqlty_2).'%; background-color:#E5E5E5"></div>
										<div class="progress-bar" style="width:3%; background-color:#2980b9"></div>
										<div class="progress-bar" style="width:'.intval($fh_iqlty_4).'%; background-color:#D3D3D3"></div>
									</div>
									<p class="font-lato fs-10">INVESTORS QUALITY VS. PEERS <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="Investor Quality is evaluated by the number of top investors invested in a specific sector or industry. This metric compares the investor quality of the company (=number of top investors invested in the company) with the average number of top investors per company in the peer group. A higher number shows that the company was able to attract more top investors than its peers."></i></p>
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($fh_fpos_1).'%; background-color:#D3D3D3"></div>
										<div class="progress-bar" style="width:'.intval($fh_fpos_2).'%; background-color:#E5E5E5"></div>
										<div class="progress-bar" style="width:3%; background-color:#2980b9"></div>
										<div class="progress-bar" style="width:'.intval($fh_fpos_4).'%; background-color:#D3D3D3"></div>
									</div>
									<p class="font-lato fs-10">FINANCING POSITION VS. PEERS <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses how well the company is funded compared to its peers. The average total amount of funding (USD) of the peers is compared with the companies total amount of funding (USD). This provides a good indication if the company is in a better financial / funding position than the peers."></i></p>
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($fh_fposi_1).'%; background-color:#D3D3D3"></div>
										<div class="progress-bar" style="width:'.intval($fh_fposi_2).'%; background-color:#E5E5E5"></div>
										<div class="progress-bar" style="width:3%; background-color:#2980b9"></div>
										<div class="progress-bar" style="width:'.intval($fh_fposi_4).'%; background-color:#D3D3D3"></div>
									</div>
									<p class="font-lato fs-10">FINANCING POSITION VS. INDUSTRY <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses how well the company is funded compared to the industry. The average total amount of funding (USD) of the industry is compared with the companies total amount of funding (USD). This provides a good indication if the company is in a better financial / funding position than the industry."></i></p>

									<div class="progress">
										<div class="progress-bar" style="width:'.intval($fh_burn_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">BURN SCORE <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="The burn rate score expresses the financial health of the company and vs. its peers, capped at a one year window. The higher the value, the better it is. A burn rate score of 100 means that the company has funds to operate for more than one year without requiring additional funding. A burn rate score of 0 means that the company urgently needs additional funding."></i></p>
									
								</div>

								<div class="col-md-3">
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($mm_sm_1).'%; background-color:#D3D3D3"></div>
										<div class="progress-bar" style="width:'.intval($mm_sm_2).'%; background-color:#E5E5E5"></div>
										<div class="progress-bar" style="width:3%; background-color:#2980b9"></div>
										<div class="progress-bar" style="width:'.intval($mm_sm_4).'%; background-color:#D3D3D3"></div>
									</div>
									<p class="font-lato fs-10">SOCIAL MEDIA MOMENTUM VS. PEERS <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This metric expresses the social media momentum of the company versus its peers. The mothly growth rate of the company is compared with the average monthly growth rate if its peers. A higher number indicates that the company has stronger monthly growth than its peers. A lower number indicates that the company has less monthly growth than its peers."></i></p>
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($mm_pm_1).'%; background-color:#D3D3D3"></div>
										<div class="progress-bar" style="width:'.intval($mm_pm_2).'%; background-color:#E5E5E5"></div>
										<div class="progress-bar" style="width:3%; background-color:#2980b9"></div>
										<div class="progress-bar" style="width:'.intval($mm_pm_4).'%; background-color:#D3D3D3"></div>
									</div>
									<p class="font-lato fs-10">PARTNERSHIP MOMENTUM VS. PEERS <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This metric expresses the partnership momentum of the company versus its peers. The mothly growth rate of the company is compared with the average monthly growth rate if its peers. A higher number indicates that the company has stronger monthly growth than its peers. A lower number indicates that the company has less monthly growth than its peers."></i></p>
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($mm_em_1).'%; background-color:#D3D3D3"></div>
										<div class="progress-bar" style="width:'.intval($mm_em_2).'%; background-color:#E5E5E5"></div>
										<div class="progress-bar" style="width:3%; background-color:#2980b9"></div>
										<div class="progress-bar" style="width:'.intval($mm_em_4).'%; background-color:#D3D3D3"></div>
									</div>
									<p class="font-lato fs-10">EMPLOYMENT MOMENTUM VS. PEERS <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This metric expresses the employement momentum of the company versus its peers. The employment growth rate of the company is compared with the average growth rate if its peers. A higher number indicates that the company has stronger monthly growth than its peers. A lower number indicates that the company has less monthly growth than its peers."></i></p>

									<div class="progress">
										<div class="progress-bar" style="width:'.intval($mm_nm_1).'%; background-color:#D3D3D3"></div>
										<div class="progress-bar" style="width:'.intval($mm_nm_2).'%; background-color:#E5E5E5"></div>
										<div class="progress-bar" style="width:3%; background-color:#2980b9"></div>
										<div class="progress-bar" style="width:'.intval($mm_nm_4).'%; background-color:#D3D3D3"></div>
									</div>
									<p class="font-lato fs-10">NEWS MOMENTUM VS. PEERS <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This metric expresses the news momentum of the company versus its peers. The news growth rate of the company is compared with the average monthly growth rate if its peers. A higher number indicates that the company has stronger monthly growth than its peers. A lower number indicates that the company has less monthly growth than its peers."></i></p>
									
								</div>

								<div class="col-md-3">
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($ai_s_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">AI SECTOR SCORE <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This metric expresses how strong the sector is, from an expert point of view. Has the sector been identified as one of the hottest segments in AI? Is the sector adressing a game changing topic? The AI Sector Score is a qualitative measurement and is defined by our human experts. The decision is made based on analysis of the companies business model, its products and technologies. The higher the AI Sector Score, the stronger is the sector in terms of future growth potential."></i></p>
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($ai_f_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">AI FOCUS SCORE <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This metric expresses how the company is focused on AI. Is it just a little segment of its competences? Or is it the core of the business? The AI Focus Score is a qualitative measurement and is defined by our human experts. The decision is made based on analysis of the companies business model, its products and technologies. The higher the AI Focus Score, the more focus the company has on AI. The quantitative measurement is based on the number of sub-categories the company is operating in, which expresses how focused the company is."></i></p>
									
									<div class="progress">
										<div class="progress-bar" style="width:'.intval($ai_gp_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">AI GROWTH POTENTIAL SCORE <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This metric expresses the degree of growth potential by using AI. How big can the AI based revenue grow from there? How saturated is the market already? The AI Growth Potential Score is a qualitative measurement and is definied by our human experts. The decision is made based on analysis of the companies business model, itss products and technologies, its uniqueness, its competitors, etc. The higher the AI Growth Potential Score, the more growth potential has this company.The quantitative measurement is based on the companies position in its competitive ecosystem."></i></p>

									<div class="progress">
										<div class="progress-bar" style="width:'.intval($ai_c_pat_peers_score).'%; background-color:#2980b9"></div>
									</div>
									<p class="font-lato fs-10">AI COMPETENCE SCORE <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="The AI Competence Score is a qualitative measurement and is definied by our human experts. The decision is made based on analysis of the companies  patent filings, its number of scientists working on AI, its core technologies, the amount of research papers published and so on. The higher the AI Competence Score, the more competence has this company in AI. The quantitaive measurement is the patent grant ranking of the company, vs. the average of its peers on a scale from none to the hightest number of patents granted of the peers."></i></p>
									
								</div>

								</div>


							';

							//analysis in writing:
					echo '<h4>'.$name."'s Market Environment</h4>";

					echo '<p>'.$name.' is active in the sectors '.$category.'. It is operating in an evironment with a ';
					$ana = $s_fm_score; $ana_s = '';
					if ($ana>=0)  {$ana_s='very low'; 
						$ana_s_2 = 'the amount of venture capital fundings in this sector has been significantly declining recently. This makes it sigificantly harder for the company to attract capital and raise additional funds.';}
					if ($ana>20) {$ana_s='low'; 
						$ana_s_2 = 'the amount of venture capital fundings in this sector has been declining recently. This makes it harder for the company to attract capital and raise additional funds.';}
					if ($ana>40) {$ana_s='medium'; 
						$ana_s_2 = 'the amount of venture capital fundings in this sector is steady currently. This shows continous interest, but not growing interest in this sector.';}
					if ($ana>65) {$ana_s='high'; 
						$ana_s_2 = 'the amount of venture capital fundings in this sector has been increasing recently. This shows increasing interest in this sector which makes it easier for the company to attract capital and raise additional funds.';}
					if ($ana>85) {$ana_s='very high'; 
						$ana_s_2 = 'the amount of venture capital fundings in this sector has been increasing signifcantly recently. This shows significant interest in this sector, which makes it easier for the company to attract capital and raise additional funds.';}
					echo $ana_s;
					echo ' financing momentum, which means that '.$ana_s_2;

					$ana = $s_em_score; $ana_s = '';
					if ($ana>=0)  {$ana_s='The exit momentum in the sector is currently at a very low level, which means that the amount of M&A transactions has been declining recently.'; }
					if ($ana>20) {$ana_s='The exit momentum in the sector is currently at a low level, which means that the amount of M&A transactions has been declining recently.';}
					if ($ana>40) {$ana_s='The exit momentum in the sector is currently steady, which means that the amount of M&A transactions has been constant recently.';}
					if ($ana>65) {$ana_s='The exit momentum in the sector is currently at a high level, which means that the amount of M&A transactions has been increasing recently.';}
					if ($ana>85) {$ana_s='The exit momentum in the sector is currently at a very high level, which means that the amount of M&A transactions has been increasing significantly recently.';}
					echo ' '.$ana_s;
					echo '</p>';

					$ana = $s_iqlty_score; $ana_s = '';
					if ($ana>=0)  {$ana_s='Investor quality in the sector is currently very low, which means that the number of top quality investors (with more than 50 exits) is very low in this sector compared to the average in the entire Artificial Intelligence segment. This is an indication that tier-1 investors are currently usually not investing in this space.'; }
					if ($ana>20) {$ana_s='Investor quality in the sector is currently low, which means that the number of top quality investors (with more than 50 exits) is low in this sector compared to the average in the entire Artificial Intelligence segment. This is an indication that tier-1 investors are currently only sometimes investing in this space.';}
					if ($ana>40) {$ana_s='Investor quality in the sector is currently medium, which means that the number of top quality investors (with more than 50 exits) is equal in this sector compared to the average in the entire Artificial Intelligence segment. This is an indication that tier-1 investors are currently investing in this space.';}
					if ($ana>65) {$ana_s='Investor quality in the sector is currently high, which means that the number of top quality investors (with more than 50 exits) is high in this sector compared to the average in the entire Artificial Intelligence segment. This is an indication that tier-1 investors are currently investing in this space.';}
					if ($ana>85) {$ana_s='Investor quality in the sector is currently very high, which means that the number of top quality investors (with more than 50 exits) is very high in this sector compared to the average in the entire Artificial Intelligence segment. This is an indication that tier-1 investors are currently heavily investing in this space.';}
					echo '<p>'.$ana_s;

					$ana = $s_iqtty_score; $ana_s = '';
					if ($ana>=0)  {$ana_s='The investor quantity in the sector is currently very low, which means that the average number of investors is very low in this sector compared to the average in the entire Artificial Intelligence segment. It is currently very hard to attract investors when being active in this sector.'; }
					if ($ana>20) {$ana_s='The investor quantity in the sector is currently low, which means that the average number of investors is low in this sector compared to the average in the entire Artificial Intelligence segment. It is currently hard to attract investors when being active in this sector.';}
					if ($ana>40) {$ana_s='The investor quantity in the sector is currently average, which means that the average number of investors is equal in this sector compared to the average in the entire Artificial Intelligence segment. It is currently very possible to attract investors when being active in this sector.';}
					if ($ana>65) {$ana_s='The investor quantity in the sector is currently high, which means that the average number of investors is high in this sector compared to the average in the entire Artificial Intelligence segment. It is currently relatively easy to attract investors when being active in this sector.';}
					if ($ana>85) {$ana_s='The investor quantity in the sector is currently very high, which means that the average number of investors is very high in this sector compared to the average in the entire Artificial Intelligence segment. It is currently relatively very easy to attract investors when being active in this sector.';}
					echo ' '.$ana_s;
					echo '</p>';

					echo '<h4>'.$name."'s Financial Health</h4>";

					$ana = $fh_iqlty; $ana_s = '';
					if ($ana==0)  {$ana_s='Currently no top investors are invested in '.$name.','; }
					if ($ana==1) {$ana_s='Currently one top investors are invested in '.$name.',';}
					if ($ana>1) {$ana_s='Currently '.$ana.' top investors are invested in '.$name.',';}
					echo '<p>'.$ana_s;

					$ana = $fh_iqlty; $ana_s = '';
					if ($ana<$fh_iqlty_avg)  {$ana_s='which is less than the average of its peers. This implicates that its peers will have better access to future funding rounds and liquidity.'; }
					if ($ana==$fh_iqlty_avg)  {$ana_s='which is equal to the average of its peers. This implicates that '.$name.' is equally good positioned to raise future fundings and obtain liquidity.'; }
					if ($ana>$fh_iqlty_avg)  {$ana_s='which is more than the average of its peers. This implicates that '.$name.' has a clear advantage by having excellent access to future funding and to obtaining liquidity.'; }
					echo ' '.$ana_s;

					$ana = $fh_iqlty; $ana_s = '';
					if ($ana<$fh_iqlty_max)  {$ana_s='One of its peers has received funding from '.$fh_iqlty_max.' top investors, making '.$name.' being in a less favorable funding position that the other peer.'; }
					if ($ana==$fh_iqlty_max)  {$ana_s=$name.' has the highest number of top investors, which means that it has been the most attractive investment target in its peer-group.'; }
					echo ' '.$ana_s;
					echo '</p>';

					//
					$ana = $fh_fpos; $ana_s = '';
					if ($ana==0)  {$ana_s=$name.' has no recorded funding rounds and is self funded,'; }
					if ($ana>0) {$ana_s=$name.' has received total funding of $'.number_format($fh_fpos,0,",",".").' so far,';}
					echo '<p>'.$ana_s;
					if ($ana<$fh_fpos_avg) {$ana_s='which is less than the average amount of funding of its peers ($'.number_format($fh_fpos_avg,0,",",".").').';}
					if ($ana==$fh_fpos_avg) {$ana_s='which is equal than the average amount of funding of its peers ($'.number_format($fh_fpos_avg,0,",",".").').';}
					if ($ana>$fh_fpos_avg) {$ana_s='which is more than the average amount of funding of its peers ($'.number_format($fh_fpos_avg,0,",",".").').';}
					echo ' '.$ana_s;
					if ($ana<$fh_fpos_max) {$ana_s='One of its peers has even received $'.number_format($fh_fpos_max,0,",",".").' funding, which means '.$name.' has less financial backing than its largest peer.';};
					if ($ana==$fh_fpos_max) {$ana_s=$name.' is the company with the largest amount of funding in its peer group, which is making '.$name.' the strongest backed company.';};
					echo ' '.$ana_s;
					
					//
					$ana = $fh_fposi; $ana_s = '';
					if ($ana==0)  {$ana_s=$name.' has no recorded funding rounds and is self funded,'; }
					if ($ana>0) {$ana_s=$name.' has received total funding of $'.number_format($fh_fposi,0,",",".").' so far,';}
					echo 'Compared to the entire AI industry, '.$ana_s;
					if ($ana<$fh_fposi_avg) {$ana_s='which is less than the average amount of funding of the industry ($'.number_format($fh_fposi_avg,0,",",".").').';}
					if ($ana==$fh_fposi_avg) {$ana_s='which is equal than the average amount of funding of the industry ($'.number_format($fh_fposi_avg,0,",",".").').';}
					if ($ana>$fh_fposi_avg) {$ana_s='which is more than the average amount of funding of the industry ($'.number_format($fh_fposi_avg,0,",",".").').';}
					echo ' '.$ana_s;
					if ($ana<$fh_fposi_max) {$ana_s='One AI company has even received $'.number_format($fh_fposi_max,0,",",".").' funding, which means '.$name.' has less financial backing than the largest AI player.';};
					if ($ana==$fh_fposi_max) {$ana_s=$name.' is the company with the largest amount of funding in its entire industry, which is making '.$name.' the strongest backed company.';};
					echo ' '.$ana_s;
					echo '</p>';

					//
					$ana = $fh_burn_score; $ana_s = '';
					if ($ana>=0)  {$ana_s=$name.' is not well funded given the size, number of employees and burn rate. This indicates that the company will not be able to cover all expenses without raising additional funds in the future in the very short term.'; }
					if ($ana>20) {$ana_s=$name.' is not well funded given the size, number of employees and burn rate. This indicates that the company will not be able to cover all expenses without raising additional funds in the future.';}
					if ($ana>40) {$ana_s=$name.' is properly funded given the size, number of employees and burn rate. This indicates that the company will be able to cover all expenses for around half a year.';}
					if ($ana>65) {$ana_s=$name.' is very well funded given the size, number of employees and burn rate. This indicates that the company will be able to cover all expenses for almost one year.';}
					if ($ana>85) {$ana_s=$name.' is extremely well funded given the size, number of employees and burn rate. This indicates that the company will be able to cover all expenses for minimum one year.';}
					echo '<p>'.$ana_s;
					echo '</p>';

					echo '<h4>'.$name."'s Momentum</h4>";

					//
					$ana = $mm_sm; $ana_s = '';
					if ($ana==0)  {$ana_s=$name.' shows no significant social media traction,'; }
					if ($ana>0) {$ana_s=$name.' shows social media traction, ';}
					echo '<p>'.$ana_s;
					if ($ana<$mm_sm_avg) {$ana_s='which has been measured to be less than the average social media momentum of its peers.';}
					if ($ana==$mm_sm_avg) {$ana_s='which has been measured to be equal than the average social media momentum of its peers.';}
					if ($ana>$mm_sm_avg) {$ana_s='which has been measured to be stronger than the average social media momentum of its peers.';}
					echo ' '.$ana_s;
					
					//
					$ana = $mm_pm; $ana_s = '';
					if ($ana==0)  {$ana_s='Looking at partnership momentum, '.$name.' has no significant momentum,'; }
					if ($ana>0) {$ana_s='Looking at partnership momentum, '.$name.' has some momentum, ';}
					echo ' '.$ana_s;
					if ($ana<$mm_pm_avg) {$ana_s='which has been measured to be less than the average partnership momentum of its peers. This indicates that its peers are able to establish partnerships faster than '.$name.'.';}
					if ($ana==$mm_pm_avg) {$ana_s='which has been measured to be equal than the average partnership momentum of its peers. This indicates that its been able to establish partnerships equally than its peers.';}
					if ($ana>$mm_pm_avg) {$ana_s='which has been measured to be stronger than the average partnership momentum of its peers. This indicates that '.$name.' is been able to establish partnerships faster than its peers.';}
					echo ' '.$ana_s;
					echo '</p>';

					//
					$ana = $mm_em; $ana_s = '';
					if ($ana==0)  {$ana_s=$name.' shows no employment momentum.'; }
					if ($ana>0) {$ana_s=$name.' shows employment momentum.';}
					echo ' '.$ana_s;
					if ($ana<$mm_em_avg) {$ana_s='Compared to its peers, the company has less employment momentum than the average of its peers, which indicates that its peers are growing their number of employees faster.';}
					if ($ana==$mm_em_avg) {$ana_s='Compared to its peers, the company has equal employment momentum than the average of its peers, which indicates that the company is growing its number of employees equally fast than its peers.';}
					if ($ana>$mm_em_avg) {$ana_s='Compared to its peers, the company has more employment momentum than the average of its peers, which indicates that the company is growing its number of employees faster than its peers.';}
					echo ' '.$ana_s;
					
					//
					$ana = $mm_nm; $ana_s = '';
					if ($ana==0)  {$ana_s='It shows no news momentum.'; }
					if ($ana>0) {$ana_s='It  shows news momentum.';}
					echo ' '.$ana_s;
					if ($ana<$mm_em_avg) {$ana_s='Compared to its peers, the company has less news momentum than the average of its peers, which indicates that its peers are has more traction in the news.';}
					if ($ana==$mm_em_avg) {$ana_s='Compared to its peers, the company has equal news momentum than the average of its peers, which indicates that the company is having equal traction in the news than its peers.';}
					if ($ana>$mm_em_avg) {$ana_s='Compared to its peers, the company has more news momentum than the average of its peers, which indicates that the company is having more traction in the news than its peers.';}
					echo ' '.$ana_s;
					echo '</p>';
					
					echo '<h4>'.$name."'s Artificial Intelligence Scores</h4>";

					//
					$ana = $ai_s_score; $ana_s = '';
					if ($ana>=0)  {$ana_s=$name.' has an extremely low AI Sector Score. This implicates that the sector, in which the company is operating in, has been identified by experts as a very low rated sector in the field of Artificial Intelligence. It is operating in a challenging sector in AI, where the company is not getting a lot of market support.'; }
					if ($ana>20) {$ana_s=$name.' has a low AI Sector Score. This implicates that the sector, in which the company is operating in, has been identified by experts as a low rated sector in the field of Artificial Intelligence. It is operating in a challenging sector in AI, where the company is not getting a lot of market support.'; }
					if ($ana>40) {$ana_s=$name.' has a medium AI Sector Score. This implicates that the sector, in which the company is operating in, has been identified by experts as a medium rated sector in the field of Artificial Intelligence. It is operating in a healthy segments in AI, where the company is getting some tailwind from the market.'; }
					if ($ana>65) {$ana_s=$name.' has a high AI Sector Score. This implicates that the sector, in which the company is operating in, has been identified by experts as a high rated sector in the field of Artificial Intelligence. It is operating in one of the hottest segments in AI, where the company is getting a lot of tailwind from the market.'; }
					if ($ana>85) {$ana_s=$name.' has an extremely high AI Sector Score. This implicates that the sector, in which the company is operating in, has been identified by experts as a very high rated sector in the field of Artificial Intelligence. It is operating in one of the hottest segments in AI, where the company is getting a lot of tailwind from the market.'; }
					echo '<p>'.$ana_s;

					//
					$ana = $ai_f_score; $ana_s = '';
					if ($ana>=0)  {$ana_s='An analysis of its business model led to the opinion that '.$name.' is not entirely focused on its Artificial Intelligence technology, making this company not a pure AI player with its products not being built around AI as its core.'; }
					if ($ana>20) {$ana_s='An analysis of its business model led to the opinion that '.$name.' is not entirely focused on its Artificial Intelligence technology, making this company not a pure AI player with its products not being built around AI as its core.'; }
					if ($ana>40) {$ana_s='An analysis of its business model led to the opinion that '.$name.' is medium focused on its Artificial Intelligence technology, making this company a mixed AI player with its products not entirely being built around AI as its core.';  }
					if ($ana>65) {$ana_s='An analysis of its business model led to the opinion that '.$name.' is focused on its Artificial Intelligence technology, making this company a true AI player with its products being built around AI as its core.'; }
					if ($ana>85) {$ana_s='An analysis of its business model led to the opinion that '.$name.' is extremely focused on its Artificial Intelligence technology, making this company a true AI player with its products being built around AI as its core.'; }
					echo ' '.$ana_s;

					//
					$ana = $ai_gp_score; $ana_s = '';
					if ($ana>=0)  {$ana_s='The growth potential of its AI related products has been rated to be very low.'; }
					if ($ana>20) {$ana_s='The growth potential of its AI related products has been rated to be low.'; }
					if ($ana>40) {$ana_s='The growth potential of its AI related products has been rated to be high.';  }
					if ($ana>65) {$ana_s='The growth potential of its AI related products has been rated to be very high.'; }
					if ($ana>85) {$ana_s='The growth potential of its AI related products has been rated to be extremely high.'; }
					echo ' '.$ana_s;
					echo '</p>';

					//
					$ana = $ai_gp_score; $ana_s = '';
					if ($ana>=0)  {$ana_s='Looking at the number of patents filed, the strength, traction and importance of these patents, the number and strength of statistical papers issued by team members of '.$name.', the size of the scientific team and the technical sophistication of its technology and products, '.$name.' can be seen as a company with very low degree of competence in the area of Artificial Intelligence.'; }
					if ($ana>20) {$ana_s='Looking at the number of patents filed, the strength, traction and importance of these patents, the number and strength of statistical papers issued by team members of '.$name.', the size of the scientific team and the technical sophistication of its technology and products, '.$name.' can be seen as a company with a mediocre degree of competence in the area of Artificial Intelligence.'; }
					if ($ana>40) {$ana_s='Looking at the number of patents filed, the strength, traction and importance of these patents, the number and strength of statistical papers issued by team members of '.$name.', the size of the scientific team and the technical sophistication of its technology and products, '.$name.' can be seen as a company with a high degree of competence in the area of Artificial Intelligence.';  }
					if ($ana>65) {$ana_s='Looking at the number of patents filed, the strength, traction and importance of these patents, the number and strength of statistical papers issued by team members of '.$name.', the size of the scientific team and the technical sophistication of its technology and products, '.$name.' can be seen as a company with a very high degree of competence in the area of Artificial Intelligence.'; }
					if ($ana>85) {$ana_s='Looking at the number of patents filed, the strength, traction and importance of these patents, the number and strength of statistical papers issued by team members of '.$name.', the size of the scientific team and the technical sophistication of its technology and products, '.$name.' can be seen as a company with an extremely high degree of competence in the area of Artificial Intelligence.'; }
					echo '<p>'.$ana_s;

					echo '</p>';
					
					//end

						}
						?>
						
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>


					<!-- CHART -->
					<div class="card card-default" id="FUNDING">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-bar-chart"></i><strong> VALUATION, FUNDING & INVESTORS</strong></h5>
						</div>
						<div class="card-block">
							<table width="100%" border="0">
								<tr>
									<td width="38%" valign="top">
										<!-- CHART -->
										
										<div class="heading-title heading-border-bottom">
											<h6>REALTIME VALUATION</h6>
										</div>
										
										<div id="main" style="width: 500px;height:350px;"></div>
										
										
									</td>
									<td width="4%"></td>
									<td valign="top" width="48%">
										<!-- CURRENT VALUATION -->
										<?php
										$connection = mysqli_connect($host, $user, $pass, $db_name);
										//test if connection failed
										if(mysqli_connect_errno()){
						    				die("connection failed: "
								  		        . mysqli_connect_error()
						 				       . " (" . mysqli_connect_errno()
						 				       . ")");
											}
										$result = mysqli_query($connection,"
														SELECT Date, CONCAT(Close,' M') AS Valuation FROM 42_schema.STOCKS_TABLE
														where Symbol='$companysymbol'
														order by Date DESC
														limit 1");
										$all_property = array();  //declare an array for saving property
										while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
										while ($row = mysqli_fetch_array($result)) {
											$companyvaluationdate = $row['Date'];
											echo '<div class="heading-title heading-border-bottom">

											<h6>CURRENT VALUATION</h6></div>' . $row['Valuation'] . ' <p class="font-lato fs-11">(as of '. $companyvaluationdate . ')'   ;}
											
										?>
										<!-- TOTAL FUNDING -->
										<?php
										$connection = mysqli_connect($host, $user, $pass, $db_name);
										//test if connection failed
										if(mysqli_connect_errno()){
						    				die("connection failed: "
								  		        . mysqli_connect_error()
						 				       . " (" . mysqli_connect_errno()
						 				       . ")");
											}
										$result = mysqli_query($connection,"
														SELECT MAX(FUNDING_DATE) as Date, CONCAT(ROUND(SUM(FUNDING_AMOUNT/1000000),1),' M') AS totalfunding FROM 42_schema.FUNDING_TABLE
														where Symbol='$companysymbol'
														");
										$all_property = array();  //declare an array for saving property
										while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
										while ($row = mysqli_fetch_array($result)) {
											echo '<div class="heading-title heading-border-bottom">
											<h6>TOTAL FUNDING</h6></div>' . $row['totalfunding'] . ' <p class="font-lato fs-11">(as of '. $row['Date'] . ')'   ;}
										?>

										
										<!-- AI42 SCORE -->		
										<div class="heading-title heading-border-bottom">
										<h6>AI42 SCORE</h6></div><?php echo intval($total_score); ?><p class="font-lato fs-11">0 (weak) - 1,000 (strong)</p>
										</div>
										
										
									</td>
									</table>
										
									</td>
								</tr>
								<!-- CURRENT VALUATION AND INVESTOR STRENGTH -->
								<tr>
								<td width="38%" valign="top">
									<!-- FUNDING -->
										<div class="heading-title heading-border-bottom">
											<h6>FUNDING ROUNDS</h6>
										</div>
										<?php
										//create connection
										$connection = mysqli_connect($host, $user, $pass, $db_name);
										//test if connection failed
										if(mysqli_connect_errno()){
						    				die("connection failed: "
								  		        . mysqli_connect_error()
						 				       . " (" . mysqli_connect_errno()
						 				       . ")");
											}
										//get results from database
											// CONCAT(ROUND(SUM(FUNDING_AMOUNT) OVER (ORDER BY ID)/1000000,1),' M') AS 'Total Funding',
										$result = mysqli_query($connection,"
												select CONCAT(FUNDING_MONTH,'/',FUNDING_YEAR) as 'Date', FUNDING_ROUND as 'Round Series', 
												CONCAT(ROUND(FUNDING_AMOUNT/1000000,1),' M') as 'Round Amount', 
												FUNDING_AMOUNT_CURR as 'Currency', 
												CONCAT(ROUND(FUNDING_VALUATION/1000000,0),' M') as 'Valuation',
												FUNDING_INVESTORS as 'Investors', FUNDING_DATE  
												from FUNDING_TABLE 
 												where SYMBOL='$companysymbol'
 												ORDER BY FUNDING_DATE DESC 
												");

										$all_property = array();  //declare an array for saving property
										//showing property
										echo '<div class="table-responsive">
													<table class="table table-hover font-lato fs-12">
														<thead>
						        							<tr align="center">';  //initialize table tag
										while ($property = mysqli_fetch_field($result)) {
											if ($property->name<>'FUNDING_DATE'){
												echo '<th>' . $property->name . '</th>';  //get field name for header
												}
						    					array_push($all_property, $property->name);  //save those to array
											}
										echo '</thead>
												<tbody>'; //end tr tag
										//showing all data
										while ($row = mysqli_fetch_array($result)) {
						    				echo "<tr>";
						    					foreach ($all_property as $item) {
						    						if ($item<>'FUNDING_DATE'){
						    						echo '<td align="center">' . $row[$item] . '</td>'; //get items using property value
						    						}
						        				}
						    			//echo '</th';
						    			echo '</tr>';
										}
										?>
										<!-- END FUNDING -->
								</td>
								
								</tr>

							</table>

						<p class="font-lato fs-15" align="right">Something to add? <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="Every submission will be reviewed by our AI Market Intelligence Data team."></i>&nbsp;&nbsp;<a href="#"><button type="button" class="btn btn-primary btn-sm">Make a suggestion</button></a></p>

						</div>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>
					
					<!-- PRESENTATION MATERIAL -->
					<div class="card card-default" id="DECKS">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-television"></i><strong> PRESENTATION MATERIAL</strong></h5>
						</div>
						<div class="card-block">

						<div class="owl-carousel owl-padding-10 buttons-autohide controlls-over" data-plugin-options='{"singleItem": false, "items":"4", "autoPlay": 4000, "navigation": true, "pagination": false}'>
						<?php
						$apiurl = 'https://www.slideshare.net/api/2/';
						$apifunction =  'search_slideshows'; //'get_slideshows_by_tag';
						$ts = time();
						$apiKey = 'QS4cL6NX';
						$secret = 'oZW7NjPi';
						$hash = sha1($secret.$ts);
						$q1 = $companyname;
						$q2 = parse_url($companywebsite);  
						$q2 = $q2['host'];
						$q2 = preg_replace ("~^www\.~", "", $q2);
						$q = $q1 . ' company'; //. $q2;

						$url = $apiurl . $apifunction . '/?api_key=' . $apiKey . '&ts=' . $ts . '&hash=' . $hash . '&q=' . $q . '&page=1&what=tag&file_type=presentations';
						//$url = $apiurl . $apifunction . '/?api_key=' . $apiKey . '&ts=' . $ts . '&hash=' . $hash . '&tag=' . $q . '&limit=5';
						//echo $url;
						$xml = simplexml_load_file($url) or die("Datafeed not loading");
						foreach ($xml as $Slideshow_detail){
							$slide_title = $Slideshow_detail->Title;
							$slide_url =  $Slideshow_detail->URL;
							$slide_ThumbnailURL = $Slideshow_detail->ThumbnailXLargeURL; // ThumbnailURL;
							$embed_url = $Slideshow_detail->Embed;
							
							if (stripos($slide_title, $companyname . ' ' ) !== false) {
								//echo '<div class="img-hover"><figure>';
								if ($usertype<>2) { echo '<a href="' . $slide_url . '" target="_">'; } /// ---- PAID ONLY!
								echo '<img class="img" src="' . $slide_ThumbnailURL . '" alt="" height="150">';
								if ($usertype<>2) {echo '</a>';}
								//echo '</figure>';
								//echo '<h6 class="text-left mt-20">' . $slide_title . '</h6>';
								////echo '<p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in.</p>';
								//echo '</div>';
								}
						}

						?>
						</div>

						<?php if ($usertype==2) { echo '<p class="font-lato fs-15"><i class="fa fa-lock"></i> Downloading of presentation material is a premium feature and only available for subscribers. <a href="ai_analyst_subscription.php#subscribe">Subscribe now</a></p>'; } ?>

						<?php if ($usertype<>2) { echo 'Use the arrows to scroll left and right. Click on presentation to open.'; } ?>
						
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>

					<!-- NEWS -->
					<div class="card card-default" id="NEWS">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-newspaper-o"></i><strong> IN THE NEWS</strong></h5>
						</div>
						<div class="card-block">
							<?php
        					//Feed URLs "https://www.inoreader.com/stream/user/1004865403/tag/AI"
        					$queryurl = 'http://news.google.com/news?hl=en&gl=us&q=' . $companyname . '&um=1&ie=UTF-8&output=rss';
		        			$feeds = array($queryurl);
		        			//Read each feed's items
		        			$entries = array();
		        			foreach($feeds as $feed) {
		            			$xml = simplexml_load_file($feed);
		            			$entries = array_merge($entries, $xml->xpath("//item"));
		        			}
		        			//Sort feed entries by pubDate
		        			usort($entries, function ($feed1, $feed2) {
		            			return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
		        			});
		        			?>
		        			<div class="container">
		        			<div class="row">
		        			<?php
		        			$counter = 1;
		        			$counter2 = 1;
		        			$maxitems = 7;
		        			foreach($entries as $entry){
		        				if (stripos($entry->title, $companyname . ' ' ) !== false){
		        				if ($counter == 1) {echo('<div class="row">');}
			         			?>
		            			<div class="col-md-4">
									<div class="heading-title heading-border-bottom"><h6><?= strftime('%m/%d/%Y %I:%M %p', strtotime($entry->pubDate)) ?></h6></div>
		            				<a href="<?= $entry->link ?>" target="_"><h5><span><?= $entry->title ?></span></h5></a>
		            				<p><small><?= explode('</font><p>', $entry->description)[1] ?></small></p></td>
		            			</div>
		            			<?php
		            			if ($counter == 3) {
		        					echo('</div>');
		        					$counter = 0;
		        				}
								$counter = $counter + 1;
								$counter2 = $counter2 + 1;
								if ($counter2 == $maxitems) {
									echo '</div>';
		        					break;
		    						}
		        				}
		        				}
		        			$result->close();
            				$connection->next_result();
		        			?>
		        		</div>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>


					<!-- KEY PEOPLE -->
					<div class="card card-default" id="KEYPEOPLE">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-user"></i><strong> KEY PEOPLE</strong></h5>
						</div>
						<div class="card-block">
							<div class="row">
								<div class="col-md-6">
									<h6>FOUNDERS</h6>
									<p class="font-lato fs-13"> <?php echo nl2br($dealroom_founders);?> </p>
								</div>

								<div class="col-md-6">
									<h6>KEY INVESTORS</h6>
									<p class="font-lato fs-13"> <?php echo nl2br($topinvestors);?> </p>
								</div>
							</div>
						
						

						
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>

					<!-- TECHNOLOGY -->
					<div class="card card-default" id="TECHNOLOGY">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-cubes"></i><strong> TECHNOLOGY BACKGROUND</strong></h5>
						</div>
						<div class="card-block">
							<div class="row">
								<div class="col-md-3">
									<h6>PATENTS GRANTED</h6>
								</div>
								<div class="col-md-3">
									<p class="font-lato fs-13"><?php echo $patentsgranted;?> </p>
								</div>
								<div class="col-md-3">
									<h6>TRADEMARKS REGISTERED</h6>
								</div>
								<div class="col-md-3">
									<p class="font-lato fs-13"><?php echo $tmregistered;?> </p>
								</div>
								<div class="col-md-3">
									<h6>TOP PATENT CLASS</h6>
								</div>
								<div class="col-md-3">
									<p class="font-lato fs-13"><?php echo $patentclass;?> </p>
								</div>
								<div class="col-md-3">
									<h6>TOP TRADEMARK CLASS</h6>
								</div>
								<div class="col-md-3">
									<p class="font-lato fs-13"><?php echo $tmclass;?> </p>
								</div>
								<div class="col-md-3">
									<h6>IT SPENDING</h6>
								</div>
								<div class="col-md-3">
									<p class="font-lato fs-13"><?php echo number_format($itspend) . ' ' . $itspendcurr . '<br>(' . number_format($itspendusd) . ' USD)'  ;?> </p>
								</div>

								
							</div>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>

					<!-- WEBSITE AND MOBILE APP TRACTION -->
					<div class="card card-default" id="WEBTRACTION">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-bar-chart-o"></i><strong> WEBSITE AND MOBILE APP TRACTION</strong></h5>
						</div>
						<div class="card-block">

						<div class="row">
								<div class="col-md-3">
									<div class="table-responsive">
													<table class="table table-hover font-lato fs-12">
														<thead>
															<tr><th>VISITS</th><th>&nbsp;</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Monthly Visits</td>
																<td align="right"><?php echo $web_visits; ?></td>
															</tr>
															<tr>
																<td>Average Visits (6 months)</td>
																<td align="right"><?php echo $web_visits_avg; ?></td>
															</tr>
															<tr>
																<td>Monthly Visits Growth</td>
																<td align="right"><?php echo $web_visits_monthly_growth; ?></td>
															</tr>
															<tr>
																<td>Visit Duration</td>
																<td align="right"><?php echo $web_visits_duration; ?></td>
															</tr>
															<tr>
																<td>Visit Duration Growth</td>
																<td align="right"><?php echo $web_visits_duration_growth; ?></td>
															</tr>
														</tbody>
													</table>
									</div>
								</div>

								<div class="col-md-3">
									<div class="table-responsive">
													<table class="table table-hover font-lato fs-12">
														<thead>
															<tr><th>PAGE VIEWS</th><th>&nbsp;</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Page Views / Visit</td>
																<td align="right"><?php echo $web_pageviews_visit; ?></td>
															</tr>
															<tr>
																<td>Page Views / Visit Growth</td>
																<td align="right"><?php echo $web_pageviews_visit_growth; ?></td>
															</tr>
															<tr>
																<td>Bounce Rate</td>
																<td align="right"><?php echo $web_bouncerate; ?></td>
															</tr>
															<tr>
																<td>Bounce Rate Growth</td>
																<td align="right"><?php echo $web_bouncerate_growth; ?></td>
															</tr>
															
														</tbody>
													</table>
									</div>
								</div>

								<div class="col-md-3">
									<div class="table-responsive">
													<table class="table table-hover font-lato fs-12">
														<thead>
															<tr><th>RANKING</th><th>&nbsp;</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Global Traffic Rank</td>
																<td align="right"><?php echo $web_globalrank; ?></td>
															</tr>
															<tr>
																<td>Monthly Rank Change (#)</td>
																<td align="right"><?php echo $web_monthlyrank_change; ?></td>
															</tr>
															<tr>
																<td>Monthly Rank Growth</td>
																<td align="right"><?php echo $web_monthlyrank_growth; ?></td>
															</tr>
															
														</tbody>
													</table>
									</div>
								</div>

								<div class="col-md-3">
									<div class="table-responsive">
													<table class="table table-hover font-lato fs-12">
														<thead>
															<tr><th>MOBILE APPS</th><th>&nbsp;</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Number of Apps</td>
																<td align="right"><?php echo $apps_number; ?></td>
															</tr>
															<tr>
																<td>Downloads Last 30 Days</td>
																<td align="right"><?php echo $apps_downloads; ?></td>
															</tr>
															
														</tbody>
													</table>
									</div>
								</div>

								

									
								

						</div>


							
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>

								

							
								
								

					<!-- COMPETITION -->
					<div class="card card-default" id="COMPETITION">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-exchange"></i><strong> COMPETITION</strong></h5>
						</div>
						<div class="card-block">
						
						<?php 
						if ($usertype==2) {echo '
							<img src="assets/images/competition_locked.png" alt="" />
							<p class="font-lato fs-15"><i class="fa fa-lock"></i> This is a premium feature and only available for subscribers. <a href="ai_analyst_subscription.php#subscribe">Subscribe now</a></p>

							';}
						?>

							<?php 
							if ($usertype<>2) {
								// load competitors:
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
								$querystring = "CALL find_competitors('" . $companysymbol . "');";

								// now retrieve search results:
								$result = mysqli_query($connection, $querystring);

								$all_property = array();  //declare an array for saving property
								//showing property
								echo '<div class="table-responsive">
											<table class="table table-hover font-lato fs-12 table-light border">
												<thead>
													<tr>';  //initialize table tag
								while ($property = mysqli_fetch_field($result)) {
										if ($property->name<>'CB Rank (Company)')  {
											echo '<th>' . $property->name . '</th>';  //get field name for header
										}
										array_push($all_property, $property->name);  //save those to array
										}
								echo '<th>&nbsp;</th></thead>
										<tbody>'; //end tr tag
								//showing all data
								$entries = 0;
								while ($row = mysqli_fetch_array($result)) {
									echo "<tr>";
										foreach ($all_property as $item) {
											// website link:
											if ($item==='Website'){
												echo '<td><a href="' . $row[$item] . '" target="_">' . $row[$item] . '</a></td>'; //get items using property value
											}
											if ($item==='Symbol') {
								        							echo '<td><p class="font-lato fs-10"><b>' . $row[$item] . '</b></p></td>';
								        					} 
								        	if ($item==='Name') {
								        							echo '<td><b>' . $row[$item] . '</b></td>';
								        					} 
											// all other output:
											if (($item<>'CB Rank (Company)') && ($item<>'Website') && ($item<>'Symbol') && ($item<>'Name') ) {
												echo '<td>' . $row[$item] . '</td>'; //get items using property value
											}

										}

								if ($row['Ownership']=='PUBLIC') {echo '<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=' . $row[0] .' " class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></th';}

								if ($row['Ownership']<>'PUBLIC') {echo '<td><a href="ai_analyst_pe_companies_profile.php?symbol=' . $row[0] .' " class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></th';}
								echo '</tr>';
								// count number of entries:
								$entries = $entries + 1;

								}
								$result->close();
            					$connection->next_result();
								echo '</table>';

								}
							?>

							</div>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>

					<!-- MULTIPLES -->
					<div class="card card-default" id="MULTIPLES">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-sitemap"></i><strong> SECTOR MULTIPLES</strong></h5>
						</div>
						<div class="card-block">

						<?php 
						if ($usertype==2) {echo '
							<img src="assets/images/multiples_locked.png" alt="" />
							<p class="font-lato fs-15"><i class="fa fa-lock"></i> This is a premium feature and only available for subscribers. <a href="ai_analyst_subscription.php#subscribe">Subscribe now</a></p>

							';}
						?>

							<?php 
							if ($usertype<>2) {echo '
										<h6>TRANSACTION MULTIPLES</h6>
										<div class="table-responsive">
											<table class="table table-hover font-lato fs-12">
												<thead>
													<tr>
														<th>Name</th>
														<th>Transaction</th>
														<th>Firm value</th>
														<th>Date</th>
														<th>Location</th>
														<th>EV / LTM Sales</th>
														<th>EV / LTM Ebitda</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>FleetMatics</td>
														<td>$ 2.4 b</td>
														<td>€ 2 b</td>
														<td>Aug/2016</td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>Rolling Meadows</td>
														<td>8.4x</td>
														<td>24.9x</td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>Bureau van Dijk</td>
														<td>$ 3.3 b</td>
														<td>€ 3 b</td>
														<td>May/2017</td>
														<td>London</td>
														<td>11.6x</td>
														<td>22.7x</td>
													</tr>
													<tr>
														<td>SinnerSchrader</td>
														<td>€ 100 m</td>
														<td>€ 100 m</td>
														<td>Feb/2017</td>
														<td>Hamburg</td>
														<td>2.0x</td>
														<td>21.3x</td>
													</tr>
													<tr>
														<td>Next Generation Data - NGD</td>
														<td>£ 100 m</td>
														<td>£ 100 m</td>
														<td>Jul/2016</td>
														<td>Richmond</td>
														<td>8.9x</td>
														<td>20.8x</td>
													</tr>
													<tr>
														<td>CarTrawler</td>
														<td>€ 450 m</td>
														<td>€ 450 m</td>
														<td>Mar/2014</td>
														<td>Dublin</td>
														<td>0.9x</td>
														<td>20.6x</td>
													</tr>
												</tbody>
											</table>
										</div>

										<h6>TRADING MULTIPLES</h6>
										<div class="table-responsive">
											<table class="table table-hover font-lato fs-12">
												<thead>
													<tr>
														<th>Name</th>
														<th>Share Price</th>
														<th>Equity value</th>
														<th>Firm value</th>
														<th>EV/Revenue (2019)</th>
														<th>EV/Revenue (2020)</th>
														<th>EV/EBITDA (2019)</th>
														<th>EV/EBITDA (2020)</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Weborama</td>
														<td>€ 7.4</td>
														<td>€ 31.0 m</td>
														<td>-</td>
														<td>-</td>
														<td>0.8x</td>
														<td>6.0x</td>
														<td>4.8x</td>
														<td></td>
													</tr>
													<tr>
														<td>Ideagen</td>
														<td></td>
														<td>£ 285 m</td>
														<td>$ 5 m - $ 7 m</td>
														<td>6.1x</td>
														<td>5.1x</td>
														<td>20.2x</td>
														<td>15.8x</td>
													</tr>
													<tr>
														<td>Tobii Technology</td>
														<td>SEK 34.1</td>
														<td>SEK 3.4 b</td>
														<td>SEK 5.8 b</td>
														<td>2.1x</td>
														<td>1.9x</td>
														<td>72.1x</td>
														<td>24.7x</td>
													</tr>
													<tr>
														<td>RingCentral</td>
														<td>$ 103</td>
														<td>$ 8.3 b</td>
														<td>$ 790 m</td>
														<td>9.5x</td>
														<td>7.6x</td>
														<td>74.9x</td>
														<td>57.1x</td>
													</tr>
													<tr>
														<td>Q2</td>
														<td>$ 65.3</td>
														<td>$ 2.8 b</td>
														<td>$ 80 m - $ 120 m</td>
														<td>8.9x</td>
														<td>7.2x</td>
														<td>129.0x</td>
														<td>68.4x</td>
													</tr>
												</tbody>
											</table>
										</div>

										<h6>IPO MULTIPLES</h6>
										<div class="table-responsive">
											<table class="table table-hover font-lato fs-12">
												<thead>
													<tr>
														<th>Name</th>
														<th>Firm value</th>
														<th>EV/Revenue (2019)</th>
														<th>EV/Revenue (2020)</th>
														<th>EV/EBITDA (2019)</th>
														<th>EV/EBITDA (2020)</th>
														<th>IPO DATE</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Avast Software</td>
														<td>$ 4.0 b</td>
														<td>-</td>
														<td>-</td>
														<td>-</td>
														<td>-</td>
														<td>Apr/2018</td>
													</tr>
													<tr>
														<td>Oxatis</td>
														<td>€ 49.1 m</td>
														<td>0.5x</td>
														<td>0.6x</td>
														<td>-2.1x</td>
														<td>-8.0x</td>
														<td>Apr/2018</td>
													</tr>
													<tr>
														<td>DocuSign</td>
														<td>$ 4.5 b</td>
														<td>11.6x</td>
														<td>9.2x</td>
														<td>205.0x</td>
														<td>109.0x</td>
														<td>Apr/2018</td>
													</tr>
													<tr>
														<td>Pivotal</td>
														<td>$ 3.9 b</td>
														<td>7.1x</td>
														<td>5.7x</td>
														<td>-80.3x</td>
														<td>-218.0x</td>
														<td>Apr/2018</td>
													</tr>
													<tr>
														<td>Zuora</td>
														<td>$ 1.4 b</td>
														<td>10.2x</td>
														<td>8.2x</td>
														<td>-60.1x</td>
														<td>-62.9x</td>
														<td>Apr/2018</td>
													</tr>
												</tbody>
											</table>
										</div>

							';}
							?>


						
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>






					

					<hr>
				<p class="font-lato fs-15" align="right">Something to add? <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="Every submission will be reviewed by our AI Market Intelligence Data team."></i>&nbsp;&nbsp;<a href="#"><button type="button" class="btn btn-primary btn-sm">Make a suggestion</button></a></p>


				</div>
			</div>

				</div>
			</section>

			
				
			</div>
		</section>
	</div>



		</div>
		<!-- /wrapper -->

		
		

<!-- JAVASCRIPT FILES -->
		<script>var plugin_path = 'assets/plugins/';</script>
		<script src="assets/plugins/jquery/jquery-3.3.1.min.js"></script>

		<script src="assets/js/scripts.js"></script>

		<!-- REVOLUTION SLIDER -->
		<script src="assets/plugins/slider.revolution/js/jquery.themepunch.tools.min.js"></script>
		<script src="assets/plugins/slider.revolution/js/jquery.themepunch.revolution.min.js"></script>
		<script src="assets/js/view/demo.revolution_slider.js"></script>

		<?php

				// load data for chart:
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
				$result = mysqli_query($connection,"
								select 
								STOCKS_TABLE.Symbol, 
								DATE_FORMAT(STOCKS_TABLE.Date,'%Y-%m-%d') AS Date, 
								STOCKS_TABLE.Close, 
								STOCKS_TABLE.Volume
								FROM STOCKS_TABLE
								where STOCKS_TABLE.Symbol='$companysymbol' 
								and Volume = 0


								UNION

								SELECT 
								Symbol, 
								DATE_FORMAT(FUNDING_DATE,'%Y-%m-%d') AS Date,
								(SELECT Close from STOCKS_TABLE WHERE 
									STOCKS_TABLE.Symbol = FUNDING_TABLE.SYMBOL AND 
								    (STOCKS_TABLE.Date > DATE_SUB(FUNDING_TABLE.FUNDING_DATE, INTERVAL 3 DAY) 
								    AND STOCKS_TABLE.Date < DATE_ADD(FUNDING_TABLE.FUNDING_DATE , INTERVAL 3 DAY) )
								    LIMIT 1
								    )
								as Close,
								FUNDING_AMOUNT 
								FROM FUNDING_TABLE WHERE Symbol = '$companysymbol'

								ORDER BY Date ASC");



								#select SYMBOL, DATE_FORMAT(Date,'%Y-%m-%d') AS Date, Close, Volume 
								#FROM STOCKS_TABLE 
								#where SYMBOL='$companysymbol'");
				$all_property = array();  //declare an array for saving property
				//showing property
				while ($property = mysqli_fetch_field($result)) {
    					array_push($all_property, $property->name);  //save those to array
						}
				//showing all data
				$data = '[';
				$dates = '[';
				$volumes = '[';
				while ($row = mysqli_fetch_array($result)) {
					$data = $data . $row['Close'] . ',';
					$volumes = $volumes . $row['Volume']/1000000 . ',';
					$dates = $dates . '"' . $row['Date'] . '",';
					}
				$data = substr($data,0, -1);
				$data = $data . ']';
				$volumes = substr($volumes,0, -1);
				$volumes = $volumes . ']';
				$dates = substr($dates,0, -1);
				$dates = $dates . ']';




				//echo $data;
				//echo $dates;
				?>
    
			    <script type="text/javascript">
			        // based on prepared DOM, initialize echarts instance
			        var myChart = echarts.init(document.getElementById('main'));

			        var upColor = '#2980b9'; // '#00da3c';
			        var downColor = '#c0392b'; //'#ec0000';

			        
			        

		

			        //load data:
			        var data = <?php echo $data ?>;
			        var dates = <?php echo $dates ?>;
			        var volumes = <?php echo $volumes ?>;
			       

				    myChart.setOption(option = {
				        backgroundColor: '#ffffff', //#ffff #2c343c
				        animation: false,
				        title: {
				        text: '<?php echo $companysymbol;?>',
				        left: 0
				        },
				        legend: {
				            bottom: 10,
				            left: 'center',
				            data: ['<?php echo $companysymbol;?>', 'Funding']

				        },
				        
				        tooltip: {
				            trigger: 'item',
				            axisPointer: {
				                type: 'cross'
				            }},
				        
				      	xAxis: [
				            {
				                type: 'category',
				                data: dates,
				                scale: true,
				                boundaryGap : false,
				                axisLine: {onZero: false},
				                splitLine: {show: false},
				                splitNumber: 20,
				                min: 'dataMin',
				                max: 'dataMax',
				                axisLabel: {fontSize: 10},
				                axisPointer: {
				                    z: 100
				                }
				            },
				            
				        ],

				        yAxis: [{
        					type: 'value',
        					min: 'dataMin',
				            max: 'dataMax',
				            name: 'valuation',
				            nameLocation: 'middle',
				            nameTextStyle: {fontSize: 8},
				            axisLabel: {fontSize: 10},
    							},
								{
        					type: 'value',
        					min: 'dataMin',
				            max: 'dataMax',
				            name: 'funding',
				            nameLocation: 'middle',
				            nameTextStyle: {fontSize: 8},
				            axisLabel: {fontSize: 10},
    							}

    							],


    					series: [
        						{
        						name: '<?php echo $companysymbol;?>',
           						data: data,
            					type:'line',
            					
            					itemStyle: {
				                    normal: {
				                        color: upColor}}
            
            
        						},

        						

        						{
        						name: 'Funding',
           						data: volumes,
            					type:'bar',
            					barWidth: 15,
            					yAxisIndex:1,

            					label: {
                					show: true,
                					color: '#000000',
                					distance: 3,
                					position: 'top',
                					fontSize: 10,
					               	formatter: function(volumes) {
					               			if (volumes.value>0)
					                        	return volumes.value  + 'M' ;
					                        else
					                        	return '';
					                    }
					                },

            					itemStyle: {
				                    normal: {
				                        color: '#DCDCDC',
				                        barBorderColor: '#c8c8c8',
				                        barBorderWidth: 0
				                    }
				                    	}
            
            
        						}]	
				        
				    }, true);

				    
			
			     
			    </script>
		
		

		

		




</body>
</html>