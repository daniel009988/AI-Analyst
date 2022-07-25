<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: '.'ai_analyst_login.php'); //not logged in
	}
 //Abfrage der Nutzer ID vom Login
$user_id = $_SESSION['userid'];
$pf_name = 'SIMULATED PORTFOLIO';
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
//abfrage der parameter:
$portfoliocheck = $_GET['portfoliocheck'];

//table pagination:
$page = $_GET['page'];
// if no page specified, start with page 1
if ($page == '') {$page = 1; } // if no page specified, start with page 1
// only paying users can swith:
if ($usertype==2) {$page = 1;} //free users will be forced to page 1



//include 'include_menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700" rel="stylesheet" type="text/css" />
	<!-- CORE CSS -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	
	<!-- THEME CSS -->
	<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/layout.css" rel="stylesheet" type="text/css" />

	
	
</head>


<body>

	
	<div class="container">
		<div class="container">
			<br>
			<!-- HEADER -->
			<div class="heading-title heading-border-bottom heading-color">
				<h4>Stock Portfolio Check (report created at <?php echo date('m/d/Y h:i:s a', time()); ?>)</h4>
			</div> 

			<p align="right"><a href="javascript:window.print();"><button type="button" class="btn btn-primary btn-sm">PRINT</button></a></p>

			<p>Your portfolio <?php echo $portfoliocheck; ?> has been analysed considering its AI ratings:</p>

			

			<?php
			//separate protfolio symbols:
			$stocksymbols = explode(",", $portfoliocheck);

			$querystring = "SELECT Symbol, Category, Name, `AI Sector`, `AI Focus`, `AI Strength`, ((`AI Sector`+ `AI Focus` + `AI Strength`)/3) as `AI Total Score` FROM COMPANIES_TABLE WHERE (Ownership = 'PUBLIC') AND (";
			foreach($stocksymbols as $element) {
				$querystring = $querystring . "Symbol ='" . str_replace(' ', '', $element) . "' OR ";
            	//echo $element . '<br>';
        	}
        	$querystring = rtrim($querystring, 'OR ');
        	$querystring = $querystring . ")";
			//echo $querystring;


			//display table:
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
			//retrieve portfolio items for selected user and portfolio:
			$result = mysqli_query($connection,$querystring);
			$all_property = array();  //declare an array for saving property
			//showing property
			echo '<div class="table-responsive">
					<table class="table font-lato fs-12 table-light border">
						<thead>
							<tr>';
			echo '<th>Symbol</th>';
			echo '<th>Current Stockprice<br>Comments</th>';
			echo '<th>AI-Sector<br><i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses the expected impact of AI technology in the specific sector"></i></th>';
			echo '<th>AI-Focus<br><i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses the degree of focus on AI or AI related products of the company"></i></th>';
			echo '<th>AI-Strength<br><i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses the in-house AI expertise, the strength of the AI team and the defendability of its AI technology"></i></th>';
			echo '<th>AI-Total<br><i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses the combined total AI score of the company"></i></th>';
			echo '<th>&nbsp;</th>
			        </thead>
					<tbody>';

			while ($property = mysqli_fetch_field($result)) {
					array_push($all_property, $property->name);  //save those to array
					}
			
			//showing all data
			$counter = 0;
			$totalaiscore = 0.00;
			$aicompanies = '';

			while ($row = mysqli_fetch_array($result)) {
				$counter = $counter + 1;
				$totalaiscore = $totalaiscore + $row['AI Total Score'];
				$aicompanies = $aicompanies . $row['Symbol'] . ',';
				echo '<tr valign="middle">';
				echo '<td><strong>' . $row['Name'] . '</strong><br>' . $row['Symbol'] . '<br>' . $row['Category'] . '</td>';
				echo '<td>';
				
				//shortcode(['type' => 'single', 'symbol' => $row['Symbol'], 'template' => 'horizontal', 'color' => 'blue']);  
				echo '</td>';
				echo '<td><div class="piechart" data-color="silver" data-trackcolor="rgba(0,0,0,0.04)" data-size="40" data-percent="'.intval($row['AI Sector']*20).'" data-width="3" data-animate="1700")>
									<span class="fs-12">
										<span class="countTo" data-speed="1700">'.intval($row['AI Sector']*20).'</span>
									</span>
								</div></td>';
				echo '<td><div class="piechart" data-color="silver" data-trackcolor="rgba(0,0,0,0.04)" data-size="40" data-percent="'.intval($row['AI Focus']*20).'" data-width="3" data-animate="1700">
									<span class="fs-12">
										<span class="countTo" data-speed="1700">'.intval($row['AI Focus']*20).'</span>
									</span>
								</div></td>';
				echo '<td><div class="piechart" data-color="silver" data-trackcolor="rgba(0,0,0,0.04)" data-size="40" data-percent="'.intval($row['AI Strength']*20).'" data-width="3" data-animate="1700">
									<span class="fs-12">
										<span class="countTo" data-speed="1700">'.intval($row['AI Strength']*20).'</span>
									</span>
								</div></td>';
				
				echo '<td><div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="50" data-percent="'.intval($row['AI Total Score']*20).'" data-width="5" data-animate="1700">
									<span class="fs-12">
										<span class="countTo" data-speed="1700">'.intval($row['AI Total Score']*20).'</span>
									</span>
								</div></td>';
				
				// profile button:
				echo '<td></td>';
				echo '</tr>';

				//best in class:
				//retrieve best in class for this:
				$result2 = mysqli_query($connection,"SELECT Symbol, Name, 
						((`AI Sector`+ `AI Focus` + `AI Strength`)/3) as `AI Total Score` 
						FROM COMPANIES_TABLE WHERE (Ownership = 'PUBLIC') 
						AND (Category ='".$row[Category]."')
						ORDER BY `AI Total Score` DESC LIMIT 1");
				$all_property2 = array();  //declare an array for saving property
				while ($property2 = mysqli_fetch_field($result2)) {array_push($all_property2, $property2->name);}
				while ($row2 = mysqli_fetch_array($result2)) {
				 	$top_symbol = $row2['Symbol'];
				 	$top_name = $row2['Name'];
				 	$top_score = $row2['AI Total Score']*20;
				}
				echo '<tr>';
				echo '<td></td>';
				if ($top_symbol<>$row[Symbol]){
					echo '<td><i class="fa fa-info-circle"></i> '.$row[Symbol].' is not top in its sector. Leading is:<br>'.$top_name.' ('.$top_symbol.') </td>';
				} 
				if ($top_symbol===$row[Symbol]){
					echo '<td><i class="fa fa-check"></i> '.$row[Symbol].' is top in its sector.</td>';
				} 
				echo '<td></td>';
				echo '<td></td>';
				echo '<td></td>';
				if ($top_symbol<>$row[Symbol]){
					echo '<td><div class="piechart" data-color="silver" data-trackcolor="rgba(0,0,0,0.04)" data-size="50" data-percent="'.intval($top_score).'" data-width="5" data-animate="1700">
									<span class="fs-12">
										<span class="countTo" data-speed="1700">'.intval($top_score).'</span>
									</span>
								</div></td>';
				}
				if ($top_symbol===$row[Symbol]){
					echo '<td></td>';
				}
				if ($top_symbol<>$row[Symbol]){
					echo '<td></td>';
				}
				if ($top_symbol===$row[Symbol]){
					echo '<td></td>';
				}
				echo '</tr>';

				}
			
			

			// sub:
			$subtotalaiscore = $totalaiscore / $counter;
			echo '<tr bgcolor="#F8F8F8">
				<td><strong>Sub total</h6></td><td><strong>AI related companies</strong></td> <td></td> <td></td> <td></td>';
			echo '<td><div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="50" data-percent="'.intval($subtotalaiscore*20).'" data-width="5" data-animate="1700">
									<span class="fs-12">
										<span class="countTo" data-speed="1700">'.intval($subtotalaiscore*20).'</span>
									</span>
								</div></td>';
			echo '<td>Sub total</td>
			</tr>';

			// all non AI companies (not in database:
			foreach($stocksymbols as $element) {
				if (strpos($aicompanies, str_replace(' ', '', $element))===false){
					$counter = $counter + 1;
					echo '<tr><td>'.$element .'</td>';
					echo '<td>';
					//shortcode(['type' => 'single', 'symbol' => str_replace(' ', '', $element), 'template' => 'horizontal', 'color' => 'blue']);  
					echo '</td>';
					echo '<td><div class="piechart" data-color="silver" data-trackcolor="rgba(0,0,0,0.04)" data-size="40" data-percent="0" data-width="3" data-animate="1700"><span class="fs-12"><span class="countTo" data-speed="1700">0</span></span></div></td>';
					echo '<td><div class="piechart" data-color="silver" data-trackcolor="rgba(0,0,0,0.04)" data-size="40" data-percent="0" data-width="3" data-animate="1700"><span class="fs-12"><span class="countTo" data-speed="1700">0</span></span></div></td>';
					echo '<td><div class="piechart" data-color="silver" data-trackcolor="rgba(0,0,0,0.04)" data-size="40" data-percent="0" data-width="3" data-animate="1700"><span class="fs-12"><span class="countTo" data-speed="1700">0</span></span></div></td>';
					echo '<td><div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="50" data-percent="0" data-width="5" data-animate="1700"><span class="fs-12"><span class="countTo" data-speed="1700">0</span></span></div></td>';
					echo '<td></td>';
					echo '</tr>';

				}	
        	}


			echo '<tr bgcolor="#F8F8F8"><td><strong>Sub total</h6></td><td><strong>Non AI related companies</strong></td> <td></td> <td></td> <td></td>';
			echo '<td><div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="50" data-percent="0" data-width="5" data-animate="1700">
									<span class="fs-12">
										<span class="countTo" data-speed="1700">0</span>
									</span>
								</div></td>';
			echo '<td>Sub total</td>
			</tr>';

			// total:
			$subtotalaiscore = $totalaiscore / $counter;
			echo '<tr bgcolor="#F8F8F8">
				<td><strong>Total</h6></td><td><strong>Your portfolio</strong></td> <td></td> <td></td> <td></td>';
			echo '<td><div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="50" data-percent="'.intval($subtotalaiscore*20).'" data-width="5" data-animate="1700">
									<span class="fs-12">
										<span class="countTo" data-speed="1700">'.intval($subtotalaiscore*20).'</span>
									</span>
								</div></td>';
			echo '<td><strong>AI Score<br>Your portfolio</strong></td>
			</tr>';

			// end of table:
			echo '</tbody>
				</table>
					</div>';

			?>

			<p class="font-lato fs-12"><strong>Notes:</strong><br>
			
			(i) The AI-Sector expresses the expected impact of AI technology in the specific sector, ranging from 0 (weak) to 100 (strongest)<br>
			(ii) The AI-Focus expresses the degree of focus on AI or AI related products of the company, ranging from 0 (weak) to 100 (strongest)<br>
			(iii) The AI-Strength expresses the in-house AI expertise, the strength of the AI team and the defendability of its AI technology, ranging from 0 (weak) to 100 (strongest)<br>
			(iv) The AI-Total Score expresses the combined total AI score of the company, ranging from 0 (weak) to 100 (strongest)<br>
			(v) Scoring is calculated based on quantitative metrics and qualitative expert ratings<br>

			</p>





		</div>
	</div>
			
		
		<!-- /wrapper -->

		<!-- SCROLL TO TOP -->
		<a href="#" id="toTop"></a>
		<!-- PRELOADER -->
		<div id="preloader">
			<div class="inner">
				<span class="loader"></span>
			</div>
		</div><!-- /PRELOADER -->


<!-- JAVASCRIPT FILES -->
		<script>var plugin_path = 'assets/plugins/';</script>
		<script src="assets/plugins/jquery/jquery-3.3.1.min.js"></script>

		<script src="assets/js/scripts.js"></script>

		<!-- REVOLUTION SLIDER -->
		<script src="assets/plugins/slider.revolution/js/jquery.themepunch.tools.min.js"></script>
		<script src="assets/plugins/slider.revolution/js/jquery.themepunch.revolution.min.js"></script>
		<script src="assets/js/view/demo.revolution_slider.js"></script>

		<!-- PAGE LEVEL SCRIPTS FOR DB QUERIES -->
		
		

		

		




</body>

</html>