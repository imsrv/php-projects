<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
		/* variables to check */
		/* separated by pipe*/
		/* must be entered in variable_name|Output_name pairs */
		$check="fname|First Name|lname|Last Name|addr1|Address|city|City|province|State|pcode|Zip|country|Country|phone|Telephone|email|E-Mail";
		/* convert $check to an array */
		$i=0;
		$tmp=strtok($check,"|");
		while($tmp){
		 $v[$i]=$tmp;
		 $i++;
		 $tmp=strtok("|");
		}
		/* loop through array, check for emptys */
		$row=0;
		while($row<count($v)){
			$temp=$v[$row];
			if($$temp==""){
				$label=$v[$row+1];
				$continue="-1";
			}
			$row ++;
			$row ++;
		}
		if($continue == "-1"){
			$message = "The form was not filled out properly!<br><ul>\n";
			$i=0;
			$tmp=strtok($check,"|");
			while($tmp){
				$v[$i]=$tmp;
				$i++;
				$tmp=strtok("|");
			}
			/* loop through array, check for emptys */
			$row=0;
			while($row<count($v)){
				$temp=$v[$row];
				if($$temp==""){
					$label=$v[$row+1];
					$message .= "<li>Please fill out the <b>$label</b> field<br>\n";
				}
				$row ++;
				$row ++;
			}
			$action = "Edit Bill To Info";
			$update = "False";
		}else{
			$province = strtoupper($province);
			$query = "Select user_id from billto where user_id = '$PHP_AUTH_USER'";
			$select = mysql($database,$query);
			echo mysql_error();
			$rows = mysql_numrows($select);
			if($rows == 0){
				$query = "(user_id,lname,fname,addr1,addr2,city,
					province,pcode,country,email,phone,fax)
					values 
					('$PHP_AUTH_USER','$lname','$fname',
					'$addr1','$addr2','$city','$province',
					'$pcode','$country','$email','$phone','$fax')";

				$querya = "Insert into billto ".$query;
				$insert = mysql($database,$querya);
				echo mysql_error();
				$check_query = "Select user_id from shipto where user_id = '$PHP_AUTH_USER'";
				$select = mysql($database,$check_query);
				$rows = mysql_numrows($select);
				if($rows == 0){
					$querya = "Insert into shipto ".$query;
					$insert = mysql($database,$querya);
					echo mysql_error();
				}
			}else{
				$query = "Update billto set ";
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
		}

?>