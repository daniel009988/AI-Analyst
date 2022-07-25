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

// from save page form post here:
$userquery_id = $_POST["userquery_id"];
$userquery_name = $_POST["userquery_name"];
$userquery_sql = $_POST["userquery_sql"];

// from home page with ID in url:
$userqueryurl_id = $_GET["userqueryid"];

// if only ID given, we query the details from the server:
if ($userqueryurl_id<>'') {
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
	// now retrieve search results:
	$sqlretrievestring = 'SELECT ID, Searchname, SearchSQL FROM USERS_SEARCH_TABLE WHERE ID=' . $userqueryurl_id . ' AND USER_ID = ' . $user_id ;
	$result = mysqli_query($connection, $sqlretrievestring);
	$all_property = array();  //declare an array for saving property
	while ($property = mysqli_fetch_field($result)) {
			array_push($all_property, $property->name);  //save those to array
			}
	//showing all data
	
	while ($row = mysqli_fetch_array($result)) {
		$userquery_id = $row['ID'];
		$userquery_name = $row['Searchname'];
		$userquery_sql = urldecode($row['SearchSQL']);

		}
}
// end only ID given


//wurde save query gedrückt und kein url übergeben, dann müssen wir speichern:
if (($userquery_name <> '') && ($userquery_sql <> '') ) {
	//echo 'userquery_name:' . $userquery_name;
	//echo 'userquery_sql:' . $userquery_sql;
	//echo 'userquery_id:' . $userquery_id;
	//insert into sql server!
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
	// if new ID, means new entry:
	if ($userquery_id=='') {
		$sqlinsertstring = "INSERT INTO USERS_SEARCH_TABLE (`USER_ID`, `Searchname`, `SearchSQL`) VALUES ('" . $user_id . "','" . $userquery_name . "','" . urlencode($userquery_sql) . "');";
	}
	// otherwise update record:
	if ($userquery_id<>'') {
		$sqlinsertstring = "UPDATE USERS_SEARCH_TABLE SET `Searchname`='" . $userquery_name . "', `SearchSQL`='" . urlencode($userquery_sql) . "' WHERE ID=" . $userquery_id;
	}
	if ($connection->query($sqlinsertstring) === TRUE) {
		//echo "SQL record created successfully";
	} else {
		echo "Error: " . $sqlinsertstring . "<br>" . $connection->error;
	}

	$connection->close();
}
//ende speichern

include 'include_menu.php';
?>

<script>
function urldecode(url) {
	return decodeURIComponent(url.replace(/\+/g, ' '));
	}
