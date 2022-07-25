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



	

			
			<!-- Chart -->

			
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
								<a href='ai_analyst_etf_comparison.php' class="font-lato fs-12"><strong>COMPARSION</strong></a>&nbsp;|&nbsp;
								<a href='ai_analyst_etf_performance.php' class="font-lato fs-12">PERFORMANCE</a>&nbsp;|&nbsp;
								<a href='ai_analyst_etf_latest_updates.php' class="font-lato fs-12">LATEST UPDATES</a>&nbsp;
							</td>
						</tr>
					</table>
					</div> 

					<div class="card card-default" id="SUMMARY">
						<div class="card-heading card-heading-transparent">
							<h5>AI-ETF Comparison</h5>
					</div>			
				
				<div class="card-block">

					

					<!-- Chart container -->
					<div id="main" style="width: 100%;height:550px;"></div>

					<!-- WELCOME TEXT -->
					<br>
					<p class="font-lato fs-15">Choose another start date:
					<br>
					<!-- LINKS -->
					<a href="?startdatechart=2017-01-03">2017-01-03 BOTZ</a> |
					<a href="?startdatechart=2017-10-18">2017-10-18 AIEQ</a> |
					<a href="?startdatechart=2018-02-22">2018-02-22 ROBT</a> |
					<a href="?startdatechart=2018-04-19">2018-04-19 UBOT</a> |
					<a href="?startdatechart=2018-05-16">2018-05-16 AIQ</a> |
					<a href="?startdatechart=2018-06-06">2018-06-06 AIIQ</a> |
					<a href="?startdatechart=2018-06-21">2018-06-21 BIKR</a> |
					<a href="?startdatechart=2018-06-28">2018-06-28 IRBO</a></p>

				<?php
				// load data for chart:
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
				
				// retrieve data and build data for chart:
				//$start_date = '2018-01-03';# '2018-06-28';
				echo '<h6 align="center">CHART PERIOD: ' . $start_date . ' - ' . date("Y-m-d") . '</h6>';

				
				

				// AIEQ
				$result = mysqli_query($connection,"CALL normalised_stockdata('AIEQ','$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$AIEQ_data = '[';
				$AIEQ_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$AIEQ_data = $AIEQ_data . $row['Balance'] . ',';
					$AIEQ_data_dates = $AIEQ_data_dates . '["' . $row['Date'] . '"],';
					}
				$AIEQ_data = substr($AIEQ_data,0, -1);
				$AIEQ_data = $AIEQ_data . ']';
				$AIEQ_data_dates = substr($AIEQ_data_dates,0, -1);
				$AIEQ_data_dates = $AIEQ_data_dates . ']';
				$result->close();
            	$connection->next_result();

				// AIIQ
				$result = mysqli_query($connection,"CALL normalised_stockdata('AIIQ','$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$AIIQ_data = '[';
				$AIIQ_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$AIIQ_data = $AIIQ_data . $row['Balance'] . ',';
					$AIIQ_data_dates = $AIIQ_data_dates . '["' . $row['Date'] . '"],';
					}
				$AIIQ_data = substr($AIIQ_data,0, -1);
				$AIIQ_data = $AIIQ_data . ']';
				$AIIQ_data_dates = substr($AIIQ_data_dates,0, -1);
				$AIIQ_data_dates = $AIIQ_data_dates . ']';
				$result->close();
            	$connection->next_result();

            	// AIQ
				$result = mysqli_query($connection,"CALL normalised_stockdata('AIQ','$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$AIQ_data = '[';
				$AIQ_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$AIQ_data = $AIQ_data . $row['Balance'] . ',';
					$AIQ_data_dates = $AIQ_data_dates . '["' . $row['Date'] . '"],';
					}
				$AIQ_data = substr($AIQ_data,0, -1);
				$AIQ_data = $AIQ_data . ']';
				$AIQ_data_dates = substr($AIQ_data_dates,0, -1);
				$AIQ_data_dates = $AIQ_data_dates . ']';
				$result->close();
            	$connection->next_result();

            	// BOTZ
				$result = mysqli_query($connection,"CALL normalised_stockdata('BOTZ','$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$BOTZ_data = '[';
				$BOTZ_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$BOTZ_data = $BOTZ_data . $row['Balance'] . ',';
					$BOTZ_data_dates = $BOTZ_data_dates . '["' . $row['Date'] . '"],';
					}
				$BOTZ_data = substr($BOTZ_data,0, -1);
				$BOTZ_data = $BOTZ_data . ']';
				$BOTZ_data_dates = substr($BOTZ_data_dates,0, -1);
				$BOTZ_data_dates = $BOTZ_data_dates . ']';
				$result->close();
            	$connection->next_result();

            	// IRBO
				$result = mysqli_query($connection,"CALL normalised_stockdata('IRBO','$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$IRBO_data = '[';
				$IRBO_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$IRBO_data = $IRBO_data . $row['Balance'] . ',';
					$IRBO_data_dates = $IRBO_data_dates . '["' . $row['Date'] . '"],';
					}
				$IRBO_data = substr($IRBO_data,0, -1);
				$IRBO_data = $IRBO_data . ']';
				$IRBO_data_dates = substr($IRBO_data_dates,0, -1);
				$IRBO_data_dates = $IRBO_data_dates . ']';
				$result->close();
            	$connection->next_result();

            	// ROBT
				$result = mysqli_query($connection,"CALL normalised_stockdata('ROBT','$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$ROBT_data = '[';
				$ROBT_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$ROBT_data = $ROBT_data . $row['Balance'] . ',';
					$ROBT_data_dates = $ROBT_data_dates . '["' . $row['Date'] . '"],';
					}
				$ROBT_data = substr($ROBT_data,0, -1);
				$ROBT_data = $ROBT_data . ']';
				$ROBT_data_dates = substr($ROBT_data_dates,0, -1);
				$ROBT_data_dates = $ROBT_data_dates . ']';
				$result->close();
            	$connection->next_result();

            	// UBOT
				$result = mysqli_query($connection,"CALL normalised_stockdata('UBOT','$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$UBOT_data = '[';
				$UBOT_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$UBOT_data = $UBOT_data . $row['Balance'] . ',';
					$UBOT_data_dates = $UBOT_data_dates . '["' . $row['Date'] . '"],';
					}
				$UBOT_data = substr($UBOT_data,0, -1);
				$UBOT_data = $UBOT_data . ']';
				$UBOT_data_dates = substr($UBOT_data_dates,0, -1);
				$UBOT_data_dates = $UBOT_data_dates . ']';
				$result->close();
            	$connection->next_result();

            	// BIKR
				$result = mysqli_query($connection,"CALL normalised_stockdata('BIKR','$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$BIKR_data = '[';
				$BIKR_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$BIKR_data = $BIKR_data . $row['Balance'] . ',';
					$BIKR_data_dates = $BIKR_data_dates . '["' . $row['Date'] . '"],';
					}
				$BIKR_data = substr($BIKR_data,0, -1);
				$BIKR_data = $BIKR_data . ']';
				$BIKR_data_dates = substr($BIKR_data_dates,0, -1);
				$BIKR_data_dates = $BIKR_data_dates . ']';
				$result->close();
            	$connection->next_result();

            	// BIKR
				$result = mysqli_query($connection,"CALL normalised_ai42xindexdata('$start_date');");
				$all_property = array();  
				while ($property = mysqli_fetch_field($result)) { array_push($all_property, $property->name); }
				$AI42X_data = '[';
				$AI42X_data_dates = '[';
				while ($row = mysqli_fetch_array($result)) {
					$AI42X_data = $AI42X_data . $row['Balance'] . ',';
					$AI42X_data_dates = $AI42X_data_dates . '["' . $row['Date'] . '"],';
					}
				$AI42X_data = substr($AI42X_data,0, -1);
				$AI42X_data = $AI42X_data . ']';
				$AI42X_data_dates = substr($AI42X_data_dates,0, -1);
				$AI42X_data_dates = $AI42X_data_dates . ']';
				$result->close();
            	$connection->next_result();

				//echo '*****1*****';
				//echo $AI42X_data;
				//echo '<br><br>';
				//echo '*****2*****';
				//echo $AI42X_data_dates;
				
				?>
    
			    <script type="text/javascript">
			        // based on prepared DOM, initialize echarts instance
			        var myChart = echarts.init(document.getElementById('main'));

			        var ETF1color = '#cccfcf'; // '#00da3c';
			        var ETF2color = '#bbbfbf'; //'#ec0000';
			        var ETF3color = '#aaafb0'; //'#ec0000';
			        var ETF4color = '#999fa0'; //'#ec0000';
			        var ETF5color = '#888f90'; //'#ec0000';
			        var ETF6color = '#777f80'; //'#ec0000';
			        var ETF7color = '#666f70'; //'#ec0000';
			        var ETF8color = '#556061'; //'#ec0000';
			        
			        var AI42Xcolor = '#1abc9c'; //'#ec0000';


			        //load data:
			        var AI42X_data = <?php echo $AI42X_data ?>;
			        var AI42X_data_dates = <?php echo $AI42X_data_dates ?>;
			        var AIEQ_data = <?php echo $AIEQ_data ?>;
			        var AIEQ_data_dates = <?php echo $AIEQ_data_dates ?>;
			        var AIIQ_data = <?php echo $AIIQ_data ?>;
			        var AIIQ_data_dates = <?php echo $AIIQ_data_dates ?>;
			        var AIQ_data = <?php echo $AIQ_data ?>;
			        var AIQ_data_dates = <?php echo $AIQ_data_dates ?>;
			        var BOTZ_data = <?php echo $BOTZ_data ?>;
			        var BOTZ_data_dates = <?php echo $BOTZ_data_dates ?>;
			        var IRBO_data = <?php echo $IRBO_data ?>;
			        var IRBO_data_dates = <?php echo $IRBO_data_dates ?>;
			        var ROBT_data = <?php echo $ROBT_data ?>;
			        var ROBT_data_dates = <?php echo $ROBT_data_dates ?>;
			        var UBOT_data = <?php echo $UBOT_data ?>;
			        var UBOT_data_dates = <?php echo $UBOT_data_dates ?>;
			        var BIKR_data = <?php echo $BIKR_data ?>;
			        var BIKR_data_dates = <?php echo $BIKR_data_dates ?>;
			        

				    myChart.setOption(option = {
				    	backgroundColor: '#ffff', //#fff #2c343c
        				animation: false,
        				title: {
        						text: 'AI-ETF Performance Comparison (Benchmark: AI-42X INDEX)',
        						left: 0
        						},

        				tooltip: {
            					trigger: 'axis',
            					axisPointer: {
                					type: 'cross'
            							},
            					backgroundColor: 'rgba(245, 245, 245, 0.8)',
            					borderWidth: 1,
            					borderColor: '#ccc',
            					padding: 10,
            					textStyle: {
                					color: '#000'
            							}
            					},

            			legend: {top: 35},

            			toolbox: {
            					feature: {
                				dataZoom: {
                    				yAxisIndex: false
                						},
                				brush: {
                    				type: ['lineX', 'clear']
                						}
            						}
        						},

        				grid: 	[
            					{
                				left: '10%',
                				right: '8%',
                				height: '75%'
            					}],
				        
        
				        xAxis: 
				      
				            [
				            {
				                type: 'category',
				                data: AI42X_data_dates,
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
				            {
				                type: 'category',
				                data: AIEQ_data_dates,
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
				            {
				                type: 'category',
				                data: AIIQ_data_dates,
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
				            {
				                type: 'category',
				                data: AIQ_data_dates,
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
				            {
				                type: 'category',
				                data: BOTZ_data_dates,
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
				            {
				                type: 'category',
				                data: IRBO_data_dates,
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
				            {
				                type: 'category',
				                data: ROBT_data_dates,
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
				            {
				                type: 'category',
				                data: UBOT_data_dates,
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
				            {
				                type: 'category',
				                data: BIKR_data_dates,
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
				                
				            }


				            ],
				        
				        yAxis: 
				        	[{
                				scale: true,
                				name: 'Performance %',
        						nameLocation: 'middle',
        						nameGap: 50,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						},
    						{
                				scale: true,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						},
    						{
                				scale: true,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						},
    						{
                				scale: true,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						},
    						{
                				scale: true,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						},
    						{
                				scale: true,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						},
    						{
                				scale: true,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						},
    						{
                				scale: true,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						},
    						{
                				scale: true,
                				splitArea: {
                    				show: true
                							}
            					},
				            
				            	{
        						type: 'value'
    						}

    						],

    					dataZoom: 
    						[{
                					type: 'slider',
 									start: 0,
                					end: 100
            				}],

				        series: 
				            [
				            {
				            	data: AI42X_data,
                				name: 'AI42X INDEX',
                				type: 'line',
                				lineStyle: {type: 'dotted', width: 3},
                				itemStyle: {
                    				normal: {
                        				color: AI42Xcolor
                        					}
                        			}
                				
            				},
				            {
				            	data: AIEQ_data,
                				name: 'AIEQ',
                				type: 'line',
                				lineStyle: {type: 'solid', width: 0.5},
                				itemStyle: {
                    				normal: {
                        				color: ETF1color
                        					}
                        			},
                        		lineStyle: {
                    				normal: {opacity: 0.5}
                					}
                				
            				},
            				{
				            	data: AIIQ_data,
                				name: 'AIIQ',
                				type: 'line',
                				lineStyle: {type: 'solid', width: 0.5},
                				itemStyle: {
                    				normal: {
                        				color: ETF2color
                        					}
                        			},
                        		lineStyle: {
                    				normal: {opacity: 0.5}
                					}
                				
            				},
            				{
				            	data: AIQ_data,
                				name: 'AIQ',
                				type: 'line',
                				lineStyle: {type: 'solid', width: 0.5},
                				itemStyle: {
                    				normal: {
                        				color: ETF3color
                        					}
                        			},
                        		lineStyle: {
                    				normal: {opacity: 0.5}
                					}
                				
            				},
            				{
				            	data: BOTZ_data,
                				name: 'BOTZ',
                				type: 'line',
                				lineStyle: {type: 'solid', width: 0.5},
                				itemStyle: {
                    				normal: {
                        				color: ETF4color
                        					}
                        			},
                        		lineStyle: {
                    				normal: {opacity: 0.5}
                					}
                				
            				},
            				{
				            	data: IRBO_data,
                				name: 'IRBO',
                				type: 'line',
                				lineStyle: {type: 'solid', width: 0.5},
                				itemStyle: {
                    				normal: {
                        				color: ETF5color
                        					}
                        			},
                        		lineStyle: {
                    				normal: {opacity: 0.5}
                					}
                				
            				},
            				{
				            	data: ROBT_data,
                				name: 'ROBT',
                				type: 'line',
                				lineStyle: {type: 'solid', width: 0.5},
                				itemStyle: {
                    				normal: {
                        				color: ETF6color
                        					}
                        			},
                        		lineStyle: {
                    				normal: {opacity: 0.5}
                					}
                				
            				},
            				
            				{
				            	data: BIKR_data,
                				name: 'BIKR',
                				type: 'line',
                				lineStyle: {type: 'dotted', width: 0.5},
                				itemStyle: {
                    				normal: {
                        				color: ETF8color
                        					}
                        			},
                        		lineStyle: {
                    				normal: {opacity: 0.5}
                					}
                				
            				}

            				]
				        
				    }, true);

				    

			     
			    </script>
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