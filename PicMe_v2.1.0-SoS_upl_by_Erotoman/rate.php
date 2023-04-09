<?PHP
/*
#
#	$Id: RATE.PHP
#	Version 2.1.0
#
*/

include "header.php";

if ($count >= 30) {
echo $novotesleft; 
include "footer.php";
exit;
} else {
// do nothing
}
$count++;

// UPDATE VOTE COUNT AND SWITCH PHOTOS
if($vote != "") {
		$sql = "update picuploads set points=points + $vote, votes=votes+1 where id ='$picid'";
		$sql_result = mysql_query($sql);
		
		$sql = "SELECT * FROM picuploads WHERE id='$picid'";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
//	 $bigphoto = $row["id"];
	 $lpoints = $row["points"];
	 $lvotes = $row["votes"];
	 $littlephoto = $row["name"];
	 }
// $littlephoto = $bigphoto;
$rate = round($lpoints / $lvotes,3);
//$votesleft ++;
//setCookie("votesleft","$votesleft");
}
	
// IF ACTION IS MEN
if($action == "men") {
		$sql = "SELECT * FROM picuploads WHERE approved='1' and catagory='1' ORDER BY rand()";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $picid = $row["id"];
	 $rname = $row["name"];
	 $rid = $row["userid"];
	 $rcomment = $row["comment"];
	 $rtitle = $row["title"];
	 $rvotes = $row["votes"];
	 $rpoints = $row["points"];
	 $rdate = $row["udate"];
	 $rcatagory = $row["catagory"];	 
	}
}

// IF ACTION IS FEMALE
if($action == "female") {
		$sql = "SELECT * FROM picuploads WHERE approved='1' and catagory='2' ORDER BY rand()";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $picid = $row["id"];
	 $rname = $row["name"];
	 $rid = $row["userid"];
	 $rcomment = $row["comment"];
	 $rtitle = $row["title"];
	 $rvotes = $row["votes"];
	 $rpoints = $row["points"];
	 $rdate = $row["udate"];
 	 $rcatagory = $row["catagory"];
	}
}

// IF NO ACTION
if($action == "") {
		$sql = "SELECT * FROM picuploads WHERE approved='1' ORDER BY rand()";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $picid = $row["id"];
	 $rname = $row["name"];
	 $rid = $row["userid"];
	 $rcomment = $row["comment"];
	 $rtitle = $row["title"];
	 $rvotes = $row["votes"];
	 $rpoints = $row["points"];
	 $rdate = $row["udate"];
	 $rcatagory = $row["catagory"];
	}
}

// GET CATAGORY
		$sql = "SELECT * FROM catagory WHERE id=$rcatagory";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $rcat = $row["catagory"];
	 }


// GET USER PROFILE
		$sql = "SELECT * FROM users WHERE userid='$rid'";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $rrid = $row["id"];
	 $rrsex = $row["sex"];
	 $rrage = $row["age"];
	 $rrhobbies = $row["hobbies"];
	 $rrmusic = $row["music"];
	 $rrchat = $row["chat"];
	 $rrupdated = $row["updated"];
	 $rremail = $row["email"];
	 $rremailvisible = $row["emailvisible"]; 
	 }



  
?>
<br><br><table border="0" cellpadding="0" cellspacing="1" width="500">
	<tr>
		<td valign="top">
<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td bgcolor=C0C0FF height=25 VAlign="center"><img src="images/q.gif" border="0">&nbsp;<b>Information:</b></td>
	</tr>
	<tr>
		<td width="250" valign="top">
			<b>Points:</b> <? echo $rpoints; ?><br>
			<b>Votes:</b> <? echo $rvotes; ?><br>
			<b>Catagory:</b> <? echo $rcat; ?><br>															
			<b>By:</b> <? echo $rid; ?><br>
			<b>Date:</b> <? echo $rdate; ?><br>
			<br>
			<a href="rate.php?vote=1&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating01.gif" border="0"></a><a href="rate.php?vote=2&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating02.gif" border="0"></a><a href="rate.php?vote=3&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating03.gif" border="0"></a><a href="rate.php?vote=4&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating04.gif" border="0"></a><a href="rate.php?vote=5&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating05.gif" border="0"></a><a href="rate.php?vote=6&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating06.gif" border="0"></a><a href="rate.php?vote=7&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating07.gif" border="0"></a><a href="rate.php?vote=8&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating08.gif" border="0"></a><a href="rate.php?vote=9&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating09.gif" border="0"></a><a href="rate.php?vote=10&picid=<? echo $picid ?>&action=<? echo $action ?>"><img src="images/rating10.gif" border="0"></a>
