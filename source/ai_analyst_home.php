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
require_once './psmw/shortcode.php';
$templates = json_decode(file_get_contents('./psmw/templates/templates.json'), TRUE);
$env = json_decode(file_get_contents('./psmw/config/env.json'), TRUE);

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
		<h4>Deep insights into the AI ecosystem: The AI Analyst Home</h4>
	</div> 

<!-- COUNT NUMBER OF DATA ENTRIES -->
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
// calculate number of companies:
$result = mysqli_query($connection, 'SELECT COUNT(*) as anzahl FROM COMPANIES_TABLE;');
$all_property = array();
while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name);}
while ($row = mysqli_fetch_array($result)) {$count_companies = $row['anzahl'];}
// calculate number of stock price data:
$result = mysqli_query($connection, 'SELECT COUNT(*) as anzahl FROM STOCKS_TABLE;');
$all_property = array();
while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name);}
while ($row = mysqli_fetch_array($result)) {$count_stockprices = $row['anzahl'];}
// calculate number of funding rounds:
$result = mysqli_query($connection, 'SELECT COUNT(*) as anzahl FROM FUNDING_TABLE;');
$all_property = array();
while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name);}
while ($row = mysqli_fetch_array($result)) {$count_funding = $row['anzahl'];}
// calculate current index value:
$result = mysqli_query($connection, 'select Date, AI42X AS Close FROM `AI42X_INDEX_TABLE` order by Date DESC LIMIT 1');
$all_property = array();
while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name);}
while ($row = mysqli_fetch_array($result)) {$index_date = $row['Date']; $index_value = $row['Close'];}
?>


<!-- WELCOME TEXT ........................................................................................................ -->
<p class="font-lato fs-15">Everything in one place: Explore <b><?php echo number_format($count_companies);?></b> public AI stocks, AI-ETF's and PE/VC backed AI companies, <b><?php echo number_format($count_funding);?></b> funding rounds and <b><?php echo number_format($count_stockprices);?></b> price data points. </p>



