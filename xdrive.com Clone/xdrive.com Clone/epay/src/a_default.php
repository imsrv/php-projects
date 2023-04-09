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

$qr = mysql_query("SELECT pr_subcat,title,COUNT(username) FROM epay_users,epay_pr_subcats WHERE type='pr' AND pr_subcat=epay_pr_subcats.id GROUP BY pr_subcat");
while ($r = mysql_fetch_row($qr))
  $stat[(int)$r[0]] = array($r[1], $r[2]);
$r = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_users WHERE type='wm'"));
$stat['wm'] = (int)$r[0];
$r = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_projects WHERE type='Open'"));
$stat['proj'] = (int)$r[0];
    while (list($k,$v) = each($stat))
      if (is_int($k))
        $stat['pr'] .= "<b>$v[1]</b> ".htmlspecialchars($v[0])."s, ";

list($cnt1) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_visitors WHERE username IS NULL"));
list($cnt2) = mysql_fetch_row(mysql_query("SELECT COUNT(a.username) FROM epay_visitors a,epay_users b WHERE a.username=b.username AND type='wm'"));
list($cnt3) = mysql_fetch_row(mysql_query("SELECT COUNT(a.username) FROM epay_visitors a,epay_users b WHERE a.username=b.username AND type='pr'"));
list($cnt4) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_projects WHERE type='Closed' AND programmer>0"));

$x = mysql_query("SELECT id FROM epay_quotes");
srand((double)microtime()*1000000);
$n = rand(1, mysql_num_rows($x));
for ($i = 0; $i < $n; $i++) $r = mysql_fetch_row($x);

$qr = mysql_fetch_object(mysql_query("SELECT comment,submit_date,username,type FROM epay_quotes,epay_users WHERE epay_users.id=submit_by AND epay_quotes.id={$r[0]}"));
if ($qr->comment) 
$quote = "
<DIV align=center>
<BR>
<TABLE CLASS=DESIGN WIDTH=100% CELLPADDING=2 CELLSPACING=0 BORDER=0>
<TR><TH><DIV ALIGN=CENTER>What they say about $sitename</DIV></TH></TR>
<TR><TD ALIGN=CENTER><I><B>".htmlspecialchars($qr->comment)."</I></B><BR>
	<SMALL>
  	Posted by $qr->username ({$GLOBALS[$qr->type]})<BR>
  	(<a href=index.php?a=quotes&brand=$brand&$id>See all quotes</a>)
	</SMALL></TD></TR>
</TABLE>
</DIV>
";

// Categories
ob_start();
if ($display_categories)
{
// $catgroups
// 
  echo "<div align=center><table class=design cellspacing=0>",
       "<tr><th colspan=5><b>Open Projects by Category</b></th></tr><tr>",
       "<td valign=top><table class=empty cellspacing=2 width=200>";
	if ($catgroups){
		makeCats($sortcats,$catnums,$catcols);
	}else{
  		makeAreas('',$sortcats,$catnums,$catcols);
  	}
  echo "</table></table></div><br>";
}
$cat = ob_get_contents();
ob_end_clean(); 

	function makeCats($o='',$mynum = '',$cols = 2){
		if ($o){
			$order = "ORDER BY title";
		}else{
			$order = "ORDER BY id";
		}
		$sql = "SELECT * FROM epay_header_list $order";
		$qr1 = mysql_query($sql);
		$qr2 = mysql_query($sql);
		$num = 0;
		for ($i = mysql_num_rows($qr2) - 1; $i >= 0; $i--){
			if (mysql_result($qr2, $i, 'title')){
				$num++;
			}
		}
		$middle = (int)($num / $cols);
		$cur = 0;
		$cnum = 1;
		while ($r1 = mysql_fetch_object($qr1)){
			if (!$r1->title) continue;
			$bit = (1 << ($r1->id));
			$cur++;
			echo "<tr><td valign=top><a href=index.php?a=myareas&area=$r1->id&brand=$brand&$id><b>$r1->title</b></a><br>\n";
			echo "<table class=empty cellspacing=0><tr><td>";
			makeAreas($r1->id,$o,$mynum,$cols);
			echo "</td></tr></table>";
			echo "</td></tr>\n";
			if($cnum == $middle){
				if($cols > 1){
					if($cur != $num){
						echo "</table><td valign=top><table class=empty cellspacing=2 width=200>";
					}
				}
				$cnum = 1;
			}else{
				$cnum++;
			}
		}
		return 1;
	}

	function makeAreas($pid = '',$o='',$mynum = '',$cols = 2){
		if($pid){
			$where = "WHERE parent='$pid'";
			$spacer = "&nbsp;&nbsp;";
			$font = "<font size=1>";
		}else{
			$where = "";
			$mynum = "";
		}
		if($o){
			$order = "ORDER BY title";
		}else{
			$order = "ORDER BY id";
		}
		$sql = "SELECT * FROM epay_area_list";
		if ($where){
			$sql .= " $where";
		}
		if ($order){
			$sql .= " $order";
		}
		$qr1 = mysql_query($sql);
		$qr2 = mysql_query($sql);
		$num = 0;
		$total = mysql_num_rows($qr2);
		for ($i = mysql_num_rows($qr2) - 1; $i >= 0; $i--){
			if (mysql_result($qr2, $i, 'title')){
				$num++;
			}
		}
		$middle = (int)($num / $cols);
		$cur = 1;
		$cnum = 0;
		while ($r1 = mysql_fetch_object($qr1)){
			if (!$r1->title) continue;
			$bit = (1 << ($r1->id));
			$cur++;
			list($cnt) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_projects WHERE type='Open' AND (area&$bit)>0"));
			if ($pid){
				if ($cur == 1){
					echo $spacer;
				}
				echo "<a href=index.php?a=projects&cat=$r1->id&brand=$brand&$id>".$font."$r1->title</a>";
				if ( ($cur != $num) && ($cur != $mynum) ){
					echo " &middot; ";
				}
			}else{
				echo "<tr><td><a href=index.php?a=projects&cat=$r1->id&brand=$brand&$id>$r1->title</a><td>$cnt\n";
			}
			if (!$pid){
				if($cnum == $middle){
					if($cols > 1){
						if($cur != $num){
							echo "</table><td valign=top><table class=empty cellspacing=2 width=200>";
						}
					}
					$cnum = 0;
				}else{
					$cnum++;
				}
			}
			if ($mynum){
				if ($cur == $mynum){
					return 1;
				}
			}
		}
		return 1;
	}

 
$tpl = join("", file("src/default.htm"));
$vars = array(
  "sitename" => $sitename,
  //Cobrand
  "brand" => "brand=$brand",
  //End Cobrand
  "id" => $id,
  "wm" => $wm,
  "pr" => $pr,
  "stat_pr" => $stat['pr'],
  "stat_wm" => "<b>{$stat['wm']}</b> {$wm}s, ",
  "stat_proj" => "{$stat['proj']}",
  "visitor" => $cnt1,
  "visitor_wm" => $cnt2,
  "visitor_pr" => $cnt3,
  "visitor_total" => $cnt1+$cnt2+$cnt3,
  "random_quote" => $quote,
);
while ($a = each($vars))
  $tpl = str_replace("[[{$a[0]}]]", $a[1], $tpl);
echo $tpl;
?>
