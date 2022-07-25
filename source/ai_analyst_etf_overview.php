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
#require_once '../psmw/shortcode.php';
#$templates = json_decode(file_get_contents('../psmw/templates/templates.json'), TRUE);
#$env = json_decode(file_get_contents('../psmw/config/env.json'), TRUE);

//startdatechart übergeben? format: YYYY-MM-DD
$start_date = $_GET["startdatechart"];
if ($start_date=='') {$start_date='2018-01-03';}
//$start_date='2018-01-03';
include 'include_menu.php';
?>



			
			<!-- Main Area -->

			<div class="container">
				<div class="container">
					<br>
					<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
					<table width="100%">
						<tr>
							<td>
								<h4>Research ETFs with AI Focus</h4>
							</td>
							<td align="right">
								<!-- LINKS -->
								<a href='ai_analyst_etf_overview.php' class="font-lato fs-12"><strong>OVERVIEW</strong></a>&nbsp;|&nbsp;
								<a href='ai_analyst_etf_comparison.php' class="font-lato fs-12">COMPARSION</a>&nbsp;|&nbsp;
								<a href='ai_analyst_etf_performance.php' class="font-lato fs-12">PERFORMANCE</a>&nbsp;|&nbsp;
								<a href='ai_analyst_etf_latest_updates.php' class="font-lato fs-12">LATEST UPDATES</a>&nbsp;
							</td>
						</tr>
					</table>
					</div> 

					<!-- WELCOME TEXT -->
					<p class="font-lato fs-15">A compilation of all Exchange Traded Funds (ETFs) which are focusing on stocks with Artificial Intelligence potential.<br>
					</p>
					<!-- <h3><span>My Portfolios</span></h3>
					<hr>-->
					

					<!-- Chart container -->
					
					<div class="table-responsive">
					<table class="table table-hover font-lato fs-12 table-light border">
						<thead>
							<tr>
								<th>Symbol</th>
								<th>Name</th>
								<th>Exchange</th>
								<th>Family</th>
								<th>Methology</th>
								<th>Net Assets (M)</th>
								<th>Issue Date</th>
								<th>AVG Daily Volume</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr bgcolor="#C9C9C9">
								<td><strong>.AI42X</strong></td>
								<td><strong>AI42X INDEX</strong></td>
								<td>n/a</td>
								<td><strong>42.CX AG</strong></td>
								<td><strong>AI Market Intelligence Index</strong></td>
								<td>n/a</td>
								<td><strong>03.01.17</strong></td>
								<td>n/a</td>
								<td><a href="ai_analyst_pub_ai_42x_index.php" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td>AIQ</td>
								<td>Global X Future Analytics Tech ETF</td>
								<td>NasdaqGM</td>
								<td>Global X Funds</td>
								<td>Indxx Artificial Intelligence & Big Data Index</td>
								<td>35,0</td>
								<td>16.05.18</td>
								<td>14.141</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=AIQ" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td>AIEQ</td>
								<td>AI Powered Equity ETF</td>
								<td>NYSEArca</td>
								<td>EquBot LLC</td>
								<td>Quantitative model (the "EquBot Model")</td>
								<td>147,9</td>
								<td>18.10.17</td>
								<td>55.688</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=AIEQ" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td>AIIQ</td>
								<td>Equbot AI Powered International Eq ETF</td>
								<td>NYSEArca</td>
								<td>EquBot LLC</td>
								<td>Quantitative model (the "EquBot Model")</td>
								<td>3,4</td>
								<td>6.6.18</td>
								<td>1.250</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=AIIQ" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td>BIKR</td>
								<td>Rogers AI Global Macro ETF</td>
								<td>NYSEArca</td>
								<td>Ocean Capital Advisors</td>
								<td>Rogers AI Global Macro Index</td>
								<td>32,6</td>
								<td>21.6.18</td>
								<td>1.123</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=BIKR" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td>BOTZ</td>
								<td>Global X Robotics & Artfcl Intllgnc ETF</td>
								<td>NasdaqGM</td>
								<td>Global X Funds</td>
								<td>Indxx Global Robotics & Artificial Intelligence Thematic Index</td>
								<td>1.430,0</td>
								<td>3.1.17</td>
								<td>994.361</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=BOTZ" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td>IRBO</td>
								<td>iShares Robotics and Artfcl Intlgc ETF</td>
								<td>NYSEArca</td>
								<td>iShares</td>
								<td>NYSE® FactSet® Global Robotics and Artificial Intelligence Index</td>
								<td>22,8</td>
								<td>28.6.18</td>
								<td>18.418</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=IRBO" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td>ROBT</td>
								<td>iShares Robotics and Artfcl Intlgc ETF</td>
								<td>NasdaqGM</td>
								<td>First Trust</td>
								<td>Nasdaq CTA Artificial Intelligence and Robotics IndexSM</td>
								<td>32,1</td>
								<td>22.2.18</td>
								<td>13.176</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=ROBT" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td>UBOT</td>
								<td>Direxion Dly Rbtc,AtfclItlgcAutoBl3XShrs</td>
								<td>NYSEArca</td>
								<td>Direxion Funds</td>
								<td>Indxx Global Robotics and Artificial Intelligence Thematic Index</td>
								<td>9,7</td>
								<td>19.4.18</td>
								<td>67.958</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=UBOT" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							
						</tbody>
					</table>
				</div>

				<hr>
				<p class="font-lato fs-15" align="right">Something to add? <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="Every submission will be reviewed by our AI Market Intelligence Data team."></i>&nbsp;&nbsp;<a href="#"><button type="button" class="btn btn-primary btn-sm">Make a suggestion</button></a></p>

				
				</div>
			</div>

				</div>
			</section>

			</div>
		</section>
	</div>



		</div>
		<!-- /wrapper -->

</body>
</html>