</script>

			<!-- SCROLL TO TOP -->
			<a href="#" id="toTop"></a>
			<!-- PRELOADER -->
			<div id="preloader">
				<div class="inner">
					<span class="loader"></span>
				</div>
			</div><!-- /PRELOADER -->
	

			<!-- MAIN PAGE -->
			<div class="container">
				<div class="container">
					<br>
					<!-- HEADER -->
						<div class="heading-title heading-border-bottom heading-color">
							<h4>Research Private VC/PE Backed AI Companies - Advanced Search </h4>
						</div> 
					
					<!-- WELCOME TEXT -->
					<p class="font-lato fs-15">With the advanced search function you can build comprehensive search queries. First, choose the search type and then add conditions. You can combine AND and OR operations. Press enter to see the results. You can also save and load your searches. <strong>Use "%" at the end/beginning of search terms as a placeholder.</strong></p>

					<?php 

						if ($usertype==2) {echo '
							<img src="assets/images/search_locked.png" alt="" width="100%"/>
							<p class="font-lato fs-15"><i class="fa fa-lock"></i> This is a premium feature and only available for subscribers. <a href="ai_analyst_subscription.php#subscribe">Subscribe now</a></p>

							';}
					?>

					<table width=100% border=0>
					<tr>
					<td width=15% valign="top">
				
					

							<!-- My searches -->	
							<?php
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
							// now retrieve search results:
							$result = mysqli_query($connection, 'SELECT ID, Searchname, SearchSQL FROM USERS_SEARCH_TABLE WHERE USER_ID=' . $user_id);
							$all_property = array();  //declare an array for saving property
							while ($property = mysqli_fetch_field($result)) {
									array_push($all_property, $property->name);  //save those to array
									}
							//showing all data
							echo '<table class="font-lato fs-12" width=200>';
							echo '<tr style="border-bottom: thin solid;"><td width=100%><b>SAVED SEARCHES<b></td></tr>';
							while ($row = mysqli_fetch_array($result)) {
											echo '<tr>';
											echo '<td><a href="#" onClick="loaduserSQL(\'' . $row['ID'] . '\',\'' . $row['Searchname'] . '\',\'' . $row['SearchSQL'] .  '\')" >' . $row['Searchname'] . '</a>'; //search name link
											echo '</td><td width=20><a href="delete_search.php?deleteid=' . $row['ID'] . '"><i class="fa fa-trash"></i></a>'; //delete button
											echo '</td></tr>';
								}
							echo '</table>';

							?>	
							<!-- End My searches -->
					
					</td>
					<td width=10></td>
					<td>


					<!-- SEARCH QUERY CONTAINER -->
					<?php 

						if ($usertype<>2) {echo '

					<div id="rqb"> </div>

					</td></tr></table>

					<!--<div><textarea id="debug" cols="80" rows="10">debug output</textarea></div>
					<div id="sqlquery_old"></div>
					<div id="rempage_old">1</div>-->

					<!-- SEARCH FUNCTIONS -->
					<script>

					function loaduserSQL(queryID, queryname, sqlstring) {
						queryname = urldecode(queryname);
						sqlstring = urldecode(sqlstring);
						
						document.getElementById("userquery_sql").setAttribute(\'value\',sqlstring);
						document.getElementById("userquery_name").setAttribute(\'value\',queryname);
						document.getElementById("userquery_id").setAttribute(\'value\',queryID);
						document.getElementById("sqlquery").innerHTML = sqlstring;

						showResult();
					}

					function nextPage() {
						seite = document.getElementById("rempage").value;
						seite = parseInt(seite) + 1;
						document.getElementById("rempage").value = seite;
						document.getElementById("pagezeiger").innerHTML = "Page " +seite;
						showResult();
					}
					function previousPage() {
						seite = document.getElementById("rempage").value;
						seite = parseInt(seite) - 1;
						if (seite<1) {seite=1;}
						document.getElementById("rempage").value = seite;
						document.getElementById("pagezeiger").innerHTML = "Page " +seite;
						showResult();
					}
					function firstPage() {
						seite = 1;
						document.getElementById("rempage").value = seite;
						document.getElementById("pagezeiger").innerHTML = "Page " +seite;
						showResult();
					}

					function printResult() {
						str = document.getElementById("userquery_sql").value;
						//window.location.href = "ai_analyst_pe_search_print.php?q="+str;
						window.open("ai_analyst_pe_search_print.php?q="+str, "_blank");

					}

					function showResult(sort) {
						//str = document.getElementById("sqlquery").innerHTML;
						str = document.getElementById("userquery_sql").value;
						//sort = "&sort=ORDER BY Country DESC";
						

					    if (str == "") {
					        document.getElementById("searchresult").innerHTML = "";
					        return;
					    } else {
					        if (window.XMLHttpRequest) {
					            // code for IE7+, Firefox, Chrome, Opera, Safari
					            xmlhttp = new XMLHttpRequest();
					        } else {
					            // code for IE6, IE5
					            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					        }
					        xmlhttp.onreadystatechange = function() {
					            if (this.readyState == 4 && this.status == 200) {
					                document.getElementById("searchresult").innerHTML = this.responseText;
					            }
					        };

					        xmlhttp.open("GET","ai_analyst_pe_search_result.php?q="+str+"&page=" + document.getElementById("rempage").value+sort,true);
					        xmlhttp.send();

					    }
					}

					function restrict_letters(e) {
				    var keyCode = e . keyCode == 0 ? e . charCode : e . keyCode;
				    // only 0 to 9
				    if (keyCode < 48 && keyCode > 57) {
				        return false;
				    	}
					}

					</script>

					<!-- SEARCH RESULT -->
					<!-- HEADER -->

					<table width=100%>
					<tr style="border-bottom: 1px solid grey">
					<td><h5><span><i class="fa fa fa-search"></i> SEARCH RESULTS</span></h5></td>
					<td align="right" valign="top" width=50%>
						<form class="m-0 font-lato fs-13" method="post" action="ai_analyst_pe_search.php" autocomplete="off">
						<input type="hidden" id="sqlquery" value="test" name="formsqlquery"/>
						<input type="hidden" id="rempage" value="1" name="hiddencontainer" value=""/>
						<input type="hidden" id="userquery_id" name="userquery_id" value="' . $userquery_id . '"/>
						<input type="text" id="userquery_name" name="userquery_name" pattern="[0-9a-zA-Z ]*" value="' . $userquery_name . '" required="" placeholder="Enter a name" size="30"/>
						<input type="hidden" id="userquery_sql" name="userquery_sql" value="' . $userquery_sql . '"/>
						<button class="btn btn-primary btn-sm">SAVE SEARCH</button>
						
						</form>
					
					<td valign="top" align="right" width=70><a href="ai_analyst_pe_search.php"><button class="btn btn-primary btn-sm">NEW SEARCH</button></a></td>
					<td valign="top" align="right" width=50><a href="#"><button onClick="printResult()" class="btn btn-primary btn-sm">PRINT</button></a></td>
				
					</tr></table>
					
					<div id="searchresult"><p class="font-lato fs-15">Please specify your search.</p></div>
					';}



					
					// paying users:
					if ($usertype<>2) {
						$entryfrom = (intval($page) - 1) * 10 + 1;
						$entryto = $entryfrom + $entries - 1;
						$nextpage = intval($page) + 1;
						$previouspage = intval($page) - 1;
						echo '<table width=100%><tr>';
						echo '<td width=50%><p id="pagezeiger" class="font-lato fs-15"></p></td>';
						echo '<td width=50% align="right"><p class="font-lato fs-15">';
						// back to start:
						echo '<a href="#d"><button type="button" onClick="firstPage()" class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left"></i>Back to start</button></a>';
						// previous 10 
						echo '<a href="#d"><button type="button" onClick="previousPage()" class="btn btn-primary btn-sm"><i class="fa fa-angle-left"></i>Previous 10 entries</button></a>';
						// next 10
						echo '<a href="#d"><button type="button" onClick="nextPage()" class="btn btn-primary btn-sm">Next 10 entries <i class="fa fa-angle-right"></i></button></a>';
						echo '</p></td></tr></table>';
						
					} 
					?>


						

				
		<!-- /wrapper -->


		<!-- SHOW SEARCH RESULT WHEN RELOADED: -->
		<?php
			if ($userquery_id <> '') {
				echo '
				<script type="text/javascript">
					loaduserSQL(\'' . $user_id . '\',\'' . $userquery_name . '\',\'' . urlencode($userquery_sql) . '\')
						</script>
				';
			}
		?>
		<!-- /ENDE -->



		<!-- JAVASCRIPT FILES -->
		<script>var plugin_path = 'assets/plugins/';</script>
		<script src="assets/js/scripts.js"></script>
		

		

		




</body>
</html>