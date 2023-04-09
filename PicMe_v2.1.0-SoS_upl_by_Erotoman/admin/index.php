<?php
/*
#
#	$Id: INDEX.PHP
#	Version 2.0.1
#
*/
session_start();
include "top.inc.php";
include "../settings.php";
include "../functions.php";
include "main.php";

function Countrec($id) {
include "../settings.php";
	$sql = "select * from comments where pid ='$id'";  
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
	$pid = $row["pid"]; 
	$ucount++;	}
	return $ucount;
}

function quickApprove($id){

	echo "<BR>";
	$sql="update picuploads set approved = '1' where id='$id'"; 
	$sql_result = mysql_query($sql); 
}

if($action == "showall") {
	if($qp) {
	quickApprove($qp);
	}
	include "split.class.php";  
	echo "
	<table border=0 cellpadding=5 cellspacing=2 width=100%>
		<tr>
	<td bgcolor=ffa500 width=40%><b>User Info</b></td>
	<td bgcolor=ffa500 width=20%><b>Last Updated</b></td>
	<td bgcolor=ffa500 width=20%><b>Approved</b></td>
	<td bgcolor=ffa500 width=20%><b>Preview</b></td>
		</tr>
	";

	$sql="select * from picuploads ORDER BY id DESC"; 
	$numofrecs = "5";
	$ord=new Split($sql,$numofrecs);
	if($ord->error!="")  
	{  
	    die("ERROR" . $ord->error);  
	}      
	$rows=$ord->display($ppage);  
	$pages=$ord->total();
	
if(($ppage=="")||($ppage<="0") )  
	{  
	    $ppage=1;  
	}      

	for($j=1;$j<=$pages;$j++)  
	{  
	    if($j==$ppage)  
	    {  
			echo "<br><b>Page $j of $pages</b>: ";
	    }  	    
	}  

if($ppage > $pages)  
	{  
	    $ppage=$pages;  
	}      

	if($ppage>1)  
	{  
	    $backpage=$ppage-1;      
			echo " <a href=$PHP_SELF?action=showall&ppage=$backpage>Previous</a> ";
	} 

if($ppage<$pages)  
	{  
    $nextpage=$ppage+1;      
		echo " <a href=$PHP_SELF?action=showall&ppage=$nextpage>Next</a> ";
	}  
	
echo "<p>";

	$sql="select * from picuploads"; 	
	while($myrow=mysql_fetch_row($rows))  
	{  
	$id = $myrow[0];
	$name = $myrow[1];
    	$userid = $myrow[2];
	$comment = $myrow[3];
    	$title = $myrow[4];
	$votes = $myrow[5];
    	$pnts = $myrow[6];
    	$approved = $myrow[7];
	$udate = $myrow[8];
	$catagory = $myrow[9];
	$ucomtot = (Countrec($id));
	
	$sql2="select * from users where userid='$userid'"; 
	$sql_result2 = mysql_query($sql2);
	while ($row = mysql_fetch_array($sql_result2)) { 	 
	$email = $row["email"]; 
	$canemail = $row["emailvisible"];
	}
	
	if ($canemail != "1") {
	$canemail = "No";
	} else {
	$canemail = "Yes";
	}
	
	if ($votes != "0") { 
		$av = round($pnts / $votes,3); 		
	} else { 
	$av = "0";
	}
	
	if($approved == "0") { 
	$ap = "NO";
	} else { 
	$ap="YES";
	}
	

	echo "
	<tr>
	<td valign=top>
	<a href=$PHP_SELF?edit=$id>Edit Photo $title</a>
	<br>
	<a href=$PHP_SELF?action=showall&qp=$id>Quick Approve</a>
	<br>
	<a href=$PHP_SELF?action=edituser&userid=$userid>Edit User Profile</a>
	<br>
	<br><b>Id:</b> $id
	<br><b>Photo Name:</b> $name
	<br><b>Userid:</b> $userid
	<br><b>Photo Comment:</b> $comment
	<br><b>Photo Title:</b> $title
	<br><b>Can Email:</b> $canemail
	<br><b>Email:</b> <A HREF=mailto:$email?subject=PicMe>$email</A>
	<br><b>Votes:</b> $votes
	<br><b>Points:</b> $pnts
	<br><b>Rating:</b> $av
	</td>
	<td valign=top>$udate</td>
	<td valign=top>$ap</td>
	<td valign=top><img src=../uploads/$name width=150></td>
	</tr>
	<tr>
	<td colspan=4><hr size=2 width=75%></td>
	</tr>
	";
}
 echo "</table>";
}

