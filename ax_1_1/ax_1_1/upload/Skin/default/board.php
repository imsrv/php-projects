<?
//+----------------------------------
//	AnnoucementX Board Script
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Description: Makes the AnnouncementX
//	show the index table
//+----------------------------------

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

if (isset($index)) {

} else {

	header("Location:index.php?do=");
	exit;
	
}

class BOARD {

	function board() {
	
	global $title, $used_skin, $functions;
	
echo <<<END
	<table width='750' align='center' border='1' style='border-collapse: collapse' cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - Home ::<br />
			Welcome, $username!
			</td>
		</tr>
		<tr>
END;
	if ($username!='' && $password!='') {
	
	$functions->do_menu($username,$password);
	
	} else {
	
	$functions->do_menu('','');
	
	}
echo <<<END
			<td align=left class='MAIN'>
			<b>Current Categories:</b>
END;
			$link=mysql_connect(HOST,USER,PASS) or die('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			$sql="SELECT * FROM categories LIMIT 0,30";
			$categories=mysql_query($sql) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_close($link);
			$num=mysql_num_rows($categories);
			$i=0;
			while ($i<$num) {
			$category_row=mysql_fetch_row($categories);
			$name=$category_row[1];
			$description=$category_row[2];
			$id=$category_row[0];
				$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
				mysql_select_db(DATA,$link);
				$posts_qr="SELECT * FROM posts WHERE Category=$name";
				$posts=mysql_query($posts_qr) or die ('AnnouncementX Error: ' . mysql_error());
				mysql_close($link);
				$posts_num=mysql_num_rows($posts);
			echo "<b><img src='./style_images'.$used_skin.'/fld.gif' width=24 height=24 alt=category border=0>&nbsp;<a href='index.php?do=show&category=$id'>$name</a></b>($posts_num posts)<br />$description<br /><br />";
			echo "should show a category";
			$i++;
			}
echo <<<END
			</td>
		</tr>
	</table>
END;
	}
}
?>