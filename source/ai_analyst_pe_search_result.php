<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: '.'ai_analyst_login.php'); //not logged in
	}
 //Abfrage der Nutzer ID vom Login
$user_id = $_SESSION['userid'];
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$q = $_GET['q'];
//table pagination:
$page = $_GET['page'];
//echo 'GETPAGE=' . $page;
// if no page specified, start with page 1
if ($page == '') {$page = 1; } // if no page specified, start with page 1
// only paying users can swith:
if ($usertype==2) {$page = 1;} //free users will be forced to page 1
//echo 'PAGE=' . $page;

//table sort:
$sort = $_GET['sort'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	
</head>



<body>

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
//get results from database:
//pagination:
$entryfrom = (intval($page) - 1) * 10 ;
$limit_string = ' ' . $sort . ' LIMIT ' . $entryfrom . ',10;';
//echo $q . $limit_string . '<br><br>';

// calculate number of results:
$result2 = mysqli_query($connection, $q);

// do the following only if the query delivers a result:
error_reporting(0);
if (mysqli_num_rows($result2)<>0) {

$all_property2 = array();
while ($property2 = mysqli_fetch_field($result2)) {array_push($all_property2, $property2->name);}

$counter = 0;
while ($row = mysqli_fetch_array($result2)) {$counter = $counter +1;}
echo '<p class="font-lato fs-13" align="left">This search returned ' . number_format($counter) . ' results.';

//echo '<br>'.$q . $limit_string;
//echo '<br>sort:'.$sort;

// now retrieve search results:
$result = mysqli_query($connection, $q . $limit_string);

$all_property = array();  //declare an array for saving property
//showing property
echo '<div class="table-responsive">
			<table class="table table-hover font-lato fs-12 table-light border">
				<thead>
					<tr>';  //initialize table tag

while ($property = mysqli_fetch_field($result)) {
		if (($property->name<>'Ranking') && ($property->name<>'SYMBOL_2') && ($property->name<>'Founders') && ($property->name<>'Top 5 Investors') && ($property->name<>'Total Funding Amount Currency (in USD)') && ($property->name<>'IPqwery - Patents Granted') && ($property->name<>'Aberdeen - IT Spend Currency (in USD)') && ($property->name<>'SimilarWeb - Monthly Visits') && ($property->name<>'SimilarWeb - Monthly Visits Growth') && ($property->name<>'SimilarWeb - Global Traffic Rank') && ($property->name<>'Apptopia - Number of Apps') && ($property->name<>'Apptopia - Downloads Last 30 Days') && ($property->name<>'Description') && ($property->name<>'Last Funding Date') && ($property->name<>'Last Funding Amount Currency (in USD)') && ($property->name<>'Founded Date')  ) 
			{
			// build sort string:
			$sort_str_asc = "'&sort=ORDER BY `".$property->name."` ASC'";
			$sort_str_desc = "'&sort=ORDER BY `".$property->name."` DESC'";
			$sort_btn_asc = '<a href="javascript:showResult('.$sort_str_asc.')"><span style="color:silver"><i class="glyphicon glyphicon-triangle-top"></i></a>';
			$sort_btn_desc = '<a href="javascript:showResult('.$sort_str_desc.')"><span style="color:silver"><i class="glyphicon glyphicon-triangle-bottom"></i></a>';
			// output header:
			echo '<th>' . $sort_btn_asc.'<span style="color:silver">&nbsp;|&nbsp;'.$sort_btn_desc. '</span><br>' . $property->name .'</th>';
			//echo '<th>' . $property->name . '&nbsp;'.$sort_btn_desc.'&nbsp;'.$sort_btn_asc.'</th>';  //get field name for header
			
			}
		array_push($all_property, $property->name);  //save those to array
		}
echo '<th>&nbsp;</th></thead>
		<tbody>'; //end tr tag
//showing all data
$entries = 0;
while ($row = mysqli_fetch_array($result)) {
	echo "<tr>";
		foreach ($all_property as $item) {
			// website link:
			if ($item==='Website'){
				echo '<td><a href="' . $row[$item] . '" target="_">' . $row[$item] . '</a></td>'; //get items using property value
			}
			if ($item==='Symbol') {
        							echo '<td><p class="font-lato fs-10"><b>' . $row[$item] . '</b></p></td>';
        					} 
        	if ($item==='Name') {
        							echo '<td><b>' . $row[$item] . '</b></td>';
        					} 
			// all other output:
			if (($item<>'Website') && ($item<>'Symbol') && ($item<>'Name') && ($item<>'Founders') && ($item<>'Top 5 Investors') && ($item<>'Total Funding Amount Currency (in USD)') && ($item<>'IPqwery - Patents Granted') && ($item<>'Aberdeen - IT Spend Currency (in USD)') && ($item<>'SimilarWeb - Monthly Visits') && ($item<>'SimilarWeb - Monthly Visits Growth') && ($item<>'SimilarWeb - Global Traffic Rank') && ($item<>'Apptopia - Number of Apps') && ($item<>'Apptopia - Downloads Last 30 Days') && ($item<>'Description') && ($item<>'Last Funding Date') && ($item<>'Last Funding Amount Currency (in USD)') && ($item<>'Founded Date')  ) {
				echo '<td>' . $row[$item] . '</td>'; //get items using property value
			}

		}

if ($row['Ownership']=='PUBLIC') {echo '<td><a href="ai_analyst_home_stock_profile.php?stocksymbol=' . $row[0] .' " class="btn btn-default btn-sm" target="_"><i class="fa fa-stack-exchange white"></i> Profile </a></th';}

if ($row['Ownership']<>'PUBLIC') {echo '<td><a href="ai_analyst_pe_companies_profile.php?symbol=' . $row[0] .' " class="btn btn-default btn-sm" target="_"><i class="fa fa-stack-exchange white"></i> Profile </a></th';}
echo '</tr>';
// count number of entries:
$entries = $entries + 1;

}

echo '</table>';
}
else {
	echo '<p class="font-lato fs-15">Please specify your search.</p>';
}


?>



	

</body>
</html>