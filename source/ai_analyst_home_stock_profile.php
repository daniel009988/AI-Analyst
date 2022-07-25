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
$stock_symbol = $_GET['stocksymbol'];

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



			
			<!-- Chart -->
			<div class="container">
				
					<div class="container">
					<br>
					<!-- HEADER -->
					<div class="heading-title heading-border-bottom heading-color">
						<h4><?php echo $stock_symbol; ?> Profile</h4>
					</div>
					
					
					<!-- LINKS -->
					<a href='#SUMMARY' class="font-lato fs-15">SUMMARY</a>&nbsp;|&nbsp;
					<a href='#EXPERTS' class="font-lato fs-15">EXPERT RATINGS</a>&nbsp; |&nbsp;
					<a href='#CHART' class="font-lato fs-15">CHART</a>&nbsp;|&nbsp;
					<a href='#GENERAL' class="font-lato fs-15">GENERAL INFORMATION</a>&nbsp;|&nbsp;
					<a href='#ANALYSTS' class="font-lato fs-15">ANALYST OPINION</a>&nbsp;|&nbsp;
					<a href='#FINANCIALS' class="font-lato fs-15">FINANCIALS</a>&nbsp;|&nbsp;
					<a href='#MULTIPLES' class="font-lato fs-15">SECTOR MULTIPLES</a>&nbsp;
					
					<a href="javascript:history.back()"><button type="button" class="btn btn-primary btn-sm">Go back</button></a>
					<a href="ai_analyst_portfolios_add.php?symbol=<?php echo $stock_symbol ?>"><button type="button" class="btn btn-primary btn-sm">Add to portfolio</button></a>

					
					
					<br><br>

					<!-- SUMMARY -->
					<div class="card card-default" id="SUMMARY">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa fa fa-home"></i><strong> SUMMARY</strong></h5>
						</div>
						<div class="card-block">
						<?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'summaryProfile.longBusinessSummary']); ?>
						<?php shortcode(['type' => 'comparison', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'virtual.name,virtual.lastUpdated,quote.fullExchangeName,quote.regularMarketChange,quote.regularMarketChangePercent,summaryDetail.marketCap,quote.fiftyTwoWeekLow,quote.fiftyTwoWeekHigh,defaultKeyStatistics.sharesOutstanding,quote.regularMarketVolume,summaryDetail.dividendRate']); ?>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>

					<!-- EXPERTS -->
					<div class="card card-default" id="EXPERTS">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-line-chart"></i><strong> SCORINGS, EXPERT REVIEWS AND RATINGS</strong></h5><a href="ai_analyst_know_scoring.php"><div class="font-lato fs-12">Learn more <i class="fa fa-info-circle"></i></div></a>
						</div>
						<div class="card-block">
							<?php 
							if ($usertype==2) {echo '
								<img src="assets/images/scoring_locked.png" alt="" />
								<p class="font-lato fs-15"><i class="fa fa-lock"></i> This is a premium feature and only available for subscribers. <a href="ai_analyst_subscription.php#subscribe">Subscribe now</a> or learn more about <a href="ai_analyst_know_scoring.php">our scoring</a>.</p>

								';}
							?>
							<?php 
							if ($usertype<>2) {
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
								//get results from database
								$result = mysqli_query($connection,"SELECT Symbol, Category, Name, `AI Sector`, `AI Focus`, `AI Strength`  FROM COMPANIES_TABLE WHERE Symbol= '$stock_symbol'");
								$all_property = array();  
								while ($property = mysqli_fetch_field($result)) {array_push($all_property, $property->name); } //save those to array
								
								while ($row = mysqli_fetch_array($result)) {
										$ai_sector = $row['AI Sector'];
										$ai_focus = $row['AI Focus'];
										$ai_strength = $row['AI Strength'];
								}

								echo '
								<div class="row">

								<div class="col-md-4" align="center">
								<h6>AI SECTOR SCORE</h6>
								<div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="100" data-percent="'.intval($ai_sector*20).'" data-width="10" data-animate="1700">
									<span class="fs-30">
										<span class="countTo" data-speed="1700">'.intval($ai_sector*20).'</span>
									</span>
								</div>
								</div>

								<div class="col-md-4" align="center">
								<h6>AI FOCUS SCORE</h6>
								<div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="100" data-percent="'.intval($ai_focus*20).'" data-width="10" data-animate="1700">
									<span class="fs-30">
										<span class="countTo" data-speed="1700">'.intval($ai_focus*20).'</span>
									</span>
								</div>
								</div>

								<div class="col-md-4" align="center">
								<h6>AI STRENGTH SCORE</h6>
								<div class="piechart" data-color="#2980b9" data-trackcolor="rgba(0,0,0,0.04)" data-size="100" data-percent="'.intval($ai_strength*20).'" data-width="10" data-animate="1700">
									<span class="fs-30">
										<span class="countTo" data-speed="1700">'.intval($ai_strength*20).'</span>
									</span>
								</div>
								</div>
								</div>
							
							

							';}
							?>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>

					<!-- CHART -->
					<div class="card card-default" id="CHART">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-bar-chart"></i><strong> CHART</strong></h5>
						</div>
						<div class="card-block">
						<div id="main" style="width: 100%;height:650px;"></div>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>

				

					<!-- BUSINESS SUMMARY -->
					<div class="card card-default" id="GENERAL">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-bar-chart-o"></i><strong> GENERAL INFORMATION</strong></h5>
						</div>
						<div class="card-block">
						
						<h5>&nbsp;&nbsp;&nbsp;&nbsp;Key Statistics</h5>
						<table width="100%">
						<tr>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.enterpriseValue']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.profitMargins']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.floatShares']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.sharesOutstanding']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.sharesShort']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.sharesShortPriorMonth']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.heldPercentInsiders']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.heldPercentInstitutions']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.shortRatio']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.shortPercentOfFloat']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.bookValue']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.priceToBook']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.earningsQuarterlyGrowth']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.netIncomeToCommon']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.trailingEps']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.forwardEps']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.pegRatio']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.lastSplitFactor']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.enterpriseToRevenue']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'defaultKeyStatistics.enterpriseToEbitda']); ?></td>
						</tr>


						</table>

						
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>
					<!-- BUSINESS SUMMARY -->


 					<!-- FINANCIALS -->
					<div class="card card-default" id="ANALYSTS">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-user"></i><strong> FINANCIAL ANALYSTS OPIONON</strong></h5>
						</div>
						<div class="card-block">
							<table width="100%">
						<tr>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.targetHighPrice']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.targetLowPrice']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.targetMeanPrice']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.targetMedianPrice']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.recommendationMean']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.recommendationKey']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.numberOfAnalystOpinions']); ?></td>
						</tr>
					</table>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>


					
					<!-- GENERAL -->
					<div class="card card-default" id="FINANCIALS">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-bar-chart-o"></i><strong> FINANCIAL DATA</strong></h5>
						</div>
						<div class="card-block">
							<table width="100%">
						<tr>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.totalCash']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.totalCashPerShare']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.ebitda']); ?></td>
							<td width="25%"><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.totalDebt']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.quickRatio']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.currentRatio']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.totalRevenue']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.debtToEquity']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.revenuePerShare']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.returnOnAssets']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.returnOnEquity']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.grossProfits']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.freeCashflow']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.operatingCashflow']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.earningsGrowth']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.revenueGrowth']); ?></td>
						</tr>
						<tr>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.grossMargins']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.ebitdaMargins']); ?></td>
							<td><?php shortcode(['type' => 'table', 'symbol' => $stock_symbol, 'template' => 'basic', 'fields' => 'financialData.operatingMargins']); ?></td>
							<td></td>
						
						</tr>


						</table>




						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>
					

					<!-- MULTIPLES -->
					<div class="card card-default" id="MULTIPLES">
						<div class="card-heading card-heading-transparent">
							<h5><i class="fa fa-sitemap"></i><strong><strong> SECTOR MULTIPLES</strong></h5>
						</div>
						<div class="card-block">
						<?php 
						if ($usertype==2) {echo '
							<img src="assets/images/multiples_locked.png" alt="" />
							<p class="font-lato fs-15"><i class="fa fa-lock"></i> This is a premium feature and only available for subscribers. <a href="ai_analyst_subscription.php#subscribe">Subscribe now</a></p>

							';}
						?>
						<?php 
						if ($usertype<>2) {echo '
							
							<p class="font-lato fs-15">Content coming soon.</p>

							';}
						?>
						</div>
						<div class="card-footer card-footer-transparent">
						</div>
					</div>
					

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
				$result = mysqli_query($connection,"SELECT DATE_FORMAT(Date,'%Y-%m-%d') AS Date, Open, Close, Low, High, Volume FROM 42_schema.STOCKS_TABLE WHERE Symbol='$stock_symbol';");
				$all_property = array();  //declare an array for saving property
				//showing property
				while ($property = mysqli_fetch_field($result)) {
    					array_push($all_property, $property->name);  //save those to array
						}
				//showing all data
				$data = '[';
				while ($row = mysqli_fetch_array($result)) {
					$data = $data . '["' . $row['Date'] . '",' . $row['Open'] . ',' . $row['Close'] . ',' . $row['Low'] . ',' . $row['High'] . ',' . $row['Volume'] . '],';
				//	$pf_symbols = $pf_symbols . $row['SYMBOL'] . ',';
					}
				$data = substr($data,0, -1);
				$data = $data . ']';
				?>
    
			    <script type="text/javascript">
			        // based on prepared DOM, initialize echarts instance
			        var myChart = echarts.init(document.getElementById('main'));

			        var upColor = '#27ae60'; // '#00da3c';
			        var downColor = '#c0392b'; //'#ec0000';

			        // split data in OCHL and Volume:
			        function splitData(rawData) {
			            var categoryData = [];
			            var values = [];
			            var volumes = [];
			            for (var i = 0; i < rawData.length; i++) {
			                categoryData.push(rawData[i].splice(0, 1)[0]);
			                values.push(rawData[i]);
			                volumes.push([i, rawData[i][4], rawData[i][0] > rawData[i][1] ? 1 : -1]);
			                }

			            return {
			                categoryData: categoryData,
			                values: values,
			                volumes: volumes
			                };
			        }

			        function calculateMA(dayCount, data) {
			            var result = [];
			            for (var i = 0, len = data.values.length; i < len; i++) {
			                if (i < dayCount) {
			                    result.push('-');
			                    continue;
			                }
			                var sum = 0;
			                for (var j = 0; j < dayCount; j++) {
			                    sum += data.values[i - j][1];
			                }
			                result.push(+(sum / dayCount).toFixed(3));
			            }
			            return result;
			        }

			        //load data:
			        var data = splitData(<?php echo $data ?>);

				    myChart.setOption(option = {
				        backgroundColor: '#ffffff', //#ffff #2c343c
				        animation: false,
				        title: {
				        text: 'OHLC Chart for <?php echo $stock_symbol ?>',
				        left: 0
				        },
				        legend: {
				            bottom: 10,
				            left: 'center',
				            data: ['<?php echo $stock_symbol ?>', 'MA5', 'MA10', 'MA20', 'MA30']
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
				            },
				            position: function (pos, params, el, elRect, size) {
				                var obj = {top: 10};
				                obj[['left', 'right'][+(pos[0] < size.viewSize[0] / 2)]] = 30;
				                return obj;
				            }
				            // extraCssText: 'width: 170px'
				        },
				        axisPointer: {
				            link: {xAxisIndex: 'all'},
				            label: {
				                backgroundColor: '#777'
				            }
				        },
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
				        brush: {
				            xAxisIndex: 'all',
				            brushLink: 'all',
				            outOfBrush: {
				                colorAlpha: 0.1
				            }
				        },
				        visualMap: {
				            show: false,
				            seriesIndex: 5,
				            dimension: 2,
				            pieces: [{
				                value: 1,
				                color: downColor
				            }, {
				                value: -1,
				                color: upColor
				            }]
				        },
				        grid: [
				            {
				                left: '10%',
				                right: '8%',
				                height: '50%'
				            },
				            {
				                left: '10%',
				                right: '8%',
				                top: '63%',
				                height: '16%'
				            }
				        ],
				        xAxis: [
				            {
				                type: 'category',
				                data: data.categoryData,
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
				                gridIndex: 1,
				                data: data.categoryData,
				                scale: true,
				                boundaryGap : false,
				                axisLine: {onZero: false},
				                axisTick: {show: false},
				                splitLine: {show: false},
				                axisLabel: {show: false},
				                splitNumber: 20,
				                min: 'dataMin',
				                max: 'dataMax'
				                // axisPointer: {
				                //     label: {
				                //         formatter: function (params) {
				                //             var seriesValue = (params.seriesData[0] || {}).value;
				                //             return params.value
				                //             + (seriesValue != null
				                //                 ? '\n' + echarts.format.addCommas(seriesValue)
				                //                 : ''
				                //             );
				                //         }
				                //     }
				                // }
				            }
				        ],
				        yAxis: [
				            {
				                scale: true,
				                splitArea: {
				                    show: true
				                }
				            },
				            {
				                scale: true,
				                gridIndex: 1,
				                splitNumber: 2,
				                axisLabel: {show: false},
				                axisLine: {show: false},
				                axisTick: {show: false},
				                splitLine: {show: false}
				            }
				        ],
				        dataZoom: [
				            
				            {
				                show: true,
				                xAxisIndex: [0, 1],
				                type: 'slider',
				                top: '85%',
				                start: 50,
				                end: 100
				            }
				        ],
				        series: [
				            {
				                name: '<?php echo $stock_symbol ?>',
				                type: 'candlestick',
				                data: data.values,
				                itemStyle: {
				                    normal: {
				                        color: upColor,
				                        color0: downColor,
				                        borderColor: null,
				                        borderColor0: null
				                    }
				                },
				                tooltip: {
				                    formatter: function (param) {
				                        param = param[0];
				                        return [
				                            'Date: ' + param.name + '<hr size=1 style="margin: 3px 0">',
				                            'Open: ' + param.data[0] + '<br/>',
				                            'Close: ' + param.data[1] + '<br/>',
				                            'Low: ' + param.data[2] + '<br/>',
				                            'High: ' + param.data[3] + '<br/>'
				                        ].join('');
				                    }
				                }
				            },
				            {
				                name: 'MA5',
				                type: 'line',
				                data: calculateMA(5, data),
				                smooth: true,
				                lineStyle: {
				                    normal: {opacity: 0.5}
				                }
				            },
				            {
				                name: 'MA10',
				                type: 'line',
				                data: calculateMA(10, data),
				                smooth: true,
				                lineStyle: {
				                    normal: {opacity: 0.5}
				                }
				            },
				            {
				                name: 'MA20',
				                type: 'line',
				                data: calculateMA(20, data),
				                smooth: true,
				                lineStyle: {
				                    normal: {opacity: 0.5}
				                }
				            },
				            {
				                name: 'MA30',
				                type: 'line',
				                data: calculateMA(30, data),
				                smooth: true,
				                lineStyle: {
				                    normal: {opacity: 0.5}
				                }
				            },
				            {
				                name: 'Volume',
				                type: 'bar',
				                xAxisIndex: 1,
				                yAxisIndex: 1,
				                data: data.volumes
				            }
				        ]
				    }, true);

				    // myChart.on('brushSelected', renderBrushed);

				    // function renderBrushed(params) {
				    //     var sum = 0;
				    //     var min = Infinity;
				    //     var max = -Infinity;
				    //     var countBySeries = [];
				    //     var brushComponent = params.brushComponents[0];

				    //     var rawIndices = brushComponent.series[0].rawIndices;
				    //     for (var i = 0; i < rawIndices.length; i++) {
				    //         var val = data.values[rawIndices[i]][1];
				    //         sum += val;
				    //         min = Math.min(val, min);
				    //         max = Math.max(val, max);
				    //     }

				    //     panel.innerHTML = [
				    //         '<h3>STATISTICS:</h3>',
				    //         'SUM of open: ' + (sum / rawIndices.length).toFixed(4) + '<br>',
				    //         'MIN of open: ' + min.toFixed(4) + '<br>',
				    //         'MAX of open: ' + max.toFixed(4) + '<br>'
				    //     ].join(' ');
				    // }

				    //myChart.dispatchAction({
				    //    type: 'brush',
				    //    areas: [
				    //        {
				    //            brushType: 'lineX',
				    //            coordRange: ['2013-01-24', '2013-06-13'],
				    //            xAxisIndex: 0
				    //        }
				    //    ]
				    //});

			     
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

		<!-- JAVASCRIPT FILES -->
		<script>var plugin_path = 'assets/plugins/';</script>
		<script src="assets/js/scripts.js"></script>
		
		

		

		




</body>
</html>