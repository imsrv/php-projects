<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
			$query = "Select user_id from shipto where user_id = '$PHP_AUTH_USER'";
			$select = mysql($database,$query);
			$rows = mysql_numrows($select);
			if($rows == 0){
				$query = "Insert into shipto ";
				$query .= "(user_id,lname,fname,addr1,addr2,city,province,pcode,country,email,phone,fax) ";
				$query .= "values ";
				$query .= "('$PHP_AUTH_USER','$lname','$fname','$addr1','$addr2','$city','$province','$pcode','$country','$email','$phone','$fax')";
				$insert = mysql($database,$query);
				echo mysql_error();
			}else{
				$query = "Update shipto set ";
				$query .= "lname='$lname',";
				$query .= "fname='$fname',";
				$query .= "addr1='$addr1',";
				$query .= "addr2='$addr2',";
				$query .= "city='$city',";
				$query .= "province='$province',";
				$query .= "pcode='$pcode',";
				$query .= "country='$country',";
				$query .= "email='$email',";
				$query .= "phone='$phone',";
				$query .= "fax='$fax' ";
				$query .= "where user_id = '$PHP_AUTH_USER'";
				$update = mysql($database,$query);
				echo mysql_error();
			}
			if(isset($prev_action)){
				$action = $prev_action;
			}else{
				$action = "Invoice";
			}
?>