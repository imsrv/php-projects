<?php
$title = "Post / Edit";
/* <Edit> */

function add_magic_quotes($array) {
	foreach ($array as $k => $v) {
		if (is_array($v)) {
			$array[$k] = add_magic_quotes($v);
		} else {
			$array[$k] = addslashes($v);
		}
	}
	return $array;
} 

if (!get_magic_quotes_gpc()) {
	$HTTP_GET_VARS    = add_magic_quotes($HTTP_GET_VARS);
	$HTTP_POST_VARS   = add_magic_quotes($HTTP_POST_VARS);
	$HTTP_COOKIE_VARS = add_magic_quotes($HTTP_COOKIE_VARS);
}

$b2varstoreset = array('action','safe_mode','withcomments','c','posts','poststart','postend','content','edited_post_title','comment_error','profile', 'trackback_url');
for ($i=0; $i<count($b2varstoreset); $i += 1) {
	$b2var = $b2varstoreset[$i];
	if (!isset($$b2var)) {
		if (empty($HTTP_POST_VARS["$b2var"])) {
			if (empty($HTTP_GET_VARS["$b2var"])) {
				$$b2var = '';
			} else {
				$$b2var = $HTTP_GET_VARS["$b2var"];
			}
		} else {
			$$b2var = $HTTP_POST_VARS["$b2var"];
		}
	}
}

switch($action) {
	
case 'post':

	$standalone = 1;
	require_once('./b2header.php');

	$post_autobr = intval($HTTP_POST_VARS["post_autobr"]);
	$post_pingback = intval($HTTP_POST_VARS["post_pingback"]);
	if ($use_ljupdate) {
		$post_ljupdate = intval($HTTP_POST_VARS["post_ljupdate"]);
	}
	$content = balanceTags($HTTP_POST_VARS["content"]);
	$content = format_to_post($content);
	$post_title = addslashes($HTTP_POST_VARS["post_title"]);
	$post_category = intval($HTTP_POST_VARS["post_category"]);

	if ($user_level == 0)
	die ("Cheatin' uh ?");

	if (($user_level > 4) && (!empty($HTTP_POST_VARS["edit_date"]))) {
		$aa = $HTTP_POST_VARS["aa"];
		$mm = $HTTP_POST_VARS["mm"];
		$jj = $HTTP_POST_VARS["jj"];
		$hh = $HTTP_POST_VARS["hh"];
		$mn = $HTTP_POST_VARS["mn"];
		$ss = $HTTP_POST_VARS["ss"];
		$jj = ($jj > 31) ? 31 : $jj;
		$hh = ($hh > 23) ? $hh - 24 : $hh;
		$mn = ($mn > 59) ? $mn - 60 : $mn;
		$ss = ($ss > 59) ? $ss - 60 : $ss;
		$now = "$aa-$mm-$jj $hh:$mn:$ss";
	} else {
		$now = date("Y-m-d H:i:s",(time() + ($time_difference * 3600)));
	}

	$query = "INSERT INTO $tableposts (ID, post_author, post_date, post_content, post_title, post_category) VALUES ('0','$user_ID','$now','$content','".$post_title."','".$post_category."')";
	$result = mysql_query($query) or mysql_oops($query);

	$post_ID = mysql_insert_id();

	if (isset($sleep_after_edit) && $sleep_after_edit > 0) {
		sleep($sleep_after_edit);
	}

	rss_update($blog_ID);
	pingWeblogs($blog_ID);
	pingCafelog($cafelogID, $post_title, $post_ID);
	pingBlogs($blog_ID);
	if ($post_pingback) {
		pingback($content, $post_ID);
	}

	if ($post_ljupdate) {
		lj_update($post_ID, $user_ID, $now, $post_title, $content);
	}

	if (!empty($HTTP_POST_VARS['trackback_url'])) {
		$excerpt = (strlen(strip_tags($content)) > 255) ? substr(strip_tags($content), 0, 252).'...' : strip_tags($content);
		$excerpt = stripslashes($excerpt);
		$trackback_urls = explode(',', $HTTP_POST_VARS['trackback_url']);
		foreach($trackback_urls as $tb_url) {
			$tb_url = trim($tb_url);
			trackback($tb_url, stripslashes($post_title), $excerpt, $post_ID);
		}
	}

	if (!empty($HTTP_POST_VARS["mode"])) {
		switch($HTTP_POST_VARS["mode"]) {
			case "bookmarklet":
				$location="b2bookmarklet.php?a=b";
				break;
			case "sidebar":
				$location="b2sidebar.php?a=b";
				break;
			default:
				$location="b2edit.php";
				break;
		}
	} else {
		$location="b2edit.php";
	}
	header("Location: $location");
	exit();

break;

case "edit":

	$standalone=0;
	require_once ("./b2header.php");
	$post = $HTTP_GET_VARS["post"];
	if ($user_level > 0) {
		$postdata=get_postdata($post) or die("Oops, no post with this ID. <a href=\"b2edit.php\">Go back</a> !");
		$authordata = get_userdata($postdata["Author_ID"]);
	if ($user_level < $authordata[13])
	die ("You don't have the right to edit <b>".$authordata[1]."</b>'s posts.");

	$content = $postdata["Content"];
	$content = format_to_edit($content);
	$edited_post_title = format_to_edit($postdata["Title"]);

	echo $blankline;
	include($b2inc."/b2edit.form.php");

	} else {
	?>

	Since you're a newcomer, you'll have to wait for an admin to raise your level to 1, in order to be authorized to post.<br />You can also <a href="mailto:<?php echo $admin_email ?>?subject=b2-promotion">e-mail the admin</a> to ask for a promotion.<br />When you're promoted, just reload this page and you'll be able to blog. :)

	<?php
	}