if($edit) {
	$sql="select * from picuploads where id='$edit'"; 
	$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 	 
	$id = $row["id"]; 
	$name = $row["name"]; 	
	$userid = $row["userid"];	
	$comment = $row["comment"];	
	$title = $row["title"];	
	$votes = $row["votes"];
	$points = $row["points"];
	$udate = $row["udate"];			
	$approved = $row["approved"];
	$catagory = $row["catagory"];				
}
include "edit.php";
}


if($updatepic) {
	if($approved =="1") { //nothing 
		} else {
		$approved ="0";
	}
	echo "<BR>";
	$sql="update picuploads set name='$name', userid='$userid', title='$title', points='$points',	udate='$udate', approved='$approved', comment='$comment', votes='$votes' where id='$updatepic'"; 
	$sql_result = mysql_query($sql); 
	echo "Picture $title Updated";
}

if($action == "showunapproved") {
	include("split.class.php");  

	$sql="select * from picuploads where approved='0' ORDER BY id DESC"; 
	$numofrecs = "5"  ;
	$ord=new Split($sql,$numofrecs);
	if($ord->error!="")  
	{  
	    echo "<br><b>There are no NEW images to approve at this time.</b><br><br>"; 
	   exit; 
	}      
	echo "
		<table border=0 cellpadding=0 cellspacing=1 width=75%>
			<tr>
				<td bgcolor=ffa500><b>Info</b></td>
				<td bgcolor=ffa500><b>Date</b></td>
				<td bgcolor=ffa500><b>Approved</b></td>
				<td bgcolor=ffa500><b>Preview</b></td>
			</tr>
	";
	$rows=$ord->display($ppage);  
	$pages=$ord->total();         
	
if(($ppage=="")||($ppage<="0") )  
	{  
	    $ppage=1;  
	}      

	for($j=1;$j<=$pages;$j++)  
	{  
	    if($j==$ppage)  
	    {  
			echo "<br><b>Page $j of $pages</b>";
	    }  	    
	}  


if($ppage > $pages)  
	{  
	    $ppage=$pages;  
	}      

	if($ppage>1)  
	{  
	    $backpage=$ppage-1;      
			echo "   <a href=$PHP_SELF?action=showunapproved&ppage=$backpage>previous</a>";
	} 

if($ppage<$pages)  
	{  
    $nextpage=$ppage+1;      
		echo "<a href=$PHP_SELF?action=showunapproved&ppage=$nextpage>Next</a>";
	}  
	
echo "<p>";

	$sql="select * from picuploads where id='$edit'"; 	
	while($myrow=mysql_fetch_row($rows))  
	{  
	$id = $myrow[0];
	$name = $myrow[1];
	$userid = $myrow[2];
	$comment = $myrow[3];
	$title = $myrow[4];
	$votes = $myrow[5];
	$pnts = $myrow[6];
	$approved = $myrow[7];
	$udate = $myrow[8];
	$catagory = $myrow[9];
	$ucomtot = (Countrec($id));
	if ($votes != "0") { 
		$av = round($pnts / $votes,1); 		
	} else { $av = "0";	}
	if($approved == "0") { $ap = "no";} else { $ap="yes";}
	echo "
		<tr>
		<td valign=top width=40%>
		<a href=$PHP_SELF?edit=$id>Show Profile for $title</a></font><p>
		</td>
		<td width=20% valign=top>$udate</td>
		<td width=20% valign=top>$ap</td>
		<td width=20% valign=top><img src=../uploads/$name width=150></td>
		</tr>
		<tr>
		<td colspan=4><hr size=1 width=75%></td>
		</tr>
		";
	}  
 echo "</table>";
}

