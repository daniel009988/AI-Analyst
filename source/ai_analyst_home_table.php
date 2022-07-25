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



			
			<!-- Chart -->

			
			<div class="container">
				
					<div class="container">

					<!-- <h3><span>My Portfolios</span></h3>
					<hr>-->

					<!-- Chart container -->
					<br><br>
					

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

				//List of all ETFs:
				$result = mysqli_query($connection,"SELECT * FROM 42_schema.ETF_TABLE;");
				$all_property = array();  
				$etf_list = array(); # etf_list contains all ETFs
				array_push($etf_list, 'AI42X');
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				while ($row = mysqli_fetch_array($result)) {
					//echo '<th>' . $row['ETF_Symbol'] .'</th>';
					array_push($etf_list, $row['ETF_Symbol']);
					}
				$result->close();
            	$connection->next_result();
            	

				//Now loop through each ETF and retrieve performance figures:
				//foreach ($etf_list as $etf_item) {
				//	echo $etf_item;
				//}
				
				
				// Retrieve performance figures:
				$result = mysqli_query($connection,"CALL monthly_returns('AIQ');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				# table init:
				echo 
				'
				<h5>Monthly returns</h5>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th></th>';
				# table headers:
				while ($row = mysqli_fetch_array($result)) {
					echo '<th>' . $row['Date'] . '</th>';	
					}
				echo '</tr>
						</thead>
						<tbody>';

				# table content:
				echo '<tr>
						<td>' . $etf_list[1] . '</td>';
				foreach ($result as $row) {
				//while ($row = mysqli_fetch_array($result)) {
					echo '<td>' . $row['PCTChange'] . '</td>';	
					}
				echo '</tr>';
				$result->close();
            	$connection->next_result();
            	// table end:
				echo '</tbody>';
				echo '</table>';


				// Retrieve performance figures:
				$result = mysqli_query($connection,"CALL monthly_returns('BOTZ');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				# table init:
				echo 
				'<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th></th>';
				# table headers:
				while ($row = mysqli_fetch_array($result)) {
					echo '<th>' . $row['Date'] . '</th>';	
					}
				echo '</tr>
						</thead>
						<tbody>';

				# table content:
				echo '<tr>
						<td>' . $etf_list[1] . '</td>';
				foreach ($result as $row) {
				//while ($row = mysqli_fetch_array($result)) {
					echo '<td>' . $row['PCTChange'] . '</td>';	
					}
				echo '</tr>';
				$result->close();
            	$connection->next_result();
            	// table end:
				echo '</tbody>';
				echo '</table>';

				//echo '*****1*****';
				//echo $AI42X_data;
				//echo '<br><br>';
				//echo '*****2*****';
				//echo $AI42X_data_dates;
				
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