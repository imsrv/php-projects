<?
//+----------------------------------
//	AnnoucementX
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Updated: 2005/10/12
//	Description: Shows our posts in 
//	different categories
//+----------------------------------

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

if (isset($index)) {

} else {

	header("Location:index.php");

}

class Show {

	function do_show_category($category) {
	
	global $title, $used_skin, $functions, $category, $username, $password, $bbcode;
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$get_info_qr="SELECT id,Name,Description FROM categories WHERE id='$category' ORDER BY id DESC";
		$get_info=mysql_query($get_info_qr,$link) or die ('AnnouncementX Error: ' . mysql_error());
		$cat_info=mysql_fetch_row($get_info);
		
		$category_id=$cat_info[0];
		$category_name=$cat_info[1];
		
		$get_posts=mysql_query("SELECT * FROM posts WHERE Category='$category_id'",$link) or die ('AnnouncementX Error: ' . mysql_error());
		
		$num=mysql_num_rows($get_posts);
		
		if ($_SESSION['username']!='' && $_SESSION['password']!='' && isset($username,$password)) {
		
			$get_user_info="SELECT * FROM members WHERE Name='$username'";
			$get_user_info_run=mysql_query($get_user_info,$link) or die ('AnnouncementX Error: ' . mysql_error());
			$get_user_info_done=mysql_result($get_user_info_run,0,'Group');
			
			$get_groups_qr="SELECT Name,Pr_admin,Pr_mod FROM groups WHERE `Name`='$get_user_info_done'";
			$get_groups=mysql_query($get_groups_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			$group_permissions=mysql_fetch_row($get_groups);
			
			if ($get_user_info_done=='Admin' || $get_user_info_done=='Moderator' || $group_permissions[1]=='Yes' || $group_permissions[2]=='Yes') {
			
				$user_can=1;
			
			} else {
				
				$user_can=0;
				
			}
					
		} else {
			
			$user_can=0;
		
		}
			
		
		$check_badwords_qr="SELECT * FROM config WHERE Name='BadWords'";
		$check_badwords=mysql_query($check_badwords_qr,$link) or die ('AnnouncementX Error: ' . mysql_error());
		
		$check_badwords_result=mysql_result($check_badwords,0,'Value');
		
					
echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - $category_name ::
		</td>
	</tr>
	<tr>
END;
		$functions->do_menu($username,$password);
echo <<<END
		<td align=left class='MAIN'>
END;
			echo "<div id='navstrip'><a href='index.php?do=&". SID ."' title='Home'>$title</a> > <a href='index.php?do=show&category=$category". SID ."' title='View Category'>$category_name</a></div><br /><br />
			<div align=right><a href='index.php?do=replies&step=post_new&category=$category&poster=$username&". strip_tags(sid) ."' title='Make New Thread'>[ New Thread ]</a></div><br /><br /><hr width=90%><br />";
			
			if ($num=='0') {
			
				echo "There are no posts in this category";
			
			} else {
				
				for ($i=0; $i<$num; $i++) {
				
				$id=mysql_result($get_posts,$i,'id');
				$poster=mysql_result($get_posts,$i,'Poster');
				$title=mysql_result($get_posts,$i,'Title');
				$message=mysql_result($get_posts,$i,'Message');
				$sql=mysql_query("SELECT * FROM replies WHERE Post_title='$id' AND Category='$category_id'",$link) or die ('AnnouncementX Error: ' . mysql_error());
				$reply_rows=mysql_num_rows($sql);
				
				include ("./sources/bbcode.php");
																
					if ($user_can==1) {
					
						if ($check_badwords_result == 'On') {
						
							$get_badword_qr="SELECT * FROM badwords";
							$get_badword=mysql_query($get_badword_qr,$link) or die ('AnnouncementX Error: ' . mysql_error());
							
							$badwords_num=mysql_num_rows($get_badword);
							
							for ($b=0;$b<$badwords_num;$b++) {
							
								$badword=mysql_result($get_badword,$b,'Word');
								$message=str_replace($badword,"+-censored-+",$message);
							
							}
							
						}
							
					$output="<div align=left>Posted by: <a href='index.php?do=profile&step=view&who=$poster&". SID ."' title='View Profile of $poster'><b>$poster</b></a></div><br /><div align=right>[ <a href='index.php?do=replies&step=delete_post&category=$category&post=$id&". SID ."' title='Delete This Post'>Delete</a> ] [ <a href='index.php?do=replies&step=edit_post&category=$category&post=$id&". SID ."' title='Edit This Post'>Edit</a> ]</div><br /><b>$title</b> ($reply_rows replies)<br /><br />$message<br /><br /><a href='index.php?do=replies&step=view&category=$category&post=$id&". SID ."' title='View Replies'>View Replies To This Post</a><br /><br /><hr width=90%><br />";
					echo $output;
					
					} else {
					
						if ($check_badwords_result=='On') {
						
							$get_badword_qr="SELECT * FROM badwords";
							$get_badword=mysql_query($get_badword_qr,$link) or die ('AnnouncementX Error: ' . mysql_error());
							
							$badwords_num=mysql_num_rows($get_badword);
							
							for ($b=0;$b<$badwords_num;$b++) {
							
								$badword=mysql_result($get_badword,$b,'Word');
								$message=str_replace($badword,"+-censored-+",$message);
							
							}
							
						}
									
					$output_2="<div align=left>Posted by: <a href='index.php?do=profile&step=view&who=$poster&". SID ."' title='SView Profile of $poster'><b>$poster</b></a></div><br /><b>$title</b> ($reply_rows replies)<br /><br />$message<br /><br /><a href='index.php?do=replies&step=view&category=$category&post=$id&". SID ."' title='View Replies'>View Replies To This Post</a><br /><hr width=90%><br />";
					echo $output_2;
					
					}
				
				}
				
				echo "<br /><div align=right><a href='index.php?do=replies&step=post_new&category=$category&poster=$username&". strip_tags(sid) ."' title='Make New Thread'>[ New Thread ]</a></div>";
				
			} 
			
echo <<<END
		</td>
	</tr>
</table>
END;

		mysql_close($link);
		
	}
	
}
?>