break;

case "editpost":

	$standalone = 1;
	require_once("./b2header.php");
	
	if ($user_level == 0)
	die ("Cheatin' uh ?");

	if (!isset($blog_ID)) {
		$blog_ID = 1;
	}
	$post_ID = $HTTP_POST_VARS["post_ID"];
	$post_category = intval($HTTP_POST_VARS["post_category"]);
	$post_autobr = intval($HTTP_POST_VARS["post_autobr"]);
	$content = balanceTags($HTTP_POST_VARS["content"]);
	$content = format_to_post($content);
	$post_title = addslashes($HTTP_POST_VARS["post_title"]);

	if (($user_level > 4) && (!empty($HTTP_POST_VARS["edit_date"]))) {
		$aa = $HTTP_POST_VARS["aa"];
		$mm = $HTTP_POST_VARS["mm"];
		$jj = $HTTP_POST_VARS["jj"];
		$hh = $HTTP_POST_VARS["hh"];
		$mn = $HTTP_POST_VARS["mn"];
		$ss = $HTTP_POST_VARS["ss"];
		$jj = ($jj > 31) ? 31 : $jj;
		$hh = ($hh > 23) ? $hh - 24 : $hh;
		$mn = ($mn > 59) ? $mn - 60 : $mn;
		$ss = ($ss > 59) ? $ss - 60 : $ss;
		$pd = "$aa-$mm-$jj $hh:$mn:$ss";
		$datemodif = ", post_date=\"$aa-$mm-$jj $hh:$mn:$ss\"";
	} else {
		$datemodif = "";
	}

	$query = "UPDATE $tableposts SET post_content=\"$content\", post_title=\"$post_title\", post_category=\"$post_category\"".$datemodif." WHERE ID=$post_ID";
	$result = mysql_query($query) or mysql_oops($query);

	if (isset($sleep_after_edit) && $sleep_after_edit > 0) {
		sleep($sleep_after_edit);
	}

	if ($use_ljupdate) {
		if ( empty( $pd ) ){
			$query = "SELECT post_date FROM $tableposts WHERE ID = $post_ID";
			$querycount++;
			$result = mysql_query($query) or die("Error in editing... ".mysql_error()."<br />$query<br />contact the <a href=\"mailto:$admin_email\">webmaster</a>");
			$pdr = mysql_fetch_array( $result );
			$pd = $pdr['post_date'];
		}
		lj_edit($post_ID, $user_ID, $pd, $post_title, $content);
	}

	rss_update($blog_ID);
//	pingWeblogs($blog_ID);

	$location = "Location: b2edit.php";
	header ($location);

break;

case "delete":

	$standalone = 1;
	require_once("./b2header.php");

	if ($user_level == 0)
	die ("Cheatin' uh ?");

	$post = $HTTP_GET_VARS['post'];
	$postdata=get_postdata($post) or die("Oops, no post with this ID. <a href=\"b2edit.php\">Go back</a> !");
	$authordata = get_userdata($postdata["Author_ID"]);

	if ($user_level < $authordata[13])
	die ("You don't have the right to delete <b>".$authordata[1]."</b>'s posts.");

	$query = "DELETE FROM $tableposts WHERE ID=$post";
	$result = mysql_query($query) or die("Oops, no post with this ID. <a href=\"b2edit.php\">Go back</a> !");
	if (!$result)
	die("Error in deleting... contact the <a href=\"mailto:$admin_email\">webmaster</a>...");

	$query = "DELETE FROM $tablecomments WHERE comment_post_ID=$post";
	$result = mysql_query($query) or die("Oops, no comment associated to that post. <a href=\"b2edit.php\">Go back</a> !");

	if (isset($sleep_after_edit) && $sleep_after_edit > 0) {
		sleep($sleep_after_edit);
	}

	if ($use_ljupdate) {
		lj_delete($post, $user_ID);
	}

	rss_update($blog_ID);
