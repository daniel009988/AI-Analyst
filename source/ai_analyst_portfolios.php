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

				//retrieve portfolios for that user: --- currently deactivated, one portfolio per user!
				//$pf_name = '';
				//$result = mysqli_query($connection,"SELECT DISTINCT(PORTFOLIO_NAME) FROM 42_schema.PORTFOLIOS_TABLE WHERE USER_ID=$user_id");
				//$all_property = array();  //declare an array for saving property
				//showing property
				//while ($property = mysqli_fetch_field($result)) {
    			//		array_push($all_property, $property->name);  //save those to array
				//		}
				//showing all data
				//while ($row = mysqli_fetch_array($result)) {
    			//		foreach ($all_property as $item) {
        		//			$pf_name = $row[$item];
        		//			}
    			//		}
 
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



				<div class="container">
					<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>Simulate a Portfolio</h4>
					</div> 
					<!-- WELCOME TEXT -->
					<p class="font-lato fs-15">Portfolios in our platform serve the purpose of simulating and tracking investment decisions. Financial instruments - such as stocks or ETF's - all from the AI investment ecosystem, have been compiled and can be added to the portfolio. For each instrument, multiple indicators express different scores on a scale from one (weak) to five (strongest) for each instrument. This gives you predictive intelligence into the health of AI companies and helps you identifying the best future performers by quickly evaluating the signals of AI expertise you care about. Our indicators are used by clients to identify, prioritize and nurture opportunities, to see fast-growing markets and industries before others to inform strategic decisions or to pinpoint fast-growing public companies to understand their strengths in AI, products and technology.</p>

					<!-- NO PORTFOLIO TEXT -->
					<?php 
					if ($pf_symbols=='') { 
						echo '<div class="container">
						<div class="container">

						
						<div class="callout alert alert-default mt-60 mb-60">

							<div class="row">

								<div class="col-md-8 col-sm-8"><!-- left text -->
									<h4><strong>You do not have a portfolio yet.</strong></h4>
									<p>You can create and manage your portfolio to monitor and analyse the performance.</p>
								</div><!-- /left text -->

			
								<div class="col-md-4 col-sm-4 text-right"><!-- right btn -->
									<a href="ai_analyst_pub_market_summary.php" class="btn btn-primary btn-lg">ADD TO PORTFOLIO</a>
									</div><!-- /right btn -->

							</div>

						</div>
						</div>';
					}
					?>
				
					<!-- EXISTING PORTFOLIO -->
					<?php if ($pf_symbols<>'') { 
						echo '<h4>Portfolio: ' . $pf_name . '</h4>'; 
						shortcode(['type' => 'portfolio', 'symbol' => $pf_symbols, 'template' => 'zebra', 'purchase-price' => $pf_purchase_prices, 'quantity' => $pf_quantities, 'sell-price'=> $pf_sell_prices, 'fields' => 'virtual.symbol,virtual.name,portfolio.purchasePrice,portfolio.invested,quote.regularMarketPrice,portfolio.sellPrice,quote.regularMarketChange,quote.regularMarketChangePercent,portfolio.absoluteReturn', 'color' => 'blue']); 
					echo '<div class="callout alert alert-transparent bordered-bottom">
							<div class="row">
								<div class="col-md-8 col-sm-8"><!-- left text -->
								</div>
								<div class="col-md-4 col-sm-4 text-right">
									<a href="ai_analyst_portfolio_delete.php"><button type="button" class="btn btn-primary btn-sm">DELETE PORTFOLIO</button></a>
									<a href="ai_analyst_pub_market_summary.php"><button type="button" class="btn btn-primary btn-sm">ADD TO PORTFOLIO</button></a>

									
									</div>

									


							</div>

							</div>
					
							</div>';
					}
					?>
				
			
			
				
			</div>



		</section>
	</div>





		</div>
		<!-- /wrapper -->


		
		

		

		




</body>
</html>