<table border="0" cellpadding="0" cellspacing="2" width="90">
	<tr>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			<center>
			<?PHP
			if($littlephoto != "") {
			echo "<br><img src=uploads/$littlephoto border=1 width=100>";
			echo "<br><b>Rating:</b> <font color=red><b>";
			echo $rate;
			echo "</b></font><br><b>You Voted: </b>";
			echo $vote;
		 	} else {
			echo "<br>";
		 	}
			?>
			</center>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
		<td valign="top" width="250">
<table class="cattbl" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td bgcolor=C0C0FF Height=25 VAlign="center"><b><? echo $rid; ?> </b><a href="private.php?touser=<? echo $rid ?>"><img src="images/authors.gif" alt="Send a private message to <? echo $rid ?>" border="0"> Send Private Message</a></td>
	</tr>
	<tr>
		<td>
			<div align="center">
			<? echo "<br><img src=uploads/$rname border=1 width=320>"; ?></div>
		</td>
	</tr>
	<tr>
		<td>
			<div align="center">
			<b>Users Comments:</b><br>
			<? echo $rcomment; ?>
			</div>
		</td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td valign="top" colspan="2">
<table border="0" cellpadding="0" cellspacing="0" width="500">
	<tr>
		<td>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>

<table class="cattbl" cellspacing="0" cellpadding="0" border="0" width="500">
	<tr>
		<td bgcolor=8FFDAE><b>Submitted Comments</b></td>
		<td bgcolor=8FFDAE align=right><img src="images/post.gif" alt="Post a comment on this picture" border="0">&nbsp;&nbsp;<a href="comment.php?pid=<? echo $picid ?>"><b>Submit Comment on Photo</b></a></td>
	</tr>
	<tr>
		<td width="40%">
			<?PHP
			echo getUcomments($picid);
			?>
		</td>
	</tr>
</table>

<table border="0" cellpadding="0" cellspacing="1" width="500">
	<tr>
		<td valign="top" width="50%">
<table class="cattbl" cellspacing="0" cellpadding="0" border="0" width="500">
	<tr>
		<td bgcolor=DC8C7C><b>User Profile</b></td>
	</tr>
	<tr>
		<td>
<table border="0" cellpadding="0" cellspacing="2" width="500">
	<tr>
		<td width="50%" valign="top" align="left">
<table border="0" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<td width="30%"><b>&nbsp;&nbsp;Sex</b></td>
		<td><? echo $rrsex; ?></td>
	</tr>
	<tr>
		<td width="30%"><b>&nbsp;&nbsp;Hobbies</b></td>
		<td><? echo $rrhobbies; ?></td>
	</tr>
	<tr>
		<td width="30%"><b>&nbsp;&nbsp;Music</b></td>
		<td><? echo $rrmusic; ?></td>
	</tr>
	<tr>
		<td width="30%"><b>&nbsp;&nbsp;Chat</b></td>
		<td><? echo $rrchat; ?></td>
	</tr>
	<tr>
		<td width="30%"><b>&nbsp;&nbsp;Email</b></td>
		 <?PHP
		 if($rremailvisible == "1") {
			 $canmail = "<img src=images/email.gif alt=Email $rid border =0>&nbsp;&nbsp;<a href=mailto:$rremail>$rremail</a>";	
		 } else {
			 $canmail = "Email Address Hidden";	
		 }
		 ?>
		<td><? echo $canmail; ?></td>
	</tr>
	<tr>
		<td width="30%"><b>&nbsp;&nbsp;Updated</b></td>
		<td><? echo $rrupdated; ?></td>
	</tr>
</table>
		</td>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>


<?PHP

include "footer.php";
?>