//	pingWeblogs($blog_ID);

	header ("Location: b2edit.php");

break;

case "editcomment":

	$standalone=0;
	require_once ("./b2header.php");

	get_currentuserinfo();

	if ($user_level == 0) {
		die ("Cheatin' uh ?");
	}

	$comment = $HTTP_GET_VARS['comment'];
	$commentdata = get_commentdata($comment,1) or die("Oops, no comment with this ID. <a href=\"javascript:history.go(-1)\">Go back</a> !");
	$content = $commentdata["comment_content"];
	$content = format_to_edit($content);
	
	echo $blankline;
	include($b2inc."/b2edit.form.php");

break;

case "deletecomment":

	$standalone = 1;
	require_once("./b2header.php");

	if ($user_level == 0)
		die ("Cheatin' uh ?");

	$comment = $HTTP_GET_VARS['comment'];
	$p = $HTTP_GET_VARS['p'];
	$commentdata=get_commentdata($comment) or die("Oops, no comment with this ID. <a href=\"b2edit.php\">Go back</a> !");

	$query = "DELETE FROM $tablecomments WHERE comment_ID=$comment";
	$result = mysql_query($query) or die("Oops, no comment with this ID. <a href=\"b2edit.php\">Go back</a> !");

	header ("Location: b2edit.php?p=$p&c=1#comments"); //?a=dc");

break;

case "editedcomment":

	$standalone = 1;
	require_once("./b2header.php");

	if ($user_level == 0)
		die ("Cheatin' uh ?");

	$comment_ID = $HTTP_POST_VARS['comment_ID'];
	$comment_post_ID = $HTTP_POST_VARS['comment_post_ID'];
	$newcomment_author = $HTTP_POST_VARS['newcomment_author'];
	$newcomment_author_email = $HTTP_POST_VARS['newcomment_author_email'];
	$newcomment_author_url = $HTTP_POST_VARS['newcomment_author_url'];
	$newcomment_author = addslashes($newcomment_author);
	$newcomment_author_email = addslashes($newcomment_author_email);
	$newcomment_author_url = addslashes($newcomment_author_url);
	$post_autobr = $HTTP_POST_VARS["post_autobr"];

	if (($user_level > 4) && (!empty($HTTP_POST_VARS["edit_date"]))) {
		$aa = $HTTP_POST_VARS["aa"];
		$mm = $HTTP_POST_VARS["mm"];
		$jj = $HTTP_POST_VARS["jj"];
		$hh = $HTTP_POST_VARS["hh"];
		$mn = $HTTP_POST_VARS["mn"];
		$ss = $HTTP_POST_VARS["ss"];
		$jj = ($jj > 31) ? 31 : $jj;
		$hh = ($hh > 23) ? $hh - 24 : $hh;
		$mn = ($mn > 59) ? $mn - 60 : $mn;
		$ss = ($ss > 59) ? $ss - 60 : $ss;
		$datemodif = ", comment_date=\"$aa-$mm-$jj $hh:$mn:$ss\"";
	} else {
		$datemodif = "";
	}
	$content = balanceTags($content);
	$content = format_to_post($content);

	$query = "UPDATE $tablecomments SET comment_content=\"$content\", comment_author=\"$newcomment_author\", comment_author_email=\"$newcomment_author_email\", comment_author_url=\"$newcomment_author_url\"".$datemodif." WHERE comment_ID=$comment_ID";
	$result = mysql_query($query) or mysql_oops($query);

	header ("Location: b2edit.php?p=$comment_post_ID&c=1#comments"); //?a=ec");

break;

default:

	$standalone=0;
	require_once ("./b2header.php");
	
	if ($user_level > 0) {
		if ((!$withcomments) && (!$c)) {

			$action="post";
			include($b2inc."/b2edit.form.php");
			echo "<br /><br />";

		}	

	} else {

		echo $tabletop; ?>
		Since you're a newcomer, you'll have to wait for an admin to raise your level to 1, in order to be authorized to post.<br />You can also <a href="mailto:<?php echo $admin_email ?>?subject=b2-promotion">e-mail the admin</a> to ask for a promotion.<br />When you're promoted, just reload this page and you'll be able to blog. :)
		<?php
		echo $tablebottom;
		echo "<br /><br />";

	}

	include($b2inc."/b2edit.showposts.php");

}


/* </Edit> */
include($b2inc."/b2footer.php") ?>