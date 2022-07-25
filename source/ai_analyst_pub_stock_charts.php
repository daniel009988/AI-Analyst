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
				<div class="container">

				<h3><span>Markets (Public) - Stocks</span></h3>
				<h6>Click on any row to show detailed stock chart.</h6>
				<hr>
				
				<h4><span>Large Caps with AI Competence</span></h3>
				
				<?php shortcode(['type' => 'combo', 'symbol' => 'BIDU,CRM,DXC,INTC,AMZN,FB,ORCL,IBM,GOOGL,MSFT', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				

				<h4><span>Healthcare and AI</span></h3>
				
				<?php shortcode(['type' => 'combo', 'symbol' => 'AIPT,BTAI,GMED,CATS,ASTC,DE', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				

				<h4><span>CRM and AI</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'BLKB,EGAN', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>Consulting and AI</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'BAH', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>Defense and AI</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'EGL,ARTX', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>Finance and AI</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'QD,INFY', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>Cybersecurity and AI</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'FTNT,PANW', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>Education and AI</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'LAIX', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>IT, Platform and Enagblers with AI Competence</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'AMRH,CLDR,IDEX,MARK,PRSP,VERI,TWLO,AYX,BOX,NOW,SPLK', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>Semiconductors with AI Competence</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'CEVA,CRAY,NVDA,SNPS,CDNS,MU,AVGO', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>Human Ressources and Outsourcing with AI Competence</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'ASGN,KFRC,WDAY', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?><hr>
				
				<h4><span>Mobile Communications and AI</span></h3>
				<?php shortcode(['type' => 'combo', 'symbol' => 'CMCM,CTK,ZEN', 'template' => 'tablechart3', 'fields' => 'virtual.symbol,virtual.name,quote.regularMarketPrice,quote.regularMarketChange,quote.regularMarketChangePercent,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh', 'chart' => 'line', 'range' => '1y', 'interval' => '1mo', 'line-color' => 'rgb(49, 125, 189)']); ?>
				</div>
			</section>

			<!-- Market -->
			<section>
			<div class="container">


				<h2>Latest Related Updates</h2>
				<div class="container">
				<!-- NEWS -->
				

					<?php
        			//Feed URLs "https://www.inoreader.com/stream/user/1004865403/tag/AI"
        			$feeds = array("http://finance.yahoo.com/rss/headline?s=BIDU,CRM,DXC,INTC,AMZN,FB,ORCL,IBM,GOOGL,MSFT,AIPT,BTAI,GMED,CATS,ASTC,DE,BLKB,EGAN,BAH,EGL,ARTX,QD,INFY,FTNT,PANW,LAIX,AMRH,CLDR,IDEX,MARK,PRSP,VERI,TWLO,AYX,BOX,NOW,SPLK,CEVA,CRAY,NVDA,SNPS,CDNS,MU,AVGO,ASGN,KFRC,WDAY,CMCM,CTK,ZEN");
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