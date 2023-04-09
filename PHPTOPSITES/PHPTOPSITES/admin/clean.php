<?
include "../config.php";
include "header.php";

$insert_count=$delete_count=$ignored_count=0;
$num_rows=count($sid);

for($i = 0; $i < $num_rows; ++$i){
	if($a[$i]=="Add Site"){
		if ($usedefault[$i] == "yes" || strlen($banner[$i]) <= 7) $banner[$i] = $url_to_folder."/images/nota.gif";
		mysql_db_query ($dbname,"Update top_user set banner='$banner[$i]',category=$category[$i],status='Y' Where sid=$sid[$i]",$db) or die(mysql_error());
		$msg = "Welcome $name to the $top_name.\n Your Site has been accepted from $top_name.\n Site ID: $sid[$i]\n Password: $passwd[$i]\n HTML: \n <A HREF=\"$url_to_folder/in.php?site=$sid[$i]\"><IMG ALT=\"$top_name\" SRC=\"$vote_image_url\" BORDER=0></A>";
		mail($email[$i],"Site Accepted.",$msg,"From: $admin_email\nReply-To: $admin_email");
		++$insert_count;
	}
	if($a[$i]=="Reject Site"){
		mysql_db_query ($dbname,"delete from top_user Where sid=$sid[$i]",$db) or die (mysql_error());
		mysql_db_query ($dbname,"delete from top_hits where sid=$sid[$i]",$db) or die (mysql_error());
		mysql_db_query ($dbname,"delete from top_review where sid=$sid[$i]",$db) or die (mysql_error());
		$msg = "Sorry $name.\n Your Site has been rejected from $top_name.\n Reason: $reason[$i].";
		mail($email[$i],"Site Rejected.",$msg,"From: $admin_email\nReply-To: $admin_email");
		++$delete_count;
	}
}

$ignored_count=$num_rows-$insert_count-$delete_count;

?>
<table align="center" border="0" cellpadding="5" cellspacing="0" width="90%">
	<tr>
		<td align="center" bgcolor="#eeeeee"><br><table>
		<tr>
			<td><font face="<? echo $font_face;?>" size="2">
		<? echo $insert_count;?> Sites were added.<br><br>
		<? echo $delete_count;?> Sites were rejected.<br><br>
		<? echo $ignored_count;?> Sites were ignored.<br><br><br>
		<a href="validate.php">Click Here to Continue</a>
		</font><br><br></td>
		</tr>
		</table></td>
	</tr>
</table>
<?
include "footer.php";
?>