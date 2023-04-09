<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#           Stringer Software Solutions                                      #
#           www.freekrai.net                                                 #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Stringer Software              #
#    Solutions is strictly forbidden.                                        #
#                                                                            #
##############################################################################
?>
<?
$formrep = error_reporting(0);
unset($form);
unset($formx);
unset($formerr);

function form_fail($msg, $var, $limit = 0){
	global $form, $formx, $formerr;
	$formerr[$var] = 1;
	echo "<div class=error>$msg</div>\n";
	if(!$limit)
		$form[$var] = $formx[$var];
	else 
		$form[$var] = substr($form[$var], 0, $limit);
}
$_GET['id'] = addslashes($_GET['id']);
$_GET['ed'] = addslashes($_GET['ed']);

if (!$_add){
	$r = mysql_fetch_object(mysql_query("SELECT type,id,username FROM epay_users WHERE id=".$_GET['ed']));
  	$opposite = ($r->type == 'wm' ? $pr : $wm);
	$sql = "SELECT mark,comment FROM epay_reviews WHERE pid='".$_GET['id']."' AND user='".$_GET['ed']."'";
	$form = mysql_fetch_array(mysql_query($sql), MYSQL_ASSOC);
	$k = mysql_fetch_object(mysql_query("SELECT openedby AS wm,programmer AS pr FROM epay_projects WHERE id=".$_GET['id']));
	$form["wm"] = $k->wm;
	$form["pr"] = $k->pr;
	$formx = $form;
}

if ($_POST['34']){
	// Check comment (comment)
	$form['ed'] = trim($_POST['ed']);
	$form['pid'] = trim($_POST['pid']);

	$form['comment'] = trim($_POST['comment']);
	if ($form['comment'] == ''){
		form_fail("Please enter comment", 'comment');
	}
	$form['rating'] = trim($_POST['rating']);
	if ($form['rating'] == ''){
		form_fail("Please enter rating", 'rating');
	}
	if ($formerr) echo '<br>';
}

if (($_POST['34'] || $_POST['xdelete']) && !$formerr){
	while ($i = each($form)){
		$formx[$i[0]] = addslashes($i[1]);
	}
	$formx['ed'] = trim($_POST['ed']);
	$formx['pid'] = trim($_POST['pid']);
	if ($_add){
		$i = mysql_query("INSERT INTO epay_reviews(comment,mark) VALUES('{$formx['comment']}','{$formx['rating']}')");
	}else{
		if ($_POST['xdelete']){
			$i = mysql_query("DELETE FROM epay_reviews WHERE pid='{$formx['pid']}' AND user='{$formx['ed']}'") or die( mysql_error() );
		}else{
			$sql = "UPDATE epay_reviews SET comment='{$formx['comment']}',mark='{$formx['rating']}' WHERE  pid='{$formx['pid']}' AND user='{$formx['ed']}'";
			$i = mysql_query("UPDATE epay_reviews SET comment='{$formx['comment']}',mark='{$formx['rating']}' WHERE  pid='{$formx['pid']}' AND user='{$formx['ed']}'") or die( mysql_error() );
		}
	}
	if (!$i) $formerr = 'query';
}else{
?>
<div align=center>
<table class=design cellspacing=0>
<form method=post name=form1>
<input type=hidden name=xdelete value=0>

<!-- Row 1 -->
<tr>
	<th colspan=2 class=headline>member review post
</tr>

<!-- Inserted row -->
<tr>
	<td>Posted by:
	<td><a href="right.php?a=user&id=<?=($opposite == $wm ? $form['wm'] : $form['pr'])?>&<?=$id?>"><?=pruser2($opposite == $wm ? $form['wm'] : $form['pr'])?></a>
</tr>
<tr>
	<td><span<?=($formerr['rating'] ? ' class=error' : '')?>>rating:</span>
	<td><input type="text" name="rating" value="<?=$form['mark']?>">
</tr>
<!-- Row 2 -->
<tr>
	<td><span<?=($formerr['comment'] ? ' class=error' : '')?>>comment:</span>
	<td><textarea name="comment" cols=60 rows=10><?=htmlspecialchars($form['comment'])?></textarea>
</tr>

<!-- Row 3 -->
<tr>
	<th colspan=2 class=submit>
		<input type=button class=button value="Delete this review" onClick="if (confirm('Delete this item?')) { form1.xdelete.value = '1'; form1.submit(); }">
		<input type=submit class=button name=34 value="Edit &gt;&gt;">
	</th>
</tr>
<input type=hidden name=pid value="<?=$_GET['id']?>">
<input type=hidden name=mbid value="<?=$_GET['id']?>">
<input type=hidden name=ed value="<?=$_GET['ed']?>">
<input type=hidden name=whatm value="<?=$what?>">
<input type=hidden name=suid value="<?=$suid?>">
<input type=hidden name=a value="<?=$action?>">
</form>
</table>
</div>
<?
	$formerr = 'form';
}
error_reporting($formrep);
?>