if($action == "edituser") {
	echo "<p>
	<table width=75% border=0>";
	$sql="select * from users where userid='$userid'"; 
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 	 	
	$userid = $row["userid"]; 
	$password = $row["password"]; 	
	$email = $row["email"];	
	$sex = $row["sex"];		
	$hobbies = $row["hobbies"];		
	$music = $row["music"];	
	$chat = $row["chat"];	
	$updated = $row["updated"];	
	$emailvisible = $row["emailvisible"];		
	include "edituser.php";
	}
}

if($submituser) {
	if($emailvisible =="1") {
	// tnoning
	} else { $emailvisible="0";}
	$updated = date("Y-m-d H:i:s");
	$sql="update users set password='$password', email='$email', sex='$sex', hobbies='$hobbies', music='$music', chat='$chat', updated='$updated', emailvisible='$emailvisible' where userid='$userid'"; 
	$sql_result = mysql_query($sql); 
	echo "<p>Done updating $userid";
}

if($action == "deleteuser") {
	$sql="delete from users where userid='$userid'"; 
	$sql_result = mysql_query($sql); 	
	echo "<p>Done deleting $userid";
}

if($action == "showusers") {
	echo "<p><table width=100% border=0><tr>
	<td><B>ID</B></td><td><B>USERID</B></td><td><B>PASS</B></td><td><B>EMAIL</B></td><td><B>SEX</B></td><td><B>UPDATED</B></td><td><B>AGE</B></td><td><B>COUNTRY</B></td><td><B>STATE</B></td></tr>
	";
	$sql="select * from users"; 
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 	 	
	$userid = $row["userid"]; 
	$email = $row["email"];	
	$id = $row["id"];
	$pass = $row["password"];
	$sex = $row["sex"];
	$updated = $row["updated"];
	$year = $row["year"];
	$country = $row["country"];
	$state = $row["state"];
	echo "<tr>
		<td>$id</td>
		<td><a href=$PHP_SELF?action=edituser&userid=$userid>$userid</a></td>
		<td>$pass</td>
		<td><A HREF=mailto:$email?subject=PicMe>$email</A></td>
		<td>$sex</td>
		<td>$updated</td>";
		if ($year) {
		$thisyear = date("Y");
		$age = $thisyear-$year;
		} else {
		$age = "n/a";
		}
		echo "<td>$age</td><td>";
		if ($country){echo "<IMG SRC=../flags/$country.gif BORDER=0>";}
		echo " $country</td>
		<td>$state</td>
		</tr>";
	}
}

