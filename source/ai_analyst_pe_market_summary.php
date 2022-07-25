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



			<!-- SCROLL TO TOP -->
			<a href="#" id="toTop"></a>
			<!-- PRELOADER -->
			<div id="preloader">
				<div class="inner">
					<span class="loader"></span>
				</div>
			</div><!-- /PRELOADER -->
	

			<!-- Market -->
			<div class="container">
				<div class="container">
				<br>
				<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>Research Private VC/PE Backed AI Companies</h4>
					</div> 
				
				<!-- WELCOME TEXT -->
				<p class="font-lato fs-15">A compilation of all private companies which are specialised in or create real product value with Artificial Intelligence.</p>

				<div class="card card-default" id="SUMMARY">
						<div class="card-heading card-heading-transparent">
							

				<!-- TOTAL NUMBER OF COMPANIES -->
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
				$result = mysqli_query($connection,"select count(*) as 'Total number of private companies' from COMPANIES_TABLE where ownership <> 'PUBLIC'");
				$all_property = array();  //declare an array for saving property
				//showing property
				echo '<h6>TOTAL NUMBER OF PRIVATE COMPANIES: ';
				while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
				while ($row = mysqli_fetch_array($result)) {
    					foreach ($all_property as $item) {
        					echo number_format($row[$item]); //get items using property value
        					}
    					}
    			echo '</h6>';
				?>

				</div>
						<div class="card-block">

				<!-- FIRST CLUSTER -->

				<table width="100%">
					<tr>
						<td width="30%" valign="top">

				<!-- BY GROWTH STAGE -->
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
				$result = mysqli_query($connection,"select Growthstage, count(*) as Number from COMPANIES_TABLE 
						where ownership <> 'PUBLIC' and Category<>''
						group by Growthstage
						order by Number DESC");
				$all_property = array();  
				echo '<h6>BY GROWTH STAGE</h6>';
				echo '<div class="table-responsive">
							<table class="table  font-lato fs-12">';  //initialize table tag
				while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
				echo'</tr>';
				echo '</thead>
						<tbody>'; //end tr tag
				while ($row = mysqli_fetch_array($result)) {
						echo "<tr>";
    					foreach ($all_property as $item) {
        					echo '<td>' . $row[$item] . '</td>'; //get items using property value
        					}
        				echo '<td><a href="ai_analyst_pe_companies.php?list=Growthstage&param=' . $row[0] .' " class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Show </a></th';
        				echo '</tr>';
    					}
    			echo '</tbody>';
    			echo '</table>';
    			echo '</div>'
				?>

				<div class="row">
					<div class="col-md-12">
							
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
					


			</td>
			<td>&nbsp;</td>
			<td width="30%" valign="top">

				<!-- BY SECTOR -->
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
				$result = mysqli_query($connection,"select Category, count(*) as Number from `COMPANIES_TABLE` 
						where ownership <> 'PUBLIC' and Category<>'' 
						group by Category
						order by Number DESC
						LIMIT 10;");
				$all_property = array();  
				echo '<h6>BY SECTOR (TOP 10)</h6>';
				echo '<div class="table-responsive">
							<table class="table  font-lato fs-12">';  //initialize table tag
				while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
				echo'</tr>';
				echo '</thead>
						<tbody>'; //end tr tag
				while ($row = mysqli_fetch_array($result)) {
						echo "<tr>";
    					foreach ($all_property as $item) {
        					echo '<td>' . $row[$item] . '</td>'; //get items using property value
        					}
        				echo '<td><a href="ai_analyst_pe_companies.php?list=Category&param=' . $row[0] .' " class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Show </a></th';
        				echo '</tr>';
    					}
    			echo '</tbody>';
    			echo '</table>';
    			echo '</div>'
				?>


			</td>
			<td>&nbsp;</td>
			<td width="30%" valign="top">

				<!-- BY COUNTRY -->
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
				$result = mysqli_query($connection,"select Country, count(*) as Number from `COMPANIES_TABLE` 
					where ownership <> 'PUBLIC' and Category<>'' 
					group by Country
					order by Number DESC
					LIMIT 10;");
				$all_property = array();  
				echo '<h6>BY COUNTRY (TOP 10)</h6>';
				echo '<div class="table-responsive">
							<table class="table  font-lato fs-12">';  //initialize table tag
				while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
				echo'</tr>';
				echo '</thead>
						<tbody>'; //end tr tag
				while ($row = mysqli_fetch_array($result)) {
						echo "<tr>";
    					foreach ($all_property as $item) {
        					echo '<td>' . $row[$item] . '</td>'; //get items using property value
        					}
        				echo '<td><a href="ai_analyst_pe_companies.php?list=Country&param=' . $row[0] .' " class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Show </a></th';
        				echo '</tr>';
    					}
    			echo '</tbody>';
    			echo '</table>';
    			echo '</div>'
				?>


				
				
			</td></tr>
			</table>
				


						
			

			</div>
		</section>
		<!-- /NEWS -->	
	</div>



		</div>
		<!-- /wrapper -->


		<!-- JAVASCRIPT FILES -->
		<script>var plugin_path = 'assets/plugins/';</script>
		<script src="assets/js/scripts.js"></script>
		

		

		




</body>
</html>