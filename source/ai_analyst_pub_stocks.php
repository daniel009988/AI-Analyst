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
//abfrage der parameter:
$category = $_GET['category'];
if ($category == '') {$category = 'IT/PLATFORM/ENABLER';
				}

require_once '../psmw/shortcode.php';

$templates = json_decode(file_get_contents('../psmw/templates/templates.json'), TRUE);
$env = json_decode(file_get_contents('../psmw/config/env.json'), TRUE);
include 'include_menu.php';
?>


			<!-- Market -->
			

			<div class="container">
				<div class="container">
					<br>
				<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>Research Public AI Companies</h4>
					</div> 

				<!-- WELCOME TEXT -->
				<p class="font-lato fs-15">A compilation of all public listed companies which are specialised in or create real product value with Artificial Intelligence. The expert ratings summary expresses the strength in the different AI categories on a scale from zero to five. Use 'Profile' to open the profile page of the instrument, which contains OHLC charts, financial information, analyst opinions and detailed analytics from our experts.</p>

				
				<!-- LIST RESULTS -->
				<h5><span>Search: Category = <?php echo $category .'&nbsp;'?></span><a href="ai_analyst_pub_market_summary.php"><button type="button" class="btn btn-primary btn-sm">change search</button></a></h5>
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

				//retrieve portfolio items for selected user and portfolio:
				$result = mysqli_query($connection,"SELECT Symbol, Category, Name, `AI Sector`, `AI Focus`, `AI Strength`  FROM 42_schema.COMPANIES_TABLE WHERE Ownership = 'PUBLIC' AND Category='$category' ORDER BY `AI Strength` DESC");
				$all_property = array();  //declare an array for saving property
				//showing property
				echo '<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light border">
							<thead>
								<tr>';
				echo '<th>Symbol</th>';
				echo '<th>Name</th>';
				echo '<th>AI Sector<i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses the expected impact of AI technology in the specific sector"></i></th>';
				echo '<th>AI Focus<i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses the degree of focus on AI or AI related products of the company"></i></th>';
				echo '<th>AI Strength<i class="fa fa-info-circle text-info" data-toggle="tooltip" title="This indicator expresses the in-house AI expertise, the strength of the AI team and the defendability of its AI technology"></i></th>';
				echo '<th>&nbsp;</th>';
				echo '<th>&nbsp;</th>
				        </thead>
						<tbody>';

				while ($property = mysqli_fetch_field($result)) {
    					array_push($all_property, $property->name);  //save those to array
						}
				
				//showing all data
				while ($row = mysqli_fetch_array($result)) {
					echo '<tr>';
					echo '<td>' . $row['Symbol'] . '<br>' . $row['Category'] . '</td>';
					echo '<td>' . $row['Name'] .'';
					
					shortcode(['type' => 'single', 'symbol' => $row['Symbol'], 'template' => 'horizontal', 'color' => 'blue']);  
					echo '</td>';
					echo '<td><div class="rating rating-' . intval($row['AI Sector']) . ' fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>';
					echo '<td><div class="rating rating-' . intval($row['AI Focus']) . ' fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>';
					echo '<td><div class="rating rating-' . intval($row['AI Strength']) . ' fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>';
					
					echo '<td><a href="#" onclick="addFunction(';
					echo "'" . $row[Symbol] . "'";
					echo ')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>';
					// chart button:
					echo '<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=' . $row[Symbol] . '" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></td>';
					echo '</tr>';
					}
				echo '</tbody>
					</table>
						</div>';
				?>
				<hr>
				<p class="font-lato fs-15" align="right">Something to add? <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="Every submission will be reviewed by our AI Market Intelligence Data team."></i>&nbsp;&nbsp;<a href="#"><button type="button" class="btn btn-primary btn-sm">Make a suggestion</button></a></p>

			</section>

			
	</div>



		</div>
		<!-- /wrapper -->


		
<!-- function to add items to portfolio -->	
<script>
function addFunction($symbol) {	
    window.location.href = "ai_analyst_portfolios_add.php?symbol="+$symbol;
}
</script>

		

		




</body>
</html>