/*
if($showcatagory) {
	include("top.inc.php");
	require('../settings.php');
	$connection = mysql_connect("$sqlhost","$sqluser","$sqlpass"); 
	if (!$connection) { 
	echo "Couldn't make a connection!"; 
	exit; 
	} 
	$db = mysql_select_db("$sqldb", $connection); 
	if (!$db) { 
	echo "Couldn't select database!!!!"; 
	exit; 
	} 

	$sql = "select * from $r_catagory";  
	$sql_result = mysql_query($sql); 
	echo "<p><b>Modify Existing Catagory</b><form name=modifycatagory action=$PHP_SELF method=get>";
	echo "<select name=catagory size=1><option value=>Select a Catagory</option>";
	while ($row = mysql_fetch_array($sql_result)) { 
	$id = $row["id"];		
	$catagory = $row["catagory"];	
	 echo "<option value=$id>$catagory</option>";	

	}
	echo "</select><select name=modcat size=1>
	<option value=1>Modify</option>
	<option value=0>Delete</option></select>
	<input type=submit name=modifycatagory value=Go>		
	</form>
	
	<hr size=1><b>Add Catagory</b><form name=addcatagory action=$PHP_SELF method=put>
	<input type=text name=catagory size=20>
	<input type=submit name=addcatagory value=Go>";
exit;
}

if($modifycatagory) {
	include("top.inc.php");
	require('../settings.php');
	$connection = mysql_connect("$sqlhost","$sqluser","$sqlpass"); 
	if (!$connection) { 
	echo "Couldn't make a connection!"; 
	exit; 
	} 
	$db = mysql_select_db("$sqldb", $connection); 
	if (!$db) { 
	echo "Couldn't select database!!!!"; 
	exit; 
	} 
	if($modcat =="0") { // delete
		$sql = "delete from $r_catagory where id='$catagory'";  
		$sql_result = mysql_query($sql); 
	    echo "<p>Catagory deleted...";
	} else { // modifying
	$sql = "select * from $r_catagory where id='$catagory'";  
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
		$id = $row["id"];		
		$catagory = $row["catagory"];			
	}
	
	echo "
	<form name=renamecatagory action=$PHP_SELF method=put>
	Rename:<input type=text name=catagory size=20 value=$catagory>
	<input type=hidden name=id value=$id>
	<input type=submit name=renamecatagory value=Update>
	</form>";
	}
exit;
}

if($renamecatagory) {
	include("top.inc.php");
	require('../settings.php');
	$connection = mysql_connect("$sqlhost","$sqluser","$sqlpass"); 
	if (!$connection) { 
	echo "Couldn't make a connection!"; 
	exit; 
	} 
	$db = mysql_select_db("$sqldb", $connection); 
	if (!$db) { 
	echo "Couldn't select database!!!!"; 
	exit; 
	} 
	$sql = "update $r_catagory set catagory='$catagory' where id='$id'";  
	$sql_result = mysql_query($sql); 
	echo "<p>Done updating $catagory";

exit;
}

if($addcatagory) {
	include("top.inc.php");
	require('../settings.php');
	$connection = mysql_connect("$sqlhost","$sqluser","$sqlpass"); 
	if (!$connection) { 
	echo "Couldn't make a connection!"; 
	exit; 
	} 
	$db = mysql_select_db("$sqldb", $connection); 
	if (!$db) { 
	echo "Couldn't select database!!!!"; 
	exit; 
	} 

	$sql = "insert into $r_catagory values('','$catagory')";  
	$sql_result = mysql_query($sql); 
	echo "<p>$catagory added..";

exit;
}
*/
if($action == "showfaq") {
	$sql = "select * from faq";  
	$sql_result = mysql_query($sql); 
	echo "<p><b>Modify Existing FAQ</b>
	<form name=modifyfaq action=$PHP_SELF method=get>";
	echo "<select name=modfaq size=1><br>
	<option value=1>Modify</option>
	<option value=2>Delete</option></select><select name=faqid size=1>
	<option value=>Select an FAQ</option>";
	while ($row = mysql_fetch_array($sql_result)) { 
	$id = $row["id"];		
	$faq_q = $row["faq_q"];	
	$faq_a = $row["faq_a"];
	echo "<option value=$id>$faq_q</option>";	

	}
	echo "</select>

	<input type=submit name=modifyfaq value=Go>		
	</form>
	
	<hr size=1><b>Add FAQ</b><form name=addfaq action=$PHP_SELF method=put>
	<b>Question:</b><br><textarea rows=3 cols=55 wrap=virtual name=faq_q ></textarea><Br>
	<b>Answer:</b><br><textarea rows=3 cols=55 wrap=virtual name=faq_a ></textarea><br>
	<input type=submit name=addfaq value=ADD>";
}

