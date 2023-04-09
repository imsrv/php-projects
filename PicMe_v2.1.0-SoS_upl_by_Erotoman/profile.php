<?PHP
/*
#
#	$Id: PROFILE.PHP
#	Version 2.1.0
#
*/

include "header.php";
// MAKE SURE THE USER IS LOGGED IN
if ($uname != "") {

// GET USERS ID FROM LOGIN NAME
	$sql = "select * from users where userid = '$uname'";
	$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) {
	$uid = $row["id"];
	}

// CHECK FOR NEW MESSAGES
		$sql = "select * from messages where touserid ='$uname' AND isread = '0'"; 
		$sql_result = mysql_query($sql); 
		$totmsgs = 0;
		while ($row = mysql_fetch_array($sql_result)) { 
		 $isread = $row["isread"];
		 $totmsgs++;
		} 

// COUNT TOTAL MESSAGES
		$sql = "select * from messages where touserid ='$uname'"; 
		$sql_result = mysql_query($sql); 
		$msgs = 0;
		while ($row = mysql_fetch_array($sql_result)) { 
		 $msgs++;
		}

// COUNT USERS PHOTOS
		$sql = "select * from picuploads where userid ='$uname'"; 
		$sql_result = mysql_query($sql); 
		$numphoto = 0;
		while ($row = mysql_fetch_array($sql_result)) { 
		 $numphoto++;
		}

// WELCOME THE USER
		echo	"<a href=editprofile.php><B>Edit your Information</B></a><br><br><table border=0 cellpadding=0 cellspacing=0 width=100%>\n
		<tr>\n
			<td bgcolor=$menucolor>\n
			<div align=left>\n
			<b>Quick Stats</b></div>\n
			</td>\n
			<td bgcolor=$menucolor>\n
			<div align=left>\n
			</div>\n
			</td>\n
		</tr>\n
		<tr>\n
			<td width=50%><b>New Messages:</b> $totmsgs\n
			</td>\n
			<td width=50%><b>User name:</b> $uname\n
			</td>\n
		<tr>\n
		<tr>\n
			<td width=50%><b>Total Messages:</b> $msgs\n
			</td>\n
			<td width=50%><b>User ID:</b> $uid \n
			</td>\n
		<tr>\n		
		<tr>\n
		<tr>\n		
		</table>\n";
echo "<br><br>";


//  DISPLAY THE INBOX 
	 $table_top = "
	 <table border=0 cellpadding=0 cellspacing=2 width=100%>\n
		<tr>\n
			<td valign=top align=center>\n
			<table border=0 cellpadding=0 cellspacing=0 width=100%>\n
				<tr>\n
					<td bgcolor=$menucolor>\n
						<div align=left>\n
							<b>Your Private Messages </b>&nbsp;(only 20 displayed at a time)</div>\n
					</td>\n
				</tr>\n
			</table>\n
		</td>\n
	</tr>\n
	<tr>\n
		<td valign=top align=center>\n
			<div align=left>\n
				<p></p>\n
				<table border=0 cellpadding=0 cellspacing=1 width=100%>\n
					<tr>\n
						<td align=left valign=middle width=5% bgcolor=#6699cc></td>\n
						<td width=20% bgcolor=#6699cc><b>From</b></td>\n
						<td bgcolor=#6699cc><b>Subject</b></td>\n
	</tr>\n";
	$table_bottom = "</table>\n</div>\n</td>\n</tr>\n</table>\n";
 	
	$sql = "select * from messages where touserid ='$uname' ORDER BY sdate DESC LIMIT 20";
	$sql_result = mysql_query($sql); 
	$bgct = "e0ffff";
	while ($row = mysql_fetch_array($sql_result)) { 
	 $id = $row["id"];
	 $subject = $row["title"];
	 $message = $row["message"];	 
	 $from = $row["fromuserid"];
	 $sdate = $row["sdate"];
	 $isread = $row["isread"];
	 if($isread == "1") { $r1 = "<img src=images/read.gif border=0>";} else { $r1 = "<img src=images/unread.gif border=0>";}
	if($bgct == "e0ffff") { 
		$bgct = "f8f8ff";
		} else { 
		$bgct = "e0ffff";
		}
	$table_msgs=$table_msgs. "<tr>\n
	<td width=5% bgcolor=#$bgct><a href=inbox.php?action=deleteprivate&id=$id><img src=images/delete.gif border=0 alt=Delete></a></td>\n
	<td bgcolor=#$bgct>$from</td>\n
	<td bgcolor=#$bgct><a href=inbox.php?action=readprivate&id=$id>$r1 $subject</a></td>\n
	</tr>\n";
	}
	$tablemsgs ="$table_top $table_msgs $table_bottom";
echo $tablemsgs;

// GET MESSAGES FROM PHOTOS
$table_top2 = "
	<table border=0 cellpadding=0 cellspacing=2 width=100%>\n
		<tr>\n
			<td valign=top align=center>\n
	<table border=0 cellpadding=0 cellspacing=0 width=100%>\n
		<tr>\n
			<td bgcolor=$menucolor>\n
				<div align=left>\n
				<b>Comments on your Photos: </b>&nbsp;(only 20 displayed at a time)</div>\n
			</td>\n
		</tr>\n
	</table>\n
	<table border=0 cellpadding=0 cellspacing=1 width=390>\n
		<tr>\n
		</tr>\n";
	$table_bottom2 = "</table></table>";

echo "<br><br>";
echo $table_top2;
echo getUcomments($uid);
echo $table_bottom2;

} else {
echo "<br><br>";
echo $accessdenied;
}

include "footer.php";
?>