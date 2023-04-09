<?
include "../config.php";
include "header.php";

if (!$a) {
	$query = mysql_db_query ($dbname,"select * from top_cats order by catname",$db) or die (mysql_error());

	?>
		<table align="center" width=90% border=0 cellspacing=3 cellpadding=0>
		<tr><td colspan=3><a href="ceditor.php?a=add">Add New</A></td></tr>
		<tr>
			<td>Category ID</td>
			<td>Category Name</td>
			<td>Action</td>
		</tr>
	<?

	while ($rows = mysql_fetch_array($query)) {
		echo "
		<tr>
			<td>$rows[cid]</td>
			<td>$rows[catname]</td>
			<td><a href=\"ceditor.php?a=edit&cid=$rows[cid]\">Edit</a> / <a href=\"ceditor.php?a=del&cid=$rows[cid]\">Delete</a></td>
		</tr>
		";	
	}
	?>
		</table>
	<?
}

if ($a=="add" and !$submit) {
	?>
	<form action=ceditor.php method=post>
	<table align="center" width=90% border=0 cellspacing=3 cellpadding=0>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td>Category Name:</td><td><input type=text name=cats[]></td></tr>
	<tr><td colspan=2><input type=submit name=submit></td></tr>
	</table>
	<input type=hidden name=a value=add>
	</form>
	<?
}

if ($a=="add" and $submit) {
	$num_rows=count($cats);
	$cc = 0;
	for($i = 0;$i < $num_rows;++$i){
		if($cats[$i]!="") {
			mysql_db_query($dbname,"insert into top_cats (catname) values ('$cats[$i]')",$db) or die (mysql_error());
			$cc++;
		}
	}
	echo "<center>$cc categories has been added.</center>";
	echo "<center><a href=ceditor.php?a=add>Add New</a> / <a href=ceditor.php>Show categories list</a></center>";
}

if ($a == "edit" and !$submit) {
	$query = mysql_db_query ($dbname,"select * from top_cats where cid=$cid",$db) or die (mysql_error());
	$rows = mysql_fetch_array($query);
	
	echo "
	<form action=ceditor.php method=post>
		<table align=\"center\" width=90% border=0 cellspacing=3 cellpadding=0>
		<tr>
		<td>Category Name:</td><td><input type=text name=cname value=\"$rows[catname]\"></td>
		</tr>
		<tr><td colspan=3><input type=submit name=submit></td></tr>
		</table>
	<input type=hidden name=a value=edit>
	<input type=hidden name=cid value=$rows[cid]>
	</form>
	";
}

if ($a=="edit" and $submit) {
	mysql_db_query($dbname,"update top_cats set catname='$cname' where cid=$cid",$db) or die (mysql_error());
	echo "<center>$cname has been updated.</center>";
	echo "<center><a href=ceditor.php?a=add>Add New</a> / <a href=ceditor.php>Show categories list</a></center>";
}

if ($a=="del") {
	mysql_db_query($dbname,"delete from top_cats where cid=$cid",$db) or die (mysql_error());
	echo "<center>Category has been deleted.</center>";
	echo "<center><a href=ceditor.php?a=add>Add New</a> / <a href=ceditor.php>Show categories list</a></center>";
}

include "footer.php";
?>