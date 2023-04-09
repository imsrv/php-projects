<?PHP
/*
#
#	$Id: EDIT.PHP
#	Version 2.0.0
#
*/
?>
	<br>
	<table border="0" cellpadding="0" cellspacing="0" width="75%">
	<tr>
	<td>
	<form name="deletepic" action="<? echo $PHP_SELF; ?>" method="put">
	<input type="hidden" name="id" value="<? echo $id; ?>">
	<input type="hidden" name="name" value="<? echo $name; ?>">					
	<input type="submit" name="deletepic" value="Delete Photo">
	</form>
	</td>
	<td></td>
	<td></td>
	<td></td>
	</tr>
	<tr>
	<td><font size="2"><b>Editing:</b></font><br><b> User ID: <font size="2" color="red"><b> 
	<? echo $id; ?></font><br> User Name: <font size="2" color="red"><? echo $userid; ?></b></font>
	</td>
	<td></td>
	<td></td>
	<td></td>
	</tr>
	<tr>
	<form name="editpic" action="<? echo $PHP_SELF; ?>" method="put">
	<td>
      <P align=right><font size="2"><B>Photo Name:</B>&nbsp;</font></P></td>
	<td><input name="name" size="24" value="<? echo $name; ?>"></td>
	<td>
      <P align=right><font size="2"><B>By User:</B>&nbsp;</font></P></td>
	<td><input name="userid" size="24" value="<? echo $userid; ?>"></td>
	</tr>
	<tr>
	<td>
      <P align=right><font size="2"><B>Photo Title:</B>&nbsp;</font></P></td>
	<td><input name="title" size="24" value="<? echo $title; ?>"></td>
	<td>
      <P align=right><font size="2"><B>Date:</B>&nbsp;</font></P></td>
	<td><input name="udate" size="24" value="<? echo $udate; ?>"></td>
	</tr>
	<tr>
	<td>
      <P align=right><font size="2"><B>Votes:</B>&nbsp;</font></P></td>
	<td><input name="votes" size="24" value="<? echo $votes; ?>"></td>
	<td>
      <P align=right><font size="2"><B>Points:</B>&nbsp;</font></P></td>
	<td><input name="points" size="24" value="<? echo $points; ?>"></td>
	</tr>
	<tr>
	<td>
      <P align=right><font size="2"><B>Catagory:</B>&nbsp;</font></P></td>
	<td>
	<?PHP
	$sql="select * from catagory where id='$catagory'"; 
	$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 	 
	$cat = $row["catagory"]; 
	}
	?>
	<? echo $cat; ?></td>
	<td bgcolor="#b22222">
      <P align=right><font size="2" color="#f5f5f5"><b>Approved:&nbsp;</b></font></P></td>
	<td bgcolor="#b22222"><input type="checkbox" value="1" name="approved"  
	<? if($approved == "1") { echo "checked"; } ?>
	</td>
	</tr>
	<tr>
	<td>
      <P align=right><font size="2"><B>Comments:</B>&nbsp;</font></P></td>
	<td colspan="2">
	<input name="comment" size="30" value="<? echo $comment; ?>">
	<input type="hidden" name="updatepic" value="<? echo $id; ?>">
	</td>
	<?PHP
	$sql2="select * from users where userid='$userid'"; 
	$sql_result2 = mysql_query($sql2);
	while ($row = mysql_fetch_array($sql_result2)) { 	 
	$email = $row["email"]; 
	}
	?>
	<td><b>Email: </b><A HREF="mailto:<? echo $email; ?>?subject=PicMe Profile"><? echo $email; ?></A></td>
	</tr>
	<tr>
	<td colspan="4">
	<br><br><input type="submit" name="submitButtonName" value="Update User Profile"></FORM>	
	<center><? echo "<img src=../uploads/$name width=150>"; ?></center>
	</td>
	</tr>
	</table>
