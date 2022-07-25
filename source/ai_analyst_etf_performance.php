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
								<a href='ai_analyst_etf_overview.php' class="font-lato fs-12">OVERVIEW</a>&nbsp;|&nbsp;
								<a href='ai_analyst_etf_comparison.php' class="font-lato fs-12">COMPARSION</a>&nbsp;|&nbsp;
								<a href='ai_analyst_etf_performance.php' class="font-lato fs-12"><strong>PERFORMANCE</strong></a>&nbsp;|&nbsp;
								<a href='ai_analyst_etf_latest_updates.php' class="font-lato fs-12">LATEST UPDATES</a>&nbsp;
							</td>
						</tr>
					</table>
					</div> 

					<!-- WELCOME TEXT -->
					<p class="font-lato fs-15">A compilation of all Exchange Traded Funds (ETFs) which are focusing on stocks with Artificial Intelligence potential.</p>

					<!-- <h3><span>My Portfolios</span></h3>
					<hr>-->
					

					<!-- Chart container -->
					<br>
					<div class="table-responsive">
					<table class="table table-hover font-lato fs-12 table-light border">
						<thead>
							<tr>
								<th>Symbol</th>
								<th>Q1/17</th>
								<th>Q2/17</th>
								<th>Q3/17</th>
								<th>Q4/17</th>
								<th>2017</th>
								<th>Q1/18</th>
								<th>Q2/18</th>
								<th>Q3/18</th>
								<th>Q4/18</th>
								<th>2018</th>
								<th>Q1/19</th>
								<th>YTD</th>
								<th>ITD</th>
								<th>CAGR</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody align="Center">
							<tr bgcolor="#C9C9C9">
								<td><strong>.AI42X</strong></td>
								<td>12.11%</td>
								<td>10.79%</td>
								<td>7.01%</td>
								<td>10.46%</td>
								<td><strong>40.38</strong></td>
								<td>13.72%</td>
								<td>7.94%</td>
								<td>14.75%</td>
								<td>-15.39%</td>
								<td><strong>21.03%</strong></td>
								<td>14.85%</td>
								<td><strong>14.85%</strong></td>
								<td><strong>76.26%</strong></td>
								<td>35.32%</td>
								<td><a href="ai_analyst_pub_ai_42x_index.php" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td><strong>AIQ</strong></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td><strong>-</strong></td>
								<td>-</td>
								<td>-0.40%</td>
								<td>5.67%</td>
								<td>-18.76%</td>
								<td><strong>-13.49%</strong></td>
								<td>14.54%</td>
								<td><strong>14.54%</strong></td>
								<td><strong>1.05%</strong></td>
								<td>12.82%</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=AIQ" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td><strong>AIEQ</strong></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>2.62%</td>
								<td><strong>2.62%</strong></td>
								<td>0.66%</td>
								<td>7.44%</td>
								<td>5.46%</td>
								<td>-26.11%</td>
								<td><strong>-12.54%</strong></td>
								<td>13.75%</td>
								<td><strong>13.75%</strong></td>
								<td><strong>3.82%</strong></td>
								<td>13.06%</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=AIEQ" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td><strong>AIIQ</strong></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td><strong>-</strong></td>
								<td>-</td>
								<td>-3.16%</td>
								<td>3.38%</td>
								<td>-17.39%</td>
								<td><strong>-17.16%</strong></td>
								<td>8.97%</td>
								<td><strong>8.97%</strong></td>
								<td><strong>-8.19%</strong></td>
								<td>2.02%</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=AIIQ" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td><strong>BIKR</strong></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td><strong>-</strong></td>
								<td>-</td>
								<td>-0.04%</td>
								<td>0.44%</td>
								<td>-6.92%</td>
								<td><strong>-6.52%</strong></td>
								<td>4.26%</td>
								<td><strong>4.26%</strong></td>
								<td><strong>-2.26%</strong></td>
								<td>2.04%</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=BIKR" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td><strong>BOTZ</strong></td>
								<td>14.97%</td>
								<td>7.49%</td>
								<td>16.56%</td>
								<td>8.97%</td>
								<td><strong>47.98%</strong></td>
								<td>2.07%</td>
								<td>-9.01%</td>
								<td>3.95%</td>
								<td>-26.84%</td>
								<td><strong>-29.83%</strong></td>
								<td>10.57%</td>
								<td><strong>10.57%</strong></td>
								<td><strong>28.73%</strong></td>
								<td>16.62%</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=BOTZ" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td><strong>IRBO</strong></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td><strong>-</strong></td>
								<td>-</td>
								<td>0.59%</td>
								<td>5.81%</td>
								<td>-19.74%</td>
								<td><strong>-13.33%</strong></td>
								<td>14.18%</td>
								<td><strong>14.18%</strong></td>
								<td><strong>0.85%</strong></td>
								<td>12.38%</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=IRBO" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td><strong>ROBT</strong></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td><strong>-</strong></td>
								<td>-1.77%</td>
								<td>-0.34%</td>
								<td>9.84</td>
								<td>-20.30%</td>
								<td><strong>-12.57%</strong></td>
								<td>14.39%</td>
								<td><strong>14.39%</strong></td>
								<td><strong>1.82%</strong></td>
								<td>15.30%</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=ROBT" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
							</tr>
							<tr>
								<td><strong>UBOT</strong></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td><strong>-</strong></td>
								<td>-</td>
								<td>-27.59%</td>
								<td>8.14%</td>
								<td>-63.41%</td>
								<td><strong>-82.87%%</strong></td>
								<td>31.35%</td>
								<td><strong>31.35%</strong></td>
								<td><strong>-51.52%</strong></td>
								<td>-8.22%</td>
								<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=ROBT" class="btn btn-default btn-sm"><i class="fa fa-plus white"></i> Profile </a></th></td>
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