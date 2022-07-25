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
				<br>
					<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4>The AI42 INDEX</h4>
					</div>
					<div class="card card-default" id="SUMMARY">
						<div class="card-heading card-heading-transparent">
							</div>
						<div class="card-block">
				
					
					<div class="row">
						<div class="col-sm-6">
					<p class="font-lato fs-15">The AI-42 INDEX consists of the 42 greatest <strong>private</strong> companies in the field of Artificial Intelligence.</p>
					<p class="font-lato fs-15">The Index value is calculated based on a proprietary formula developed and compiled by 42.CX to track and measure movement in the valuation levels of VC-backed private growth companies. The Index was originally set to a base of 1,000.00 at its initiation on January 1, 2015. The AI-42 INDEX is based on data obtained from secondary transactions executed on multiple secondary market platforms, publicly disclosed primary funding rounds, valuation marks from publicly reporting institutional holders, SEC filings and social media- , news- and market environment data. The AI-42 Index is using a capitalisation weighted approach. Current capitalisation determination of the index companies is calculated in real time.</p>
   					</div>
   					<div class="col-sm-6">
   					<!-- CHART -->
          			<div id="main" style="width: 550px;height:350px;"></div>
          					<!--<canvas class="chartjs" id="lineChartCanvas" width="547" height="300"></canvas> -->
        			</div>
        		</div>

					

					<!-- HEADER -->
					
					<h4>The AI42 INDEX Constitutients</h4>
					
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12">
							<thead>
								<tr>
									<th>Symbol</th>
									<th>Name</th>
									<th>Sector</th>
									<th>Growthstage</th>
									<th>Ranking</th>
								</tr>
							</thead>
							<tbody>
							<tr>
								<td>.PE</td>
								<td>CrowdStrike</td>
								<td>CYBERSECURITY</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>Face++</td>
								<td>COMMUNICATION</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>Affirm</td>
								<td>FINTECH</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>InsideSales_com</td>
								<td>SALES/MARKETING</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>Darktrace</td>
								<td>DEFENSE/SECURITY</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>C3 IoT</td>
								<td>SOFTWARE DEVELOPMENT</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>Mobvoi</td>
								<td>COMMUNICATION</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>Cybereason</td>
								<td>DEFENSE/SECURITY</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>SoundHound</td>
								<td>NEWS AND MEDIA</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
							<tr>
								<td>.PE</td>
								<td>Brain Corp</td>
								<td>ROBOTICS</td>
								<td>late growth</td>
								<td><span class="badge badge-light">undisclosed</span></td>
							</tr>
						</tbody>
					</table>
					<p class="font-lato fs-15">Showing 1 to 10 of 42 entries. No specific order.</p>
				</div>

				</div>
			</section>
		<!-- /NEWS -->	
	</div>



		</div>
		<!-- /wrapper -->


<!-- JAVASCRIPT FILES -->
		<script>var plugin_path = 'assets/plugins/';</script>
		<script src="assets/plugins/jquery/jquery-3.3.1.min.js"></script>

		<script src="assets/js/scripts.js"></script>

		<!-- REVOLUTION SLIDER -->
		<script src="assets/plugins/slider.revolution/js/jquery.themepunch.tools.min.js"></script>
		<script src="assets/plugins/slider.revolution/js/jquery.themepunch.revolution.min.js"></script>
		<script src="assets/js/view/demo.revolution_slider.js"></script>

		
    
			    <script type="text/javascript">
			        // based on prepared DOM, initialize echarts instance
			        var myChart = echarts.init(document.getElementById('main'));

			        var upColor = '#2980b9'; // '#00da3c';
			        var downColor = '#c0392b'; //'#ec0000';

			        
			        

		

			        //load data:
			        var data = [1162.86,1338.01,1378.39,1466.696,1471.52,1620.93,1721.52,1631.728,1883.21];
			        var dates = ["Q1/17","Q2/17","Q3/17","Q4/17","Q1/18","Q2/18","Q3/18","Q4/18","Q1/19"];

				    myChart.setOption(option = {
				        backgroundColor: '#ffffff', //#ffff #2c343c
				        animation: false,
				        title: {
				        text: 'AI42 INDEX',
				        left: 0
				        },
				        legend: {
				            bottom: 10,
				            left: 'center',
				            data: ['AI42X']
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
				                }
				            },
				            
				        ],

				        yAxis: {
        					type: 'value',
        					min: 'dataMin',
				                max: 'dataMax'
    							},
    					series: [
        						{
        						name: 'AI42',
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