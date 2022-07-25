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



			
			<!-- Chart -->
			<div class="container">
				
					<div class="container">

					<!-- <h3><span>My Portfolios</span></h3>
					<hr>-->

					<!-- Chart container -->
					<br><br>
					<!-- Chart container -->
					<div id="main" style="width: 1000px;height:650px;"></div>

				<?php
				// links:
				echo '
				<h6 align="center">
					<a href="ai_analyst_home_stockchart.php?stocksymbol=BOTZ">BOTZ</a> |
					<a href="ai_analyst_home_stockchart.php?stocksymbol=AIEQ">AIEQ</a> |
					<a href="ai_analyst_home_stockchart.php?stocksymbol=ROBT">ROBT</a> |
					<a href="ai_analyst_home_stockchart.php?stocksymbol=UBOT">UBOT</a> |
					<a href="ai_analyst_home_stockchart.php?stocksymbol=AIQ">AIQ</a> |
					<a href="ai_analyst_home_stockchart.php?stocksymbol=AIIQ">AIIQ</a> |
					<a href="ai_analyst_home_stockchart.php?stocksymbol=BIKR">BIKR</a> |	
					<a href="ai_analyst_home_stockchart.php?stocksymbol=IRBO">IRBO</a> |
					<a href="ai_analyst_home.php">PERFORMANCE COMPARISON</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
				';

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
				        backgroundColor: '#ffff', //#fff #2c343c
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
				                type: 'inside',
				                xAxisIndex: [0, 1],
				                start: 50,
				                end: 100
				            },
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


		
		

		

		




</body>
</html>