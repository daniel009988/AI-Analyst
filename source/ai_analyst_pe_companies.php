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
$list = $_GET['list'];
$param = $_GET['param'];
if ($list == '') {$list = 'Country';
				$param = 'United States';
			}

//table pagination:
$page = $_GET['page'];
// if no page specified, start with page 1
if ($page == '') {$page = 1; } // if no page specified, start with page 1
// only paying users can swith:
if ($usertype==2) {$page = 1;} //free users will be forced to page 1

require_once '../psmw/shortcode.php';

$templates = json_decode(file_get_contents('../psmw/templates/templates.json'), TRUE);
$env = json_decode(file_get_contents('../psmw/config/env.json'), TRUE);
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
	

			<!-- COMPANIES -->
			<!-- Market -->
			<div class="container">
				<div class="container">
				<br>
				<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>Research Private VC/PE Backed AI Companies</h4>
					</div> 
				
				<!-- WELCOME TEXT -->
				<p class="font-lato fs-15">A compilation of all private companies which are specialised in or create real product value with Artificial Intelligence. Choose Profile to review the company's details.</p>
			
				<!-- LIST RESULTS -->
				<?php
				echo '<table width=100% border=0><tr><td><h5><span>Showing entries for "' . $param . '"</span></h5></td><td align="right" valign="top"><a href="javascript:history.back()"><button type="button" class="btn btn-primary btn-sm">Go back</button></a></td></tr>' ;
				?>

				
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

				//get results from database:

				//pagination:
				$entryfrom = (intval($page) - 1) * 10 ;
				$limit_string = ' LIMIT ' . $entryfrom . ',10;';
				// calculate number of results:
				$result2 = mysqli_query($connection,"
						SELECT COUNT(*) AS counter FROM COMPANIES_TABLE
						WHERE Category<>'' and $list LIKE '$param%' 	  
						LIMIT 1");
				$all_property2 = array();
				while ($property2 = mysqli_fetch_field($result2)) {array_push($all_property2, $property2->name);}
				$counter = 0;
				while ($row2 = mysqli_fetch_array($result2)) {
					foreach ($all_property2 as $item2) {
						if ($item2=='counter') {$counter = $row2[$item2];};
					}
				}
					
				echo '<tr><td><div class="font-lato fs-13" align="left">This search returned ' . number_format($counter) . ' results.</div></td></tr></table>';

				$result = mysqli_query($connection,"
						SELECT COMPANIES_TABLE.Symbol, Name, Category, Country, Growthstage, Employees, Website, Ownership, Ranking, STOCKS_TABLE.Symbol AS SYMBOL_2
						FROM 42_schema.COMPANIES_TABLE 
						LEFT JOIN STOCKS_TABLE ON COMPANIES_TABLE.Symbol = STOCKS_TABLE.Symbol 
						WHERE Category<>'' and $list LIKE '$param%' 	  
						GROUP BY COMPANIES_TABLE.Symbol, Name, Category, Country, Growthstage,Employees,Website, Ranking, SYMBOL_2
						ORDER BY Ranking DESC, SYMBOL_2 DESC, Name " . $limit_string);


				$all_property = array();  //declare an array for saving property
				//showing property
				echo '<div class="table-responsive">
							<table class="table table-hover font-lato fs-12 table-light border">
								<thead>
        							<tr>';  //initialize table tag
				while ($property = mysqli_fetch_field($result)) {
						if (($property->name<>'Ranking') && ($property->name<>'SYMBOL_2')) {
    						echo '<th>' . $property->name . '</th>';  //get field name for header
    					}
    					array_push($all_property, $property->name);  //save those to array
						}
				echo '<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></thead>
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
        					// top ranking?
        					if (($item==='Ranking') && ($row[$item]<>'0')) {
        							echo '<td><i class="fa fa-trophy" style="color:#2980b9"></i></td>'; //get items using property value
        					} 
        					if (($item==='Ranking') && ($row[$item]==='0')) {
        							echo '<td>&nbsp;</td>';
        					} 
        					// chart and funding rounds available?
        					if (($item==='SYMBOL_2') && ($row[$item]<>'')){
        						echo '<td><i class="fa fa-area-chart" style="color:#c9c9c9"></i></td>'; //get items using property value

        					} 
        					if (($item==='SYMBOL_2') && (empty($row[$item]))) {
        							echo '<td>&nbsp;</td>';
        					} 
        					if ($item==='Symbol') {
        							echo '<td><p class="font-lato fs-10"><b>' . $row[$item] . '</b></p></td>';
        					} 
        					if ($item==='Name') {
        							echo '<td><b>' . $row[$item] . '</b></td>';
        					} 
        					// all other output:
        					if (($item<>'Website') && ($item<>'Ranking') && ($item<>'SYMBOL_2') && ($item<>'Symbol') && ($item<>'Name')) {
        						echo '<td>' . $row[$item] . '</td>'; //get items using property value
        					}

    					}
    			if ($row['Ownership']=='PUBLIC') {echo '<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=' . $row[0] .' " class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></th';}

				if ($row['Ownership']<>'PUBLIC') {echo '<td><a href="ai_analyst_pe_companies_profile.php?symbol=' . $row[0] .' " class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></th';}
    			echo '</tr>';
    			
    			// count number of entries:
    			$entries = $entries + 1;

				}
				
				echo '</table>';

				// no entries found?
				if ($entries==0) {echo '<p class="font-lato fs-15">The search did not return any results.</p>';}
			
				?>

				<!-- PAGINATION -->	
				<?php
					// free users:
					if ($usertype==2) {
						echo '<p class="font-lato fs-15"><i class="fa fa-lock"></i>&nbsp;Showing maximum of 10 entries. More results are a premium feature and only available for subscribers. <a href="ai_analyst_subscription.php#subscribe">Subscribe now</a></p>';
					} 
					// paying users:
					if (($usertype<>2) && ($entries>0)) {
						$entryfrom = (intval($page) - 1) * 10 + 1;
						$entryto = $entryfrom + $entries - 1;
						$nextpage = intval($page) + 1;
						$previouspage = intval($page) - 1;
						echo '<table width=100%><tr>';
						echo '<td width=50%><p class="font-lato fs-15">Showing entries ' . $entryfrom . ' to ' . $entryto . '</p></td>';
						echo '<td width=50% align="right"><p class="font-lato fs-15">';
						// back to start:
						if ($page>1) {
						echo '<a href="?list=' . $list . '&param=' . $param .'&page=1"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>Back to start</button></a>';
						}
						// previous 10 
						if ($page>1) {
						echo '<a href="?list=' . $list . '&param=' . $param .'&page=' . $previouspage . '"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-angle-left"></i>Previous 10 entries</button></a>';
						}
						// next 10
						if ($entries>=10) {
						echo '<a href="?list=' . $list . '&param=' . $param .'&page=' . $nextpage . '"><button type="button" class="btn btn-primary btn-sm">Next 10 entries <i class="fa fa-angle-right"></i></button></a>';
						echo '</p></td></tr></table>';
						}
					} 

				?>

			<br><br>
			
			
			

			


			</div>
			</section>
		<!-- /NEWS -->	
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

		<!-- PAGE LEVEL SCRIPTS FOR DB QUERIES -->
		
		

		

		




</body>
</html>