<div class="row">
	<div class="col-md-6" valign="top">
		<!-- OUR LISTS ........................................................................................................ -->
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="fa fa fa-flash"></i> DISCOVER OUR COMPILATIONS</span></h5>
			</div>			
			<div class="card-block">
				<div class="row">
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
					$result = mysqli_query($connection,"
							select Name as Compilation, Description, LIST_ID from LISTS_TABLE
							where Public_list = 1; 
							");

					$all_property = array();  //declare an array for saving property
					//showing property
					echo '<div class="table-responsive">
								<table class="table table-hover font-lato fs-12 table-light">
									';  //initialize table tag
					while ($property = mysqli_fetch_field($result)) {
							//if ($property->name<>'LIST_ID'){echo '<th>' . $property->name . '</th>';}  //get field name for header
							//if ($property->name=='LIST_ID'){echo '<th>&nbsp;</th>';}  //get field name for header
							array_push($all_property, $property->name);  //save those to array
							}
					
					//showing all data
					while ($row = mysqli_fetch_array($result)) {
						echo "<tr>";
							foreach ($all_property as $item) {
								if ($item=='Compilation'){echo '<td align="left"><b>' . $row[$item] . '</b></td>';}
								if ($item=='Description'){echo '<td align="left">' . $row[$item] . '</td>';}
								if ($item=='LIST_ID'){echo '
									<td align="left">
									<a href="ai_analyst_list_results.php?LIST_ID=' . $row[$item] .' " class="btn btn-default btn-sm"><i class="fa fa-th-list"></i> Open </a>
									</td>
									';}
								}
						}
						echo '</tr>';
					echo '</table></div>';

					?>

					
				</div>
			</div>
		</div>
		<!-- END LISTS -->
	</div>

	<div class="col-md-6" valign="top">

		<!-- INDEX ........................................................................................................ -->
		<div class="card card-default" id="INDEX">
				<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-linegraph"></i> AI-42 INDEX™</span></h5>
				</div>
				<div class="card-block">
					<div class="row">
						
							<div class="col-md-8" valign="top">
								<div id="main" style="width: 100%;height:150px;"></div>
							</div>
							<div class="col-md-4" valign="top">
							<p class="font-lato fs-12">The AI-42 INDEX™ consists of the 42 greatest public companies in the field of Artificial Intelligence.<br><br>.AI42: <strong><?php echo number_format ( $index_value , 2 , "." , "," ); ?></strong><br>(<?php echo $index_date; ?>)
							<br><a href="ai_analyst_pub_ai_42x_index.php" class="font-lato fs-12" >Learn more</a></p>
							</div>
						
					</div>
				</div>
		</div>


		<!-- MY SEARCHES ........................................................................................................ -->
		<div class="card card-default" id="MYSEARCHES">
				<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-search	"></i> My Searches</span></h5>
				</div>
				<div class="card-block">
					<div class="row">
				
					<!-- My searches -->	
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
					// now retrieve search results:
					$result = mysqli_query($connection, 'SELECT ID, Searchname, SearchSQL FROM USERS_SEARCH_TABLE WHERE USER_ID=' . $user_id);
					$all_property = array();  //declare an array for saving property
					while ($property = mysqli_fetch_field($result)) {
							array_push($all_property, $property->name);  //save those to array
							}
					//showing all data
					echo '<div class="table-responsive">
					<table class="table table-hover font-lato fs-12 table-light">';
					
					$scounter = 0;
					while ($row = mysqli_fetch_array($result)) {
									echo '<tr>';
									echo '<td>' . $row['Searchname']; //search name 

									echo '</td><td align="right"><a href="ai_analyst_pe_search.php?userqueryid=' . $row['ID'] . '" class="btn btn-default btn-sm"><i class="fa fa-th-list"></i> Open </a>';
									echo '</td></tr>';
									$scounter = $scounter + 1;
						}
					if ($scounter==0) {echo '<tr><td class="font-lato fs-12">You have no individual searches saved.</td></tr>';}
					echo '</table></div>';


					?>	
					</div>
				</div>
		</div>
		

		<!-- end my searches -->
				
		<!-- PORTFOLIO CHECK ........................................................................................................ -->
		<div class="card card-default" id="SPOTLIGHT1">
				<div class="card-heading card-heading-transparent">
					<h5><span><i class="fa fa-lightbulb-o"></i> Stock Portfolio Check</span></h5>
				</div>		
				<div class="card-block">
					<form class="m-0" method="post" action="ai_analyst_portfoliocheck.php" autocomplete="off">
						<div class="font-lato fs-12">How much AI is in your portfolio? Enter the stock symbols of your portfolio and calculate the AI score of your stock portfolio in one click:</div><br>
						
						<div class="form-group">
							<textarea class="form-control rounded-0 font-lato fs-12" rows = "5" name = "portfoliocheck" placeholder="Stock symbols seperated by ,">GOOGL, IBM, NVDA, FTNT, GM, BAC</textarea>
						</div>
						<button class="btn btn-primary btn-sm">CHECK PORTFOLIO</button>
					</form>
				</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6" valign="top">

		<!-- SPOTLIGHT ........................................................................................................ -->
		<div class="card card-default" id="SPOTLIGHT1">
				<div class="card-heading card-heading-transparent">
					<h5><span><i class="fa fa fa-flash"></i> Exclusive: CrowdStrike hires Goldman Sachs to lead IPO</span></h5>
				</div>		
				<div class="card-block">
				<div class="row">
					<div class="col-md-4">
						<img class="img-fluid" src="assets/images/crowdstrike.png" alt="...">
					</div>
					<div class="col-md-8">
						<p class="font-lato fs-12">Cybersecurity software maker CrowdStrike Inc has hired investment bank Goldman Sachs Group to prepare for an initial public offering that could come in the first half of next year, people familiar with the matter said on Friday.</p>
						<a href="ai_analyst_pe_companies_profile.php?symbol=CROWDSTRIKE.PE"><button type="button" class="btn btn-primary btn-sm">COMPANY PROFILE</button></a>
					</div>
				</div>
				</div>
		</div>
	</div>
	<div class="col-md-6" valign="top">

		<div class="card card-default" id="SPOTLIGHT2">
				<div class="card-heading card-heading-transparent">
					<h5><span><i class="fa fa fa-flash"></i> Fortinet Nears Buy Point</span></h5>
				</div>
				<div class="card-block">
				<div class="row">
						<div class="col-md-4">
							<img class="img-fluid" src="assets/images/Fortinet.png" alt="...">
						</div>
						<div class="col-md-8">
							<p class="font-lato fs-12">Fortinet earnings and revenue topped Q4 estimates last month. Analysts say Fortinet seems well-positioned as corporate buyers shift to networking technology called software-defined wide-area networking, or SD-WAN.</p>
							<a href="ai_analyst_home_stock_profile.php?stocksymbol=FTNT"><button type="button" class="btn btn-primary btn-sm">COMPANY PROFILE</button></a>
						</div>
				</div>
				</div>
		</div>
		<!-- END SPOTLIGHT -->
	</div>

	
</div>

	



	







<!-- OWN RESEARCH ........................................................................................................-->

<div class="card card-default" id="RESEARCH">
		<div class="card-heading card-heading-transparent">
			<h5><span><span><i class="fa fa fa-search"></i> PERFORM YOUR OWN RESEARCH</span></h5>
		</div>			
		<div class="card-block">
			<div class="row">
				<div class="col-md-4">
					<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
						<div class="box-icon-title">
							<i class="fa fa-th-list"></i>
								<h5>Research Public AI companies</h5>
						</div>
						<p class="font-lato fs-13">A compilation of all public listed companies which are specialised in or create real product value with Artificial Intelligence.</p>
						<a class="box-icon-more font-lato fw-300" href="ai_analyst_pub_market_summary.php">Research now</a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
						<div class="box-icon-title">
							<i class="fa fa-th-list"></i>
								<h5>Research Private AI companies</h5>
						</div>
						<p class="font-lato fs-13">From start-up to unicorn - we cover them all. The most comprehensive compilation of private companies in the area of Artificial Intelligence.</p>
						<a class="box-icon-more font-lato fw-300" href="ai_analyst_pe_market_summary.php">Research now</a>
					</div>
				</div>

				<div class="col-md-4">
					<div class="box-icon box-icon-center box-icon-round box-icon-transparent box-icon-large box-icon-content">
						<div class="box-icon-title">
							<i class="fa fa-th-list"></i>
								<h5>Research AI ETF's</h5>
						</div>
						<p class="font-lato fs-13">An overview of available Exchange Traded Funds (ETFs) with an investment focus in Artificial Intelligence companies.</p>
						<a class="box-icon-more font-lato fw-300" href="ai_analyst_etf_overview.php">Research now</a>
					</div>
				</div>
				
			</div>
		</div>
</div>
		


<!-- SUBSCRIBE! ........................................................................................................ -->
<?php 
		if ($usertype==2) {echo '
			<p class="font-lato fs-15" align="center"><i class="fa fa-unlock"></i> You are using the free version of AI ANALYST. To get the full experience <a href="ai_analyst_subscription.php#subscribe">subscribe now</a></p>
			';}
		?>
<hr>






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
<script src="assets/js/scripts.js"></script>

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
				$result = mysqli_query($connection,"select DATE_FORMAT(Date,'%Y-%m-%d') AS Date, AI42X AS Close FROM `AI42X_INDEX_TABLE`");
				$all_property = array();  //declare an array for saving property
				//showing property
				while ($property = mysqli_fetch_field($result)) {
    					array_push($all_property, $property->name);  //save those to array
						}
				//showing all data
				$data = '[';
				$dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$data = $data . $row['Close'] . ',';
					$dates = $dates . '"' . $row['Date'] . '",';
					}
				$data = substr($data,0, -1);
				$data = $data . ']';
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

				    myChart.setOption(option = {
				        backgroundColor: '#ffffff', //#ffff #2c343c
				        animation: false,
				        grid: {
						  left: 50,
						  top: 10,
						  right: 10,
						  bottom: 20
						},

				        tooltip: {
				            trigger: 'axis',
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
				                axisPointer: {
				                    z: 100
				                },
				                axisLabel: {
					                color: '#929ABA',
					                inside: false,
					                align: 'center',
					                textStyle: {fontSize: 10, fontFamily: "Arial"}
					            }
				            },
				            
				        ],

				        yAxis: {
        					type: 'value',
        					min: 'dataMin',
				            max: 'dataMax',
				            axisLabel: {
					                color: '#929ABA',
					                inside: false,
					                align: 'right',
					                textStyle: {fontSize: 10, fontFamily: "Arial"}
					            }
    							},
    					series: [
        						{
        						name: 'AI42X',
           						data: data,
            					type:'line',
            					itemStyle: {
				                    normal: {
				                        color: upColor}}
            
            
        						}]	
				        
				    }, true);

				    
			
			     
			    </script>





</body>
</html>