if($renamefaq){
	$sql = "update faq set faq_q='$faq_q', faq_a='$faq_a' where id='$id'";  
	$sql_result = mysql_query($sql); 
	echo "<p>Done Updating FAQ";
}

if($modfaq && $faqid){
	if($modfaq =="2") { // delete
		$sql = "delete from faq where id='$faqid'";  
		$sql_result = mysql_query($sql); 
	    echo "<p>FAQ deleted...";
		exit;
	} else { // modifying

	$sql = "select * from faq where id='$faqid'";  
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
		$id = $row["id"];		
		$faq_q = $row["faq_q"];			
		$faq_a = $row["faq_a"];
		}
	
	echo "
	<form name=renamefaq action=$PHP_SELF method=put>
	<b>Question:</b><br><textarea rows=9 cols=55 wrap=virtual name=faq_q>$faq_q</textarea>
	<br><b>Answer:</b><br><textarea rows=9 cols=55  name=faq_a>$faq_a</textarea>
	<input type=hidden name=id value=$id>
	<br><input type=submit name=renamefaq value=Update>
	</form>";
	}
}	

if($addfaq){
	$sql = "insert into faq values('','$faq_q','$faq_a')";  
	$sql_result = mysql_query($sql); 
	echo "<p>Finished adding FAQ";
}

if($deletepic) {
	$sql = "delete from picuploads where id='$id'";  
	$sql_result = mysql_query($sql); 
	echo "<p>Deleted ID $id<br>";
	$sql = "delete from comments where pid='$id'";  
	$sql_result = mysql_query($sql); 
	echo "Deleted any user comments<br>";
	unlink("../$imagedir/$name");
	echo "Deleted Picture..<br>";
}

if($action == "news") {
	$sql = "select * from news";  
	$sql_result = mysql_query($sql); 
	echo "<p><b>Modify Existing News</b>
	<form name=modifynews action=$PHP_SELF method=get>";
	echo "<select name=modnews size=1><br>
	<option value=1>Modify</option>
	<option value=2>Delete</option></select><select name=newsid size=1>
	<option value=>Select a Topic</option>";
	while ($row = mysql_fetch_array($sql_result)) { 
	$id = $row["id"];		
	$topic = $row["topic"];	
	$news = $row["news"];
	echo "<option value=$id>$topic</option>";	
	}
	echo "</select>
	<input type=submit name=modifynews value=Go>		
	</form>
	<hr size=1><b>Add News:</b><form name=addnews action=$PHP_SELF method=put>
	<b>Topic:</b><br><textarea rows=1 cols=55 wrap=virtual name=topic ></textarea><Br>
	<b>News:</b><br><textarea rows=3 cols=55 wrap=virtual name=news ></textarea><br>
	<input type=submit name=addnews value=ADD>";
}

if($addnews){
	$sql = "insert into news values('','$today','$topic','$news')";  
	$sql_result = mysql_query($sql); 
	echo "<p>Finished adding News";
}

if($modnews && $newsid){
	if($modnews =="2") { // delete
		$sql = "delete from news where id='$newsid'";  
		$sql_result = mysql_query($sql); 
	    echo "<p>News deleted...";
	} else { // modifying

	$sql = "select * from news where id='$newsid'";  
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
		$id = $row["id"];		
		$topic = $row["topic"];			
		$news = $row["news"];
		}
	
	echo "
	<form name=renamenews action=$PHP_SELF method=put>
	<b>Topic:</b><br><textarea rows=1 cols=55 name=topic>$topic</textarea>
	<br><b>News:</b><br><textarea rows=9 cols=55  name=news>$news</textarea>
	<input type=hidden name=id value=$id>
	<br><input type=submit name=renamenews value=Update>
	</form>";
	}
}

if($renamenews){
	$sql = "update news set topic='$topic', news='$news' where id='$id'";  
	$sql_result = mysql_query($sql); 
	echo "<p>Done Updating News";
}

?>
