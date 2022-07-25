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



			<!-- Market -->
			<br>
				
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
				$pf_smybols = '';
				$pf_purchase_prices = '';
				$pf_sell_prices = '';
				$pf_quantities = '';
				$pf_purchase_dates = '';

				$result = mysqli_query($connection,"SELECT SYMBOL,PURCHASE_PRICE,SELL_PRICE,QUANTITY,PURCHASE_DATE FROM 42_schema.PORTFOLIOS_TABLE WHERE USER_ID=$user_id AND PORTFOLIO_NAME='" . $pf_name . "';");
				$all_property = array();  //declare an array for saving property
				//showing property
				
				while ($property = mysqli_fetch_field($result)) {
    					array_push($all_property, $property->name);  //save those to array
						}
				
				//showing all data
				while ($row = mysqli_fetch_array($result)) {
					$pf_symbols = $pf_symbols . $row['SYMBOL'] . ',';
					$pf_purchase_prices = $pf_purchase_prices . $row['PURCHASE_PRICE'] . ',';
					$pf_sell_prices = $pf_sell_prices . $row['SELL_PRICE'] . ',';
					$pf_quantities = $pf_quantities . $row['QUANTITY'] . ',';
					$pf_purchase_dates = $pf_purchase_dates . $row['PURCHASE_DATE'] . ',';
					}
				// remove last , from string:
    			$pf_symbols = substr($pf_symbols,0, -1);
    			$pf_purchase_prices = substr($pf_purchase_prices,0, -1);
    			$pf_sell_prices = substr($pf_sell_prices,0, -1);
    			$pf_quantities = substr($pf_quantities,0, -1);
    			$pf_purchase_dates = substr($pf_purchase_dates,0, -1);
    			//echo $pf_name . '</br>';
    			//echo $pf_symbols .'</br>';
    			//echo $pf_purchase_prices .'</br>';
    			//echo $pf_sell_prices .'</br>';
    			//echo $pf_quantities .'</br>';
    			//echo $pf_purchase_dates .'</br>';
				?>
			
		
			<div class="container">


			<!-- show portfolio -->
			<div class="container">
				<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>Edit my Portfolio</h4>
					</div> 
				<!-- MY PORTFOLIO -->

				<br id='PORTFOLIO'>
				
				<?php if ($pf_symbols<>'') { 
					echo '<h4>Portfolio: ' . $pf_name . '</h4>'; 
					echo '<a href="ai_analyst_portfolio_delete.php" style="float: right;"><h6>DELETE PORTFOLIO</h6></a> ';
					shortcode(['type' => 'portfolio', 'symbol' => $pf_symbols, 'template' => 'zebra', 'purchase-price' => $pf_purchase_prices, 'quantity' => $pf_quantities, 'sell-price'=> $pf_sell_prices, 'fields' => 'virtual.symbol,virtual.name,portfolio.purchasePrice,portfolio.invested,quote.regularMarketPrice,portfolio.sellPrice,quote.regularMarketChange,quote.regularMarketChangePercent,portfolio.absoluteReturn', 'color' => 'blue']); 
					}
				?>

			</div>
			

			<!-- show stocks -->
			
			<div class="container">
			<p class="font-lato fs-15" id="STOCKS">Add to the portfolio by selecting from the following stock listed AI companies:</p>
			<a href='#PORTFOLIO' class="font-lato fs-15">PORTFOLIO</a>&nbsp;|&nbsp;
			<a href='#STOCKS' class="font-lato fs-15">STOCKS</a>&nbsp;|&nbsp;
			<a href='#ETFS' class="font-lato fs-15">ETFs</a>
			
			
			
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
				$result = mysqli_query($connection,"SELECT Symbol, Category, Name, `AI Sector`, `AI Focus`, `AI Strength`  FROM 42_schema.COMPANIES_TABLE WHERE Ownership = 'PUBLIC' ORDER BY `AI Strength` DESC");
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
					// add to portfolio button:
					echo '<td><a href="#" onclick="addFunction(';
					echo "'" . $row[Symbol] . "'";
					echo ')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>';
					// chart button:
					echo '<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=' . $row[Symbol] . '" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a>';
					
					echo '</td>';



					}
				echo '</tbody>
					</table>
						</div>';
				?>
  			
  			<!-- show ETF's -->
  			<div class="container">
			<p class="font-lato fs-15" id="ETFS">Add to the portfolio by selecting from the following AI ETFs:</p>
			<a href='#PORTFOLIO' class="font-lato fs-15">PORTFOLIO</a>&nbsp;|&nbsp;
			<a href='#STOCKS' class="font-lato fs-15">STOCKS</a>&nbsp;|&nbsp;
			<a href='#ETFS' class="font-lato fs-15">ETFs</a>

			<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light border">
							<thead>
								<tr>
									<th>Symbol</th>
									<th>Name</th>
									<th>Portfolio Selection Sophistication</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>AIQ<br>ETF</td>
									<td>Global X Future Analytics Tech
										<?php shortcode(['type' => 'single', 'symbol' => 'AIQ', 'template' => 'horizontal', 'color' => 'blue']); ?> </td>
									<td><div class="rating rating-2 fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>
									<td>
										<a href="#" onclick="addFunction('AIQ')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>
									<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=AIQ" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></td>
								</tr>
								<tr>
									<td>BOTZ<br>ETF</td>
									<td>Global X Robotics and Artificial
										<?php shortcode(['type' => 'single', 'symbol' => 'BOTZ', 'template' => 'horizontal', 'color' => 'blue']); ?> </td>
									<td><div class="rating rating-2 fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>
									<td>
										<a href="#" onclick="addFunction('BOTZ')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>
									<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=BOTZ" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></td>
								</tr>
								<tr>
									<td>IRBO<br>ETF</td>
									<td>iShares Robotics and Artificial
										<?php shortcode(['type' => 'single', 'symbol' => 'IRBO', 'template' => 'horizontal', 'color' => 'blue']); ?> </td>
									<td><div class="rating rating-2 fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>
									<td>
										<a href="#" onclick="addFunction('IRBO')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>
									<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=IRBO" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></td>
								</tr>
								<tr>
									<td>DTEC<br>ETF</td>
									<td>ALPS ETF Trust ALPS Disruptive
										<?php shortcode(['type' => 'single', 'symbol' => 'DTEC', 'template' => 'horizontal', 'color' => 'blue']); ?> </td>
									<td><div class="rating rating-1 fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>
									<td>
										<a href="#" onclick="addFunction('DTEC')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>
									<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=DTEC" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></td>
								</tr>
								
								<tr>
									<td>ROBT<br>ETF</td>
									<td>First Trust Nasdaq Artificial I
										<?php shortcode(['type' => 'single', 'symbol' => 'ROBT', 'template' => 'horizontal', 'color' => 'blue']); ?> </td>
									<td><div class="rating rating-1 fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>
									<td>
										<a href="#" onclick="addFunction('ROBT')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>
									<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=ROBT" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></td>
								</tr>
								<tr>
									<td>UBOT<br>ETF</td>
									<td>Direxion Daily Robotics, Artifi
										<?php shortcode(['type' => 'single', 'symbol' => 'UBOT', 'template' => 'horizontal', 'color' => 'blue']); ?> </td>
									<td><div class="rating rating-1 fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>
									<td>
										<a href="#" onclick="addFunction('UBOT')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>
									<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=UBOT" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></td>
								</tr>
								<tr>
									<td>BIKR<br>ETF</td>
									<td>Rogers AI Global Macro ETF
										<?php shortcode(['type' => 'single', 'symbol' => 'BIKR', 'template' => 'horizontal', 'color' => 'blue']); ?> </td>
									<td><div class="rating rating-1 fs-11 fw-100"><!-- rating-0 ... rating-5 --></dif></td>
									<td>
										<a href="#" onclick="addFunction('BIKR')" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Add </a></td>
									<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=BIKR" class="btn btn-default btn-sm"><i class="fa fa-stack-exchange white"></i> Profile </a></td>
								</tr>




							</tbody>
						</table>
			</div>


  			


  			</div>
			</section>


			
				
			</div>


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