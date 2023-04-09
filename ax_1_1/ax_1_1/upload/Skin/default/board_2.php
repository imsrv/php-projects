<?
//+----------------------------------
//	AnnoucementX Board Script
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Updated: 2005/10/12
//	Description: Makes the AnnouncementX
//	show the index table
//+----------------------------------

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

if (isset($index)) {

} else {

	header("Location:index.php");

}

class BOARD {

	function show_board() {
	
	global $title, $used_skin, $functions, $username, $password;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	
	mysql_select_db(DATA,$link);
	
echo <<<END
		<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - Home ::
			</td>
		</tr>
		<tr>
END;

	if ($username!='') {
	
		$functions->do_menu($username,$password);
	
	} else {
	
		$functions->do_menu('','');
	
	}
	
echo <<<END
			<td align=left class='MAIN'>
			<b>Current Categories:</b>
			<br /><br />
END;

	$sql="SELECT * FROM categories LIMIT 0,50";
	$query=mysql_query($sql,$link) or die ('AnnouncementX Error(query/categories error): ' . mysql_error());
	
	$rows=mysql_num_rows($query);
	
		for ($i=0; $i<$rows; $i++) {
		
		$row_info=mysql_fetch_row($query);
		
		$id=$row_info[0];
		$name=$row_info[1];
		$description=$row_info[2];
		
		$posts_qr="SELECT id, Category FROM posts WHERE Category='$id'";
		$posts=mysql_query($posts_qr,$link) or die ('AnnouncementX Error(query/posts error): ' . mysql_error());
		$nop=mysql_num_rows($posts);
						
		echo "<b><img src='./style_images".$used_skin."fld.gif' width=16 height=16 alt=category border=0>&nbsp;<a href='index.php?do=show&category=$id&".SID."'>$name</a></b>($nop posts)<br />$description<br /><br />";
		
		}
echo "
			</td>
		</tr>
	</table>
";
	mysql_close($link);
	
	}

}
?>