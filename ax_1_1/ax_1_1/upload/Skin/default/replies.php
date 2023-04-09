 <?
//+----------------------------------
//	AnnoucementX
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Updated: 2005/10/12
//	Description: Shows our replies in 
//	different posts and makes new posts
//+----------------------------------

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

if (isset($index)) {

} else {

	header("Location:index.php");

}

class Replies {

	function go_switch($step) {
	
	global $functions, $username, $password, $category, $post;

		switch ($step) {
		
		case "view":
		
			$this->do_reply_view($category,$post);
			
		break;
		
		case "post_new":
	
			global $category;
			$cat=$category;
			$this->do_reply_post_new($cat,$poster);
	
		break;
		
		case "post_new_2":
			
			$this->do_new_finish();
			
		break;
		
		case "post_reply":
		
			$this->do_reply_post($category,$post,$poster);
			
		break;
		
		case "postreplyfinish":
		
			$this->do_reply_post_finish();
			
		break;
		
		case "delete_post":
		
			$this->do_reply_delete_post($category,$post);
			
		break;
		
		case "deletepostfinish":
		
			$this->do_reply_delete_finish();
			
		break;
		
		case "delete_reply":
		
			$this->do_reply_delete_reply($category,$post,$poster);
			
		break;
		
		case "deletereplyfinish":
		
			$this->do_reply_delete_reply_finish();
			
		break;
		
		case "edit_post":
		
			$this->do_reply_edit_post($category,$post);
			
		break;
		
		case "editpostfinish":
		
			$this->do_reply_edit_post_finish();
			
		break;
		
		case "edit_reply":
		
			$this->do_reply_edit_reply($category,$post,$poster);
			
		break;
		
		case "editreplyfinish":
		
			$this->do_reply_post_reply_finish();
			
		break;
		
		default: 
		
			if (!headers_sent) {
			
				header("Location:index.php?do=");
			
			} else {
			
				$url='index.php?do=';
				$functions->do_redirect($url);
			
			}
			
		break;
		
		}

	}

