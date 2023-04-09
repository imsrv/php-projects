<?
include('DB.php');
include('Chart.php');
include('config');

	$new_db = new DB;
	$new_db -> open("$db");
	list($userID,$acctype,$accesslevel) = $new_db -> onLogin("xxx","xxx");
	$new_db -> onQueryVisitors($userID);
	$weekly = $new_db -> onQueryWeekly(2);
	$monthly = $new_db -> onQueryMonthly($userID);
	$referrers = $new_db -> onQueryReferrer($userID);
	$colordepth = $new_db -> onQueryColor($userID);
	$browsers = $new_db -> onQueryBrowser($userID);
	$engine = $new_db -> onQueryEngine($userID);
	$query = $new_db -> onQueryQuery($userID);

	$pie = new PieChart;
	$pie -> setData($monthly);
	$pie -> setColors(array("88aaee","88ddff","55dd55","ffff66","ffaa00"));
	$colors = $pie -> getColors();
	$percents = $pie -> percents();
	$pie -> drawChart(1);

	$vchart = new VChart;
	$vchart -> imageURL = $image_path;
	$vchart -> setData($monthly);
	$vchart -> drawChart();
	
	$v1chart = new VChart;
	$v1chart -> imageURL = $image_path;
	$v1chart -> setData($weekly);
	$v1chart -> drawChart();
	
	$header = array("color","count","count","%");
	
	$hchart = new HChart;
	$hchart -> imageURL = $image_path;
	$hchart -> setData($query); 
	$hchart -> drawChart($header,1,1);

?>
