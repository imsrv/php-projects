<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE username='".addslashes($_GET['id'])."'")); 
if ($r->type == 'sys') exit;

if($_POST['mbid'])$_GET['mbid'] = $_POST['mbid'];
if (!$_GET['mbid']){
	$x = mysql_fetch_object(mysql_query("SELECT * FROM epay_reviews WHERE user='".$_GET['ed']."' LIMIT 1"));
	if ($x){
		print_reviews($_GET['ed']);
	}
}else{
	$x = mysql_fetch_object(mysql_query("SELECT * FROM epay_reviews WHERE user='".$_GET['ed']."' AND pid='".$_GET['mbid']."' LIMIT 1"));
	if ($x){
		$_GET['id'] = $x->pid;
		include("admin/gm_rev.php");
		if (!$formerr){
			$url = $_SERVER['PHP_SELF']."?a=reviews&ed=".$_GET['ed']."&$id";
			echo "Review moderated. Redirecting to the next one...",
				"<script language=JavaScript>document.location = '$url';</script>";
		}
	}
}
function print_reviews($aid){
	global $r, $cat_title, $currency,$id,$wm,$pr;
	$r = mysql_fetch_object(mysql_query("SELECT type,id,username FROM epay_users WHERE id=".$aid));
  	$opposite = ($r->type == 'wm' ? $pr : $wm);
	echo "<TABLE class=design cellspacing=0 width=100%>",
		"<TR><TH>$opposite</TH><TH>Rating</TH><TH width=30%>Comments</TH><TH>Project Name</TH><TH>Project Date</TH><TH> </TH></TR>";
	$r = mysql_query("SELECT openedby AS wm,programmer AS pr,epay_reviews.pid,id,name,mark,epay_reviews.comment,dateposted FROM epay_reviews,epay_projects WHERE id=pid AND user=$aid ORDER BY dateposted DESC");
	while ($a = mysql_fetch_object($r)){
?>
<TR><TD class=row$i><?=pruser2($opposite == $wm ? $a->wm : $a->pr)?></TD>
	<TD class=row$i><?=$a->mark?></TD>
	<TD class=row$i><?=($a->comment ? "<span class=small>".htmlspecialchars($a->comment)."</span>" : "")?></TD>
	<TD class=row$i><?=prproject2($a->id, $a->name)?></TD>
	<TD class=row$i><?=prdate($a->dateposted)?></TD>
	<TD class=row$i>
		<a href=right.php?a=reviews&mbid=<?=$a->pid?>&ed=<?=$aid?>&<?=$id?>>moderate</a>
	</TD>
<?
		$i = 3 - $i;
	}
	echo "</TABLE>";
}
?>