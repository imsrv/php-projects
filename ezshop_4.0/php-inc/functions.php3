<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
// Functions used in cart

function my_error ($error){
	if($error != ""){
		echo "<big> MySQL Reports an error...</big><br>\n";
		echo "<font color='red'>$error</font>";
	}
}

function TaxRate ($pcode,$state){

	$state = strtoupper($state);

	if($state == "CA"){
		if($pcode >= 91901 && $pcode <= 992200){
			echo "(San Diego County)";
			return(".0775");
		} else {
			echo "(California State)";
			return(".0725");
		}
	}
	echo "(No Tax this order)";
	return(0);
}

function ShippingCost ($pcode,$state,$quantity,$unit,$qunit){

	$pcode = substr($pcode,0,3);
	$state = strtoupper($state);
	$unit = strtoupper($unit);
	$pack6 = 4.53;
	$pack12 = 8.35;

	if($state == ""){
		return(0);
	}
	if($pcode == ""){
		return(0);
	}

	if($pcode >= 900 && $pcode <= 930){
	 if($unit == "CASE"){
	  if($qunit == 12){
	   $shipping = 8.75 + $pack12;
	  } else if($qunit == 6){
	   $shipping = 5.50 + $pack6;
	  }
	 }else{
	  $shipping = 0;
	 }
	}else if($pcode >= 931 && $pcode <= 938){
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 10.25 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 6.25 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}else if($pcode >= 939 && $pcode <= 954){
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 11.50 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 6.75 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}else if($pcode == 955){
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 13.50 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 7.75 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}else if($pcode >= 956 && $pcode <= 961){
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 11.50 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 6.75 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}else if($pcode >= 967 && $pcode <= 999){
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 46.00 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 29.00 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}else if($state == "CO" || $state == "NM" || $state == "ID" | $state == "WA"){
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 13.50 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 7.75 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}else if($state == "MO" || $state == "NE"){
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 16.75 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 9.25 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}else if($state == "IL" || $state == "WI"){
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 19.75 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 10.95 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}else {
		if($unit == "CASE"){
		 if($qunit == 12){
		  $shipping = 27.00 + $pack12;
		 } else if($qunit == 6){
		  $shipping = 17.00 + $pack6;
		 }
	 }else{
	  $shipping = 0;
	 }
	}
	return($shipping*$quantity);
}

function BuildDescription ($fields,$item_id){

	global $item_label,$table,$database;

	$field = explode("~",$fields);
	$row=0;
	$rows=count($field);
	// echo "$rows, $field[$row]";
	$value = "";
	while($row<$rows){
		$query = "Select $field[$row] from $table where $item_label = $item_id";
		$select = mysql($database,$query);
		if(mysql_error() != ""){
			echo "<p>Mysql reports an error: ".mysql_error();
			echo "<br>The query is: $query</p>\n";
		}
		$description = mysql_result($select,0,$field[$row]);
		// echo "Description: $description";
		if($description != ""){
			$value .= "$description";
			if($row < ($rows-1)){
				$value .= ", ";
			}
		}
		$row++;
	}

	return($value);
}

function EchoFormVars () {

	global $session,$user_id,$login,$checkout,$secure,$debug;
	echo "<input type='hidden' name='session' value='$session'>\n";
	if(isset($login)){
		echo "<input type='hidden' name='login' value='$login'>\n";
	}
	if(isset($checkout)){
		echo "<input type='hidden' name='checkout' value='$checkout'>\n";
	}
	if(isset($secure)){
		echo "<input type='hidden' name='secure' value='$secure'>\n";
	}
	if(isset($debug)){
		echo "<input type='hidden' name='debug' value='$debug'>\n";
	}
}
function EchoLinkVars () {

	global $session,$user_id,$login,$checkout,$secure,$debug;

	$link_vars = "session=$session";
	if(isset($login)){
		$link_vars .= "&login=$login";
	}
	if(isset($secure)){
		$link_vars .= "&secure=$secure";
	}
	if(isset($checkout)){
		$link_vars .= "&checkout=$checkout";
	}
	if(isset($debug)){
		$link_vars .= "&debug=$debug";
	}
	return($link_vars);
}

function SetCookies ($secured) {

	global $session,$exp,$SERVER_NAME,$login,$checkout,$secure,$debug;

	setcookie("session",$session,$exp,"/",$SERVER_NAME,$secured);
	if(isset($login)){
		setcookie("login",$login,$exp,"/",$SERVER_NAME,$secured);
	}
	if(isset($secure)){
		setcookie("secure",$secure,$exp,"/",$SERVER_NAME,$secured);
	}
	if(isset($checkout)){
		setcookie("checkout",$checkout,$exp,"/",$SERVER_NAME,$secured);
	}
	if(isset($debug)){
		setcookie("debug",$debug,$exp,"/",$SERVER_NAME,$secured);
	}
}
?>