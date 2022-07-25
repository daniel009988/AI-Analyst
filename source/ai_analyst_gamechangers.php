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
						<h4>Game Changing Technologies</h4>
					</div> 

					<p>The following overview outlines the most game changing technologies and topics. A game changer is defined as (i) an event, idea, or procedure that effects a significant shift in the current manner of doing or thinking about something or (ii) a newly introduced element or factor that changes an existing situation or activity in a significant way. The following selected startups are high-momentum companies pioneering technology with the potential to transform society and economies for the better.</p>
					<p>For example, Quantum artificial intelligence will enhance the most consequential of human activities, explaining observations of the world around us. Equipping devices and machines with AI reduces the amount of bandwidth needed for real-time data processing and minimizes latency in device-level decision making. Fake news is distorting reality, About two-in-three U.S. adults (64%) say fabricated news stories cause a great deal of confusion about the basic facts of current issues and events. Top law enforcement technology needs include improving community relations, effectively sharing information, and better forensic capabilities. We also need an alternative to opioid pain management - more than 40% of all U.S. opioid overdose deaths in 2016 involved a prescription opioid, with more than 46 people dying every day from overdoses involving prescription opioids. Also, the world’s population is getting older. We are living through a period of population aging that is without parallel in the history of humanity. This is a result of the combined effects of declining fertility and falling mortality rates.</p> 
					<p>Another topic, V2X technology, which improves transportation, compliments vision-based sensing such as lidar, and extends a vehicle’s ability to see, hear, and communicate further down the road, especially outside of the range of a car’s computer vision systems. It is also essential that we understand the pace of environmental change that is upon us and that we start to work with nature instead of against it to tackle the array of environmental threats that face us. Net-zero buildings generate clean energy, they provide the most bang for the buck in reducing climate change-causing emissions, and often have low or no marginal cost, or even provide a return on investment. Lastly, our oceans need our immediate help. Overfishing and plastic pollution pose a clear threat to the health of our oceans and marine wildlife.</p>
					<img src="assets/images/gamechanger1.png" class="img-fluid" alt="Responsive image">
					<br><br>
					<p>Here are some selected companies in this space. 28 of the 36 game changers are based in the US or have moved to the US. However, 5 other countries are home to game-changer companies: Canada, India, Israel, United Kingdom, and the Netherlands. Over 190 unique investors backed this year’s cohort of game changers. Topping the list are Lux Capital and Bill Gates, with at least 3 unique investments each. 14 investors backed multiple game changers.</p>
					<img src="assets/images/gamechanger2.png" class="img-fluid" alt="Responsive image">
				

				
			</div>
		</section>
	</div>



		</div>
		<!-- /wrapper -->


		
		

		

		




</body>
</html>