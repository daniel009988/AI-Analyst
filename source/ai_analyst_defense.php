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
			<section>
			<div class="container">

				<h2>Latest Updates - Defense</h2>
				<div class="container">
				<!-- NEWS -->
				

					<?php
        			//Feed URLs "https://www.inoreader.com/stream/user/1004865403/tag/AI"
        			$feeds = array("http://finance.yahoo.com/rss/headline?s=EGL,ARTX");
        			//Read each feed's items
        			$entries = array();
        			foreach($feeds as $feed) {
            			$xml = simplexml_load_file($feed);
            			$entries = array_merge($entries, $xml->xpath("//item"));
        			}
        			//Sort feed entries by pubDate
        			usort($entries, function ($feed1, $feed2) {
            			return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
        			});
        			?>
        			<div class="row">
        			<?php
        			$counter = 1;
        			$counter2 = 1;
        			$maxitems = 31;
        			foreach($entries as $entry){
        				if ($counter == 1) {echo('<div class="row">');}
	         			?>
            			<div class="col-md-4">
							<div class="heading-title heading-border-bottom"><h6><?= strftime('%m/%d/%Y %I:%M %p', strtotime($entry->pubDate)) ?></h6></div>
            				<a href="<?= $entry->link ?>"><h5><span><?= $entry->title ?></span></h5></a>
            				<p><small><?= substr($entry->description,0,300) ?>...</small></p></td>
            			</div>
            			<?php
            			if ($counter == 3) {
        					echo('</div>');
        					$counter = 0;
        				}
						$counter = $counter + 1;
						$counter2 = $counter2 + 1;
						if ($counter2 == $maxitems) {
        					break;
    						}
        				}
        			?>
					</div>

			</div>
		</section>
		<!-- /NEWS -->	
	</div>



		</div>
		<!-- /wrapper -->


		
		

		

		




</body>
</html>