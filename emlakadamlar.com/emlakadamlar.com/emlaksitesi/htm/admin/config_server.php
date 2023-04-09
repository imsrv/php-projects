<? //require_once("secure.php"); ?>
<?
	if(($_SERVER[SERVER_NAME]=='test.hazarajans.net')&&($_SERVER[REMOTE_ADDR]!='212.174.53.223')){
		echo "<script>alert('Test alani geçici olarak kapalidir çalisir durumdaki adrese yönleniyorsunuz...');location.href='http://www.emlakadamlar.com';</script>";
		exit;
	}
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "euskadita";
	$dbname = "emlakadamlar";
	
	$connection = mysql_connect($dbhost,$dbuser,$dbpass);
	if ($connection) {
		mysql_select_db($dbname);

		$justIP   = $_SERVER[REMOTE_ADDR];
		$justDate = date("Ymd");
		$justTime = date("Hi");
		$justURI  = $_SERVER[REQUEST_URI];
		$justHost = $_SERVER[SERVER_NAME];
		if(session_id()){$strSession = session_id();
		}else{$strSession = "";}
		if(getenv("HTTP_REFERER")){$strReferer = getenv("HTTP_REFERER");
		}else{$strReferer = "";}
		$strQuery = "INSERT INTO tblCounter(counter_ip,counter_date,counter_time,counter_uri,domain,session,referer) "
			."VALUES ('$justIP','$justDate','$justTime','$justURI','$justHost','$strSession','$strReferer')";
		//echo $strQuery;
		if($justIP != '212.174.53.223'){
		mysql_query($strQuery);
		}
	}
	function showMessage($paramMessage) {
		echo "<script>alert('$paramMessage');</script>";
	}
	function goTo($paramLink) {
		echo "<script>window.location.href='$paramLink';</script>";
	}
	function getIp(){
		return $_SERVER[REMOTE_ADDR];
	}
	function getUser(){
		return $_COOKIE[user];
	}
	function setUser($user){
		setcookie("user",$user);
	}
	function getStrDate(){
		return date("Ymd");
	}
	function getDates(){
		return date("d.m.Y");
	}
	function getDateToStr(){
		return "01.02.2005";
	}
	function getLoginCheck($user,$pass){
		$strUserName=urlencode($user);
		$strUserPass=urlencode($pass);
		$strUserPass=md5($strUserPass);
		$query = "SELECT * FROM tblAdminUser WHERE user_user='$strUserName' AND user_pass='$strUserPass'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return 1;
		}else{
			return 0;
		}
	}
	function getUserActive($user){
		$query = "SELECT * FROM tblAdminUser WHERE user_user='$user'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			if(mysql_result($results,0,"user_active")==1){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	function getSetPassword($oldpass,$newpass1,$newpass2){
		if(getLoginCheck(getUser(),$oldpass)==1){
			if($newpass1==$newpass2){
				if(strlen($newpass1)<5){
					showMessage("Yeni Þifre en az 5 karakter olmalýdýr");				
				}else{
					$query = "UPDATE tblAdminUser SET user_pass='".md5(urlencode($newpass1))."' WHERE user_user='".getUser()."'";
					$results = mysql_query($query);
					showMessage("Þifreniz deðiþtirildi");
					gotoReferer();
				}
			}else{
				showMessage("Yeni Þifreler ayný deðil");
			}
		}else{
			showMessage("Þifre yanlýþ");
		}
		$query = "SELECT * FROM tblAdminUser WHERE user_user='$strUserName' AND user_pass='strUserPass'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return 1;
		}else{
			return 0;
		}
	}
	function getReferer(){
		return getenv(HTTP_REFERER);
	}
	function gotoReferer(){
		echo "<script>location.href='".getReferer()."';</script>";
	}
	function getTypeName($id){
		$query = "SELECT * FROM tblType WHERE type_id='$id'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return mysql_result($results,0,"type_name");
		}else{
			return "";
		}
	}
	function getPriceTypeName($id){
		$query = "SELECT * FROM tblPriceType WHERE pricetype_id='$id'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return mysql_result($results,0,"pricetype_name");
		}else{
			return "";
		}
	}
	function getCityName($id){
		$query = "SELECT * FROM tblCity WHERE city_id='$id'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return mysql_result($results,0,"city_name");
		}else{
			return "";
		}
	}
	function getDistrictName($id){
		$query = "SELECT * FROM tblDistrict WHERE district_id='$id'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return mysql_result($results,0,"district_name");
		}else{
			return "";
		}
	}
	function getQuarterName($id){
		$query = "SELECT * FROM tblQuarter WHERE quarter_id='$id'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return mysql_result($results,0,"quarter_name");
		}else{
			return "";
		}
	}
	function getQuarterCityId($id){
		$query = "SELECT * FROM tblDistrict WHERE city_id='".getQuarterDistrictId($id)."'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return mysql_result($results,0,"district_city");
		}else{
			return 0;
		}
	}
	function getQuarterDistrictId($id){
		$query = "SELECT * FROM tblQuarter WHERE quarter_id='$id'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return mysql_result($results,0,"quarter_district");
		}else{
			return 0;
		}
	}
	function getIsCodeUse($code){
		$query = "SELECT * FROM tblRealty WHERE realty_code='$code'";
		$results = mysql_query($query);
		$num_rows = mysql_num_rows($results);
		if ($num_rows) {
			return 1;
		}else{
			return 0;
		}
	}
	function getUniqCode(){
		$code = rand(10000, 999999);
		//echo $code . "-" . getIsCodeUse($code) . "<br>";
		while (getIsCodeUse($code) == 1) {
			$code = rand(10000, 999999);
			//echo $code . "-" . getIsCodeUse($code) . "<br>";
		}
		return $code;
	}
	//echo getReferer();
?>