	function do_reply_view($category,$post) {
	
	global $functions, $errors, $username, $password, $category, $post, $title;
	
	$cat=$category;
	$pst=$post;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	if (isset($category,$post) && $category!='') {
	
		$category_name_qr=mysql_query("SELECT * FROM categories WHERE id='$category'") or die ("AnnouncementX Error(query/cat_name): " . mysql_error());
		$post_title_qr=mysql_query("SELECT * FROM posts WHERE id='$pst'") or die ("AnnouncementX Error(query/post_name): " . mysql_error());
		
		$category_name=mysql_fetch_row($category_name_qr);
		$post_title=mysql_fetch_row($post_title_qr);
		
	} else {
	
		echo "The post value is <b>$post</b> and category is <b>$category</b> but something does not work";
		
	}
	
	$query="SELECT * FROM replies WHERE Post_title='$post' AND Category='$cat'";
	$do_it=mysql_query($query) or die ('AnnouncementX Error(query/get_info): ' . mysql_error());

		if ($_SESSION['username']!='' && $_SESSION['password']!='' && isset($username,$password)) {
		
			$get_user_info="SELECT * FROM members WHERE Name='$username'";
			$get_user_info_run=mysql_query($get_user_info,$link) or die ('AnnouncementX Error: ' . mysql_error());
			$get_user_info_done=mysql_result($get_user_info_run,0,'Group');
			
			$get_groups_qr="SELECT Name,Pr_admin,Pr_mod FROM groups WHERE Name='$get_user_info_done'";
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
		
	$do_num=mysql_num_rows($do_it);
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$cat_id_qr=mysql_query("SELECT id, Name FROM categories WHERE id='$category'",$link) or die ('AnnouncementX Error: ' . mysql_error());
		$cat_id=mysql_fetch_row($cat_id_qr);
		
		$post_name_qr=mysql_query("SELECT Title FROM posts WHERE id='$post' AND Category='$cat_id[0]'",$link) or die ('AnnouncementX Error: ' . mysql_error());
		$post_name=mysql_fetch_row($post_name_qr);
		
		
		
echo <<<END
	<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - $cat_id[1] - View Replies ::
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
		<td align=center class='MAIN'>
		<div align='left' id='navstrip'>
		<a href='index.php?do=&'.SID title='Home'>$title</a> > <a href='index.php?do=show&category=$cat_id[0]&'.SID title='$cat_id[1]'>$cat_id[1]</a> > <a href='javascript:window.location=window.location()' title='$post_name'>$post_name[0]</a>
		</div>

END;

			$prev_qr="SELECT Poster,Message FROM posts WHERE Category='$cat_id[0]' AND id='$post'";
			$done=mysql_query($prev_qr,$link) or die ('AnnouncementX Error: ' . mysql_error());
			
			$b_qr=mysql_query("SELECT Value FROM config WHERE `Name`='BadWords'") or die ("AnnouncementX Error: " . mysql_error());
			$b_res=mysql_fetch_row($b_qr);

			$result=mysql_fetch_row($done);
			
				$blah_1=array("[B]","[I]","[U]","[IMG]","[URL=","[EMAIL=","/]","[QUOTE]","[CODE]");
				$blah_2=array("[/B]","[/I]","[/U]","[/IMG]","[/URL]","[/EMAIL]","/]","[/QUOTE]","[/CODE]");
				$blah_3=array("<b>","<i>","<u>","<img src=","<a href=","<a href=mailto:",">","<div id=quote align=left style='margin-left: 2'><b>Quote:</b><br />","<div id=code align=left style='margin-left: 2'><b>Code:</b><br />");
				$blah_4=array("</b>","</i>","</u>"," border=0>","</a>","</a>",">","</div>","</div>");
				$blah_5=array("[b]","[i]","[u]","[img]","[url=","[email=","/]","[quote]","[code]");
				$blah_6=array("[/b]","[/i]","[/u]","[/img]","[/url]","[/email","/]","[/quote]","[/code]");
						
				$result[1]=str_replace($blah_1,$blah_3,$result[1]);
				$result[1]=str_replace($blah_2,$blah_4,$result[1]);	
				$result[1]=str_replace($blah_5,$blah_3,$result[1]);
				$result[1]=str_replace($blah_6,$blah_4,$result[1]);
				
				$tags=array("<abbr","<acronym","<address","<applet","<area","<base","<basefont","<bdo","<bgsound","<big","<body","<button","<caption","<cite","<code","<colgroup","<dd","<dir","<div","<dfn","<dl","<dt","<em","<fieldset","<form","<frame","<frameset","<head","<html","<iframe", "<input","<ins","<kbd","<label","<legend","<map","<meta","<noframes","<object","<optgroup","<option","<param","<samp","<script","<select","<small","<style","<textarea","<title","<tt","<var","<xmp");
		
				$newtags=array("&lt;*abbr","&lt;*acronym","&lt;*address","&lt;*applet","&lt;*area","&lt;*base","&lt;*basefont","&lt;*bdo","&lt;*bgsound","&lt;*big","&lt;*body","&lt;*button","&lt;*caption","&lt;*cite", "&lt;*code","&lt;*colgroup","&lt;*dd","<dir","&lt;*div","&lt;*dfn","&lt;*dl","&lt;*dt","&lt;*em","&lt;*fieldset","&lt;*form","&lt;*frame","&lt;*frameset","&lt;*head","&lt;*html","&lt;*iframe", "&lt;*input","&lt;*ins","&lt;*kbd","&lt;*label","&lt;*legend","&lt;*map","&lt;*meta","&lt;*noframes","&lt;*object","&lt;*optgroup","&lt;*option","&lt;*param","&lt;*samp","&lt;*script","&lt;*select","&lt;*small","&lt;*style","&lt;*textarea","&lt;*title","&lt;*tt","&lt;*var","&lt;*xmp");
				
				$result[1]=str_replace($tags,$newtags,$result[1]);
				
				if ($b_res[0] == 'On') {
											
					$get_badword_qr="SELECT * FROM badwords";
					$get_badword=mysql_query($get_badword_qr,$link) or die ('AnnouncementX Error: ' . mysql_error());
							
					$badwords_num=mysql_num_rows($get_badword);
							
					for ($b=0;$b<$badwords_num;$b++) {
							
						$badword=mysql_result($get_badword,$b,'Word');
						$result[1]=str_replace($badword,"+-censored-+",$result[1]);
							
					}
				
				}
						
			echo "<div align=right><a href='index.php?do=replies&step=post_reply&category=$cat_id[0]&post=$post&poster=$username' title='Make A Reply'>[ Add Reply ]</a> | <a href='index.php?do=replies&step=post_new&category=$cat_id[0]&poster=$username' title='Make New Thread'>[ New Thread ]</a></div><br /><hr width=90%><br /><h3>$post_name[0]</h3><br /><div align=left>Posted by: <b>$result[0]</b><br />$result[1]<br /></div><hr width=90%><br />";
			
			$i=0;
			
			while ($i<$do_num) {
			
			$poster=mysql_result($do_it,$i,'Poster');
			$message=mysql_result($do_it,$i,'Message');
			$reply_id=mysql_result($do_it,$i,'id');
			
			include ("./sources/bbcode.php");
			
				if ($b_res[0] == 'On') {		
					
					$get_badword_qr="SELECT * FROM badwords";
					$get_badword=mysql_query($get_badword_qr,$link) or die ('AnnouncementX Error: ' . mysql_error());
					
					$badwords_num=mysql_num_rows($get_badword);
						
					for ($b=0;$b<$badwords_num;$b++) {
					
						$badword=mysql_result($get_badword,$b,'Word');
						$message=str_replace($badword,"+-censored-+",$message);
					
					}
					
				}
					
				if ($user_can==1) {
				
					$output="<div align=right>[ <a href='index.php?do=replies&step=delete_reply&category=$category&post=$reply_id&poster=$poster". SID ."' title='Delete This Reply'>Delete</a> ] [ <a href='index.php?do=replies&step=edit_reply&category=$cat_id[0]&post=$reply_id&poster=$poster". SID ."' title='Edit This Reply'>Edit</a> ]</div><br /><div align=left>Posted by: <a href='index.php?do=profile&step=view&who=$poster". SID ."' title='View Profile of $poster'><b>$poster</b></a></div><br /><div align='left'>$message</div><br /><hr width=90%><br />";
					echo $output;
				
				} else {
				
					$output_2="<div align=left>Posted by: <a href='index.php?do=profile&step=view&who=$poster". SID ."' title='View Profile of $poster'><b>$poster</b></a></div><br /><div align='left'>$message</div><br /><hr width=90%><br />";
					echo $output_2;
				
				}
				
			$i++;
			
			}
			
		echo "<div align=right><a href='index.php?do=replies&step=post_reply&category=$category&post=$post&poster=$username". SID ."' title='Make A Reply'>[ Add Reply ]</a> | <a href='index.php?do=replies&step=post_new&catgory=$category_name&poster=$username". SID ."' title='Make New Thread'>[ New Thread ]</a></div><br />";

echo <<<END
		</td>
	</tr>
	</table>
END;

	mysql_close($link);
		
	}
		
	function do_reply_post_new($cat,$poster) {
	
	global $functions, $title, $username, $password;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$user_post=$poster;
	
	if (empty($cat)) {
	
		echo "<center><b>Critical Error</b><br />Category is not defined!</center>";
		exit;
		
	}
	
	$cat_id_qr=mysql_query("SELECT id,Name FROM categories WHERE id='$cat'",$link) or die ('AnnouncementX Error: ' . mysql_error());
	$cat_id[0]=mysql_result($cat_id_qr,0,"id");
	$cat_id[1]=mysql_result($cat_id_qr,0,"Name");
	
	if (empty($cat_id[1]) or empty($cat_id[0])) {
	
		echo "<center><b>Critical Error!</b><br />Category or id is not defined!</center>";
		exit;
	
	}
			
	$post_name_qr=mysql_query("SELECT Title FROM posts WHERE id='$post'",$link) or die ('AnnouncementX Error: ' . mysql_error());
	$post_name=mysql_fetch_row($post_name_qr);

	
	$guest_qr="SELECT * FROM config WHERE Name='Guests_post'";
	$guest_run=mysql_query($guest_qr) or die ('AnnouncementX Error: ' . mysql_error());
	
	$guest=mysql_result($guest_run,0,'Value');
	
		if ($guest == 'Off') {
		
			if (empty($username) || empty($password)) {
			
				$functions->guest_cant_post();
				exit;
			
			}
		
		} else {
		
		}
			
echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - $cat_id[1] - Post New Thread ::
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
		<td align=center class='MAIN'>
END;
		echo "<div align='left' id='navstrip'>
		<a href='index.php?do=&'.strip_tags(sid). title='Home'>$title</a> > <a href='index.php?do=show&category=$cat_id[0]&'.strip_tags(sid). title='$cat_id[1]'>$cat_id[1]</a> > <a href='javascript:window.location()'.strip_tags(sid). title='Making a new thread'>New Thread</a>
		</div>";
echo <<<END
		
		<h3>Post New Thread</h3><br />
		
END;

		$functions->BBCode();
		
echo <<<END
		
		<form name='replies' action='index.php?do=replies&step=post_new_2' method='post' onsubmit='ValidateForm()'>
			<input type=hidden name='poster' value=$poster>
			<input type=hidden name='category' value='$cat_id[0]'>
			<label for='title'><b>Title: </b></label><input type=text name=title value='Post Title Is Here' onfocus="this.value=''" size='50' maxlength=255>
			<br />
			<br /><textarea name='message' cols=48 rows=12 class=textarea></textarea>
			<br />
			<br />
			<input type=submit name=submit value='Make A Thread' class=submit>  <input type=reset name=reset class=submit>
		</form>
		
		</td>
	</tr>
</table>
END;
	
	mysql_close($link);

	}
	
	function do_new_finish() {
	
	global $errors, $functions, $username;
	
		$category=$_POST['category'];
		$title=$_POST['title'];
		$message=$_POST['message'];
		$message=nl2br($message);
		
		if (isset($title,$message)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql = "INSERT INTO `posts` (`id`, `Category`, `Poster`, `Title`, `Message`) VALUES ('', '$category', '$username', '$title', '$message')";
			$post=mysql_query($sql) or die ('AnnouncementX Error: ' . mysql_error());
			
			$category_id_get=mysql_query("SELECT id FROM categories WHERE `id`='$category'") or die ('AnnouncementX Error (select id error): ' . mysql_error());
			$category_id=mysql_result($category_id_get,0,'id');
			if (!$category_id) {
				
				echo "There was an error in getting the category id, the value is automatically set to <b>1</b>";
				$category_id=1;
				
			}
			
			mysql_close($link);
			
			$url='index.php?do=show&category='.$category_id.'&'.strip_tags(sid);
			echo "<center>Thread <b>$title</b> succesfully created!</center>";
			$functions->do_redirect($url);
			exit;
			
		} else {
		
			echo "<center><b>General Error!</b></center>";
			$errors->error_fill_in_all_fields();
			exit;
			
		}
	}
	
	function do_reply_post($category,$post,$poster) {
	
	global $errors, $functions, $title, $username, $password;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$sql = "SELECT * FROM `config` WHERE `Name`='Guests_post' LIMIT 0, 30";
	$guest_run=mysql_query($sql) or die ('AnnouncementX Error (Guests/query): ' . mysql_error());
	
	$cat_id_qr=mysql_query("SELECT id,Name FROM categories WHERE id='$category'",$link) or die ('AnnouncementX Error (Category/query): ' . mysql_error());
	$cat_id=mysql_fetch_row($cat_id_qr);
		
	$post_name_qr=mysql_query("SELECT Title FROM posts WHERE id='$post'",$link) or die ('AnnouncementX Error (Post/query): ' . mysql_error());
	$post_name=mysql_fetch_row($post_name_qr);
	
	$guest=mysql_result($guest_run,0,'Value');
	
		if ($guest = 'Off') {
		
			if (empty($username) || empty($password)) {
			
				$functions->guest_cant_post();
				exit;
			
			}
		
		}	
		
echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - $cat_id[1] - Post A Reply ::
		</td>
	</tr>
	<tr>
END;
		$functions->do_menu($username,$password);
echo <<<END
		<td align=center class='MAIN'>
		<div align='left' id='navstrip'>
		<a href='index.php?do=' title='Home'>$title</a> > <a href='index.php?do=show&category=$cat_id[0]' title='$cat_id[1]'>$cat_id[1]</a> > <a href='javascript:window.location()' title='$post'>$post_name[0]</a>
		</div>

		<h3>Post Reply to $post_name[0]</h3><br />
		
END;

		$functions->BBCode();

echo <<<END
		
		<form name='replies' action='index.php?do=replies&step=postreplyfinish&'.SID method='post' onsubmit='ValidateForm()'>
		<input type=hidden name='category' value='$cat_id[0]'>
		<input type=hidden name='post' value=$post>
		<input type=hidden name='poster' value=$poster>
		<b>Message: </b><br />
		<textarea name='message' cols='48' rows='12' onfocus="" class=textarea>Your Message Is Here</textarea><br /><br />
		<input type=submit name=submit value='Post A Reply' class=submit>  <input type=reset name=reset>		
		</form>
		</td>
	</tr>
</table>
END;

	mysql_close($link);
	
	}
	
	function do_reply_post_finish() {
	
		global $functions, $errors, $username;
		
		$category=$_POST['category'];
		$post=$_POST['post'];
		$poster=$username;
		$message=$_POST['message'];
		$message=nl2br($message);
	
		if (isset($message)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$post_qr="INSERT INTO replies(id,Category,Poster,Post_title,Message) VALUES ('','$category','$poster','$post','$message')";
			$post=mysql_query($post_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			$category_id_qr="SELECT * FROM categories WHERE `id`='$category'";
			$category_id_get=mysql_query($category_id_qr) or die ('AnnouncementX Error: ' . mysql_error());
			$category_id=mysql_result($category_id_get,0,'id');
			
			mysql_close($link);
			
			$url='index.php?do=show&category='.$category_id.'&'.strip_tags(sid);
			$functions->do_redirect($url);
			
		} else {
		
			$errors->error_fill_in_all_fields();
			
		}
		
	}
	
	function do_reply_delete_post($category,$post) {
	
	global $title, $category, $post, $functions, $username, $password;
	
	$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
	mysql_select_db(DATA,$link);
	
	$sql=mysql_query("SELECT Name FROM categories WHERE `id`='$category'") or die ("AnnouncementX Error: " . mysql_error());
	
	mysql_close($link);
	
	$result=mysql_fetch_row($sql);
	
echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - $result[0] - Delete Thread ::
		</td>
	</tr>
	<tr>
END;
	
	$functions->do_menu($username,$password);
	
echo <<<END
		<td align=center class='MAIN'>
		<b>Are you sure you want to delete this post?</b><br />
		<form name='replies' action='index.php?do=replies&step=deletepostfinish&'.SID method='post' onsubmit='ValidateForm()'>
		<input type=hidden name='category' value='$category'>
		<input type=hidden name='post' value='$post'>
		<input type=submit name=submit value='Yes' class=submit>
		</form>
		<form name='back' action='javascript:history.back()'>
		<input type=submit name=submit value='No' class=submit>
		</form>
		</td>
	</tr>
</table>
END;

	}
	
	function do_reply_delete_finish() {
	
		global $functions, $category, $post, $username, $password;
		
		$category=$_POST['category'];
		$post=$_POST['post'];
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$post_name_qr=mysql_query("SELECT * FROM posts WHERE id='$post'") or die ("AnnouncementX Error: " . mysql_error());
		$post_name=mysql_fetch_row($post_name_qr);
		
		$category_id_qr="SELECT * FROM categories WHERE id='$category'";
		$category_id_get=mysql_query($category_id_qr) or die ('AnnouncementX Error: ' . mysql_error());
		$category_id=mysql_result($category_id_get,0,'Name');
		$category_id2=mysql_result($category_id_get,0,'id');
		
		$delete_qr="DELETE FROM posts WHERE Category='$category_id2' AND id='$post'";
		$delete=mysql_query($delete_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
		mysql_close($link);
		
		echo "<center>Post <b>$post_name[3]</b> has been succsefully deleted</center>";
		
		$url="index.php?do=show&category=".$category_id2."&".strip_tags(sid);
		$functions->do_redirect($url);
		
	}
	
	function do_reply_delete_reply($category,$post,$poster) {
	
	global $title, $functions, $category, $post, $poster, $username, $password;
	
	$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
	mysql_select_db(DATA,$link);
	
	$sql=mysql_query("SELECT Name FROM categories WHERE `id`='$category'") or die ("AnnouncementX Error: " . mysql_error());
	$result=mysql_fetch_row($sql);
	
	mysql_close($link);
	
echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - $result[0] - Delete Reply ::
		</td>
	</tr>
	<tr>
END;

		$functions->do_menu($username,$password);
		
echo <<<END
		<td align=center class='MAIN'>
		<b>Are you sure you want delete the reply made by $poster?</b><br />
		<form name='replies' action='index.php?do=replies&step=deletereplyfinish&'.SID method='post' onsubmit='ValidateForm()'>
		<input type=hidden name='category' value=$category>
		<input type=hidden name='post' value=$post>
		<input type=hidden name='poster' value=$poster>
		<input type=submit name=submit value='Yes' class=submit>
		</form>
		<form name='back' action='javascript:history.back()'>
		<input type=submit name=submit value='No' class=submit>
		</form>
		</td>
	</tr>
</table>
END;

	}
	
	function do_reply_delete_reply_finish() {
	
		global $functions, $category, $post, $poster, $username, $password;
		
		$category=$_POST['category'];
		$post=$_POST['post'];
		$poster=$_POST['poster'];
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$category_qr="SELECT * FROM categories WHERE id='$category'";
		$category_run=mysql_query($category_qr) or die ('AnnouncementX Error: ' . mysql_error());
		$category_get=mysql_result($category_run,0,'Name');
		$category_get2=mysql_result($category_run,0,'id');
		
		$delete_qr="DELETE FROM replies WHERE Category='$category_get2' AND id='$post'";
		$delete=mysql_query($delete_qr) or die ('AnnouncementX Error: ' . mysql_error());		
		
		mysql_close($link);
		
		echo "<center>Reply made by <b>$poster</b> has been succesfully deleted</center";
		
		$url="index.php?do=show&category=".$category_get2."&".strip_tags(sid);
		$functions->do_redirect($url);
	
	}
	
	function do_reply_edit_post($category,$post) {
	
	global $title, $functions, $category, $post, $username, $password;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$category_name_qr=mysql_query("SELECT * FROM categories WHERE id='$category'") or die ('AnnouncementX Error: ' . mysql_error());
	$category_name=mysql_fetch_row($category_name_qr);
	
	$get_qr="SELECT * FROM posts WHERE id='$post' AND Category='$category_name[0]'";
	$get=mysql_query($get_qr) or die ('AnnouncementX Error: ' . mysql_error());
	
	$name=mysql_result($get,0,'Title');
	$message=mysql_result($get,0,'Message');
	$posted=mysql_result($get,0,'Poster');
	
	$message=str_replace('<br />','',$message);
	
	$cat_id_qr=mysql_query("SELECT id FROM categories WHERE Name='$category'",$link) or die ('AnnouncementX Error: ' . mysql_error());
	$cat_id=mysql_fetch_row($cat_id_qr);
		
	$post_name_qr=mysql_query("SELECT Title FROM posts WHERE id='$post'",$link) or die ('AnnouncementX Error: ' . mysql_error());
	$post_name=mysql_fetch_row($post_name_qr);

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - $category_name[1] - Edit Post ::
		</td>
	</tr>
	<tr>
END;

		$functions->do_menu($username,$password);
		
echo <<<END

		<td align=center class='MAIN'>
		<div align='left' id='navstrip'>
		<a href='index.php?do=' title='Home'>$title</a> > <a href='index.php?do=show&category=$category' title='$category_name[1]'>$category_name[1]</a> > <a href='javascript:window.location()' title='$post'>$post_name[0]</a>
		</div>
		
		<form name='replies' action='index.php?do=replies&step=editpostfinish&'.SID method='post' onsubmit='ValidateForm()'>
		<input type=hidden name='post' value='$post'>
		<input type=hidden name='category' value='$category'>
		<b>Current Post Title:</b><br />
		<input type=text name='title' value='$name' onfocus="this.value=''" size='50'><br /><br />
		
END;

		$functions->BBCode();

echo <<<END
		
		<strong>Current Message:</strong><br />
		<textarea name='message' cols=48 rows=12 class=textarea>$message</textarea><br /><br />
		<input type=submit name=submit value='Edit This Post' class=submit>  <input type=reset name=reset class=submit>
		</form>
		<form name='back' action='javascript:history.back()'>
		<input type=submit name=submit value='Back' class=submit>
		</form>
		</td>
	</tr>
</table>
END;

	mysql_close($link);

	}
	
	function do_reply_edit_post_finish() {
	
		global $functions, $name, $message, $category, $post, $username, $password, $errors;
		
		$post=$_POST['post'];
		$category=$_POST['category'];
		$name=$_POST['title'];
		$message=$_POST['message'];
		$message=nl2br($message);
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$update_qr="UPDATE posts SET Title='$name', Message='$message' WHERE id='$post'";
		$update=mysql_query($update_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
		$category_id_get=mysql_query("SELECT id FROM categories WHERE id='$category'") or die ('AnnouncementX Error: ' . mysql_error());
		$category_id=mysql_result($category_id_get,0,'id');
		
		mysql_close($link);
		
		$url="index.php?do=show&category=".$category."&".strip_tags(sid);
		$functions->do_redirect($url);
	
	}
	
	function do_reply_edit_reply($category,$post,$poster) {
	
	global $functions, $title;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$info_qr="SELECT * FROM replies WHERE id=$post AND Category=$category";
	$info=mysql_query($info_qr) or die ('AnnouncementX Error: ' . mysql_error());
	
	$message=mysql_result($info,0,'Message');
	
	$message=str_replace('<br />','',$message);
	
	$cat_id_qr=mysql_query("SELECT id FROM categories WHERE Name='$category'",$link) or die ('AnnouncementX Error: ' . mysql_error());
	$cat_id=mysql_fetch_row($cat_id_qr);
		
	$post_name_qr=mysql_query("SELECT Name FROM posts WHERE id='$post'",$link) or die ('AnnouncementX Error: ' . mysql_error());
	$post_name=mysql_fetch_row($post_name_qr);

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER'>
		:: $title - $category - Edit Reply ::
		</td>
	</tr>
	<tr>
END;
		$functions->do_menu($username,$password);
echo <<<END
		<td align=center class='MAIN'>
			<div align='left' id='navstrip'>
		<a href='index.php?do=' title='Home'>$title</a> > <a href='index.php?do=show&category=$cat_id[0]' title='$category'>$category</a> > <a href='javascript:window.location()' title='$post'>$post_name[0]</a>
		</div>
		
END;

		$functions->BBCode();

echo <<<END

		<form name='replies' action='index.php?do=replies&step=editreplyfinish&'.SID method='post' onsubmit='ValidateForum()'>
		<strong>Current Message:</strong><br />
		<input type=hidden name='category' value=$category>
		<input type=hidden name='post' value=$post>
		<input type=hidden name='poster' value=$poster>
		<textarea name='message' cols=48 rows=12 class=textarea>$message</textarea><br /><br />
		<input type=submit name=submit value='Edit This Post' class=submit>  <input type=reset name=reset class=submit>
		</form>
		<form name='back' action='javascript:history.back()'>
		<input type=submit name=submit value='Back'>
		</form>
		</td>
	</tr>
</table>
END;

	mysql_close($link);

	}
	
	function do_reply_edit_reply_finish() {
	
		global $functions;
		
		$category=$_POST['category'];
		$post=$_POST['post'];
		$poster=$_POST['poster'];
		$message=$_POST['message'];

		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);

		$update_qr="UPDATE replies SET `Message`='$message' WHERE id=$post";
		$update=mysql_query($update_qr) or die ('AnnouncementX Error: ' . mysql_error());

		$category_id_get=mysql_query("SELECT id FROM categories WHERE id=$category") or die ('AnnouncementX Error: ' . mysql_error());
		$category_id=mysql_result($category_id_get,0,'id');

		mysql_close($link);

		$url='index.php?do=show&category='.$category_id;
		$functions->do_redirect($url);
		
	}

}
?>