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
			
			<div class="container">
				<div class="container">
					<br>
					<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>AI Analyst Help</h4>
					</div> 

					<p>The easiest way to understand the features and functionalities of our AI Analyst is by watching our explanatory videos:</p>

					<h4>A general overview / introduction to the AI Analyst outlining the different functionalities:</h4>
					<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/sS_0m-d1CeY?rel=0&autoplay=0&mute=0&color=white&controls=1&loop=1&modestbranding=1&showinfo=0&fullscreen=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"></iframe>

					<br><br><h4>How much AI is in my stock portfolio? The portfolio check function:</h4>
					<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/DknqF1L1QBA?rel=0&autoplay=0&mute=0&color=white&controls=1&loop=1&modestbranding=1&showinfo=0&fullscreen=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"></iframe>
						
					<br><br><h4>A general overview of how to explore public listed companies with AI expertise:</h4>
					<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/3nvgM1MvUVM?rel=0&autoplay=0&mute=0&color=white&controls=1&loop=1&modestbranding=1&showinfo=0&fullscreen=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"></iframe>

					<br><br><h4>A general overview of how to explore private venture capital backed AI companies:</h4>
					<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/DcXw2KJt4pg?rel=0&autoplay=0&mute=0&color=white&controls=1&loop=1&modestbranding=1&showinfo=0&fullscreen=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"></iframe>

					<br><br><h4>A general overview of how to explore currently available AI-ETFs (Exchange Traded Funds):</h4>
					<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/3w_5iuGUyQ8?rel=0&autoplay=0&mute=0&color=white&controls=1&loop=1&modestbranding=1&showinfo=0&fullscreen=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"></iframe>

					<br><br><h4>Advanced search example: How to create a query to identify all AI investments from Sequioa Capital:</h4>
					<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/2uy2j0qGtLA?rel=0&autoplay=0&mute=0&color=white&controls=1&loop=1&modestbranding=1&showinfo=0&fullscreen=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"></iframe>

					<br><br><h4>Advanced search example: How to identify the companies with strongest AI competence or best financial health:</h4>
					<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/Eh3hy-D8qus?rel=0&autoplay=0&mute=0&color=white&controls=1&loop=1&modestbranding=1&showinfo=0&fullscreen=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"></iframe>

					<br><br><p>We also recommend reading the details about our <a href="ai_analyst_know_scoring.php">Quantitative and Qualitative Scoring Methods</a></p>
				

				
			</div>
		</section>
	</div>



		</div>
		<!-- /wrapper -->


		
		

		

		




</body>
</html>