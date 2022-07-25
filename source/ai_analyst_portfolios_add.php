<?php 
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: '.'ai_analyst_login.php'); //not logged in
	}
 //Abfrage der Nutzer ID vom Login
$user_id = $_SESSION['userid'];
$pf_name = 'SIMULATED PORTFOLIO';


				// retrieve parameters and see if we have to store something:
				$purchaseprice = $_GET['purchaseprice'];
				$quantity = $_GET['quantity'];
				$symbol = $_GET['symbol'];

				// if purchaseprice and quantity ok, then save to database:
				if ($purchaseprice>0.00) {
					//echo "Adding " . $symbol . ' ' . $quantity . ' ' . $purchaseprice;
					//write to database:
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
					$sql="INSERT INTO `42_schema`.`PORTFOLIOS_TABLE` (`USER_ID`, `PORTFOLIO_NAME`, `SYMBOL`, `PURCHASE_PRICE`, `QUANTITY`) VALUES ($user_id, '$pf_name', '$symbol' ,$purchaseprice, $quantity)";
					//mysqli_query($connection,$query);
					if ($connection->query($sql) === TRUE) {
    					//echo "New record created successfully";
    					header("Location: ai_analyst_portfolios.php"); /* Redirect browser */
    					//echo '<meta http-equiv="Location" content="ai_analyst_portfolios_edit.php">';
						exit();
					} else {
    					echo "Error: " . $sql . "<br>" . $connection->error;
					}

					$connection->close();

				}
?>

<?php
require_once '../psmw/shortcode.php';
$templates = json_decode(file_get_contents('../psmw/templates/templates.json'), TRUE);
$env = json_decode(file_get_contents('../psmw/config/env.json'), TRUE);
include 'include_menu.php';
?>



			<!-- Market -->
			<section>
			<div class="container">


				<div class="card card-default">
					<div class="card-heading">
						<a href="#" onclick="history.go(-1)" class="btn btn-danger btn-sm float-right">Cancel</a>
						
						<h2 class="card-title">
							<?php echo '<h4>Confirm adding ' . $symbol . ' to your portfolio</h4>';?>
						</h2>
					</div>
					<div class="card-block">
					Please fill in the purchase price and the quantity of the positions to add to your portfolio:
					<br><br>
					Instrument:<br>
					
					<?php shortcode(['type' => 'single', 'symbol' => $symbol, 'template' => 'horizontal', 'color' => 'green']);?>
					<form>
  							<?php echo '<input type="hidden" name="symbol" value="' . $symbol . '">' ?>
  							Purchase Price:<br>
  							<input type="text" name="purchaseprice" value="0.00"><br>
  							Quantity:<br>
  							<input type="text" name="quantity" value="1">
  							<input type="submit" value="Add">
						</form> 

					</div>
					<div class="card-footer">
						
						
					</div>
				</div>

				

				

  					
  				


			</div>
			</section>


			


		</section>
	</div>






		</div>
		<!-- /wrapper -->

	
<!-- function to add items to portfolio -->	
<script>
function addFunction($symbol) {	
    window.alert($symbol);
}
</script>
		

		




</body>
</html>