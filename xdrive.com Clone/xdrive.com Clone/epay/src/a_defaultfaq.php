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
	function getCatTitle($cat){
		$qr1 = mysql_query("SELECT * FROM epay_faq_cat_list WHERE id=$cat ORDER BY id");
		$r1 = mysql_fetch_object($qr1);
		return $r1->title;
	}

	function FAQSearch($srch){
		ob_start();
		$query = "SELECT COUNT(id) AS total FROM epay_faq_list WHERE (question REGEXP '$srch') OR (answer REGEXP '$srch')";
		$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
		extract( mysql_fetch_array($result) );
		$query = "SELECT * FROM epay_faq_list WHERE (question REGEXP '$srch') OR (answer REGEXP '$srch') ORDER BY cat DESC";
		$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
		if ($total > 1){
			$dd = "results";
		}else{
			$dd = "result";
		}
?>
		<br>
		<table border=0 cellpadding=0 cellspacing=0 width="96%" align="center">
		<tr valign="top">
			<td valign="top">
<?	
		while ( $r1 = mysql_fetch_object($result) ){
			if (!$r1->question) continue;
?>
			<a name="<?=$r1->id?>"></a>
			<table class="design" border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td><b><?=$r1->question?></b></td>
				<td align="right">&nbsp;</td>
			</tr>
			<tr>
				<td colspan=2>
					<span class=small>
						<?=$r1->answer?>
					</div>
				</td>
			</tr>
			</table>
			<br><br>
			
<?		
			$mycnt++;
		}
?>
			</td>
		</tr>
		</table>
		<?=$total?> <?=$dd?> results found<br>
<?
		$searchresults = ob_get_contents();
		ob_end_clean(); 
		return $searchresults;
	}

	if($_REQUEST["farea"]){
		ob_start();
?>
		<br>
		<table border=0 cellpadding=0 cellspacing=0 width="96%" align="center">
		<tr valign="top">
			<td valign="top">
<?
		$qr1 = mysql_query("SELECT * FROM epay_faq_list WHERE cat='".$_REQUEST["farea"]."' ORDER BY cat");
		$qr2 = mysql_query("SELECT * FROM epay_faq_list WHERE cat='".$_REQUEST["farea"]."' ORDER BY cat");
		$num = 0;
		for ($i = mysql_num_rows($qr2) - 1; $i >= 0; $i--){
			if (mysql_result($qr2, $i, 'question')){
				$num++;
			}
		}
		$middle = (int)($num / 3);
		$mr = 1;
		$mycnt = 0;
		$abc = 0;
		while ($r1 = mysql_fetch_object($qr1)){
			if (!$r1->question) continue;
?>
			<a href="#<?=$r1->id?>&brand=$brand" class="BrowseLink">&raquo;&nbsp;<?=$r1->question?></a><br>
<?		
		$mycnt++;
	}
?>
			</td>
		</tr>
		</table>
		<br>
		<table border=0 cellpadding=0 cellspacing=0 width="96%" align="center">
		<tr valign="top">
			<td valign="top">
<?
		$qr1 = mysql_query("SELECT * FROM epay_faq_list WHERE cat='".$_REQUEST["farea"]."' ORDER BY cat");
		$qr2 = mysql_query("SELECT * FROM epay_faq_list WHERE cat='".$_REQUEST["farea"]."' ORDER BY cat");
		$num = 0;
		for ($i = mysql_num_rows($qr2) - 1; $i >= 0; $i--){
			if (mysql_result($qr2, $i, 'question')){
				$num++;
			}
		}
		$middle = (int)($num / 3);
		$mr = 1;
		$mycnt = 0;
		$abc = 0;
		while ($r1 = mysql_fetch_object($qr1)){
			if (!$r1->question) continue;
?>
			<a name="<?=$r1->id?>"></a>
			<table class="design" border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td><b><?=$r1->question?></b></td>
				<td align="right"><a href="#top"><span class=small>View all Questions</a></td>
			</tr>
			<tr>
				<td colspan=2>
					<span class=small>
						<?=$r1->answer?>
					</div>
				</td>
			</tr>
			</table>
			<br><br>
<?		
			$mycnt++;
		}
?>
			</td>
		</tr>
		</table>
<?
		$faqs = ob_get_contents();
		ob_end_clean(); 
	}else{
		ob_start();
?>
		<table border=0 cellpadding=0 cellspacing=0 width="96%" align="center">
		<tr valign="top">
			<td width="4%">&nbsp;</td>
			<td width="48%" valign="top">
<?
		$qr1 = mysql_query("SELECT * FROM epay_faq_cat_list ORDER BY id") or die( mysql_error() );
		$qr2 = mysql_query("SELECT * FROM epay_faq_cat_list ORDER BY id");
		$num = 0;
		for ($i = mysql_num_rows($qr2) - 1; $i >= 0; $i--){
			if (mysql_result($qr2, $i, 'title')){
				$num++;
			}
		}
		$middle = (int)($num / 2);
		$mr = 1;
		while ($r1 = mysql_fetch_object($qr1)){
			if (!$r1->title) continue;
			list($cnt) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_faq_list WHERE cat=".$r1->id));
?>
			<a href="faq.php?farea=<?=$r1->id?>&brand=$brand" class="BrowseLink">&raquo;&nbsp;<?=$r1->title?></a><br>
<?
		}
?>
			</td>
		</tr>
		</table>
<?
		$cats = ob_get_contents();
		ob_end_clean(); 
	}
	ob_start();

	if($_REQUEST["farea"]){
		$catname = getCatTitle($_REQUEST["farea"]);
?>
		<table class="empty" border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan=2>
				<span class=small>
					<a href="faq.php?<?=$id?>brand=<?$brand?>" class="small">main</a>
					&nbsp;/&nbsp;
					<a href="faq.php?farea=<?=$_REQUEST["farea"]?>&id=<?=$id?>brand=<?$brand?>" class="small"><?=strtolower($catname);?></a>
				</span>
			</td>
		</tr>
		</table>
		<br><br>
<?	}	?>
<?
	echo "<br><br>";
	$breadcrumb = ob_get_contents();
	ob_end_clean(); 
	if (!$_REQUEST["farea"]){$faqs = $cats;}
	if ($_REQUEST["srch"]){
		$faqs = FAQSearch($_REQUEST["srch"]);
	}
	$tpl = join("", file("src/defaultfaq.htm"));
	$vars = array(
		"sitename" => $sitename,
   		//Cobrand
  		"brand" => "brand=$brand",
  		//End Cobrand
		"id" => $id,
		"wm" => $wm,
		"pr" => $pr,
		"breadcrumb" => $breadcrumb,
		"faqs" => $faqs,
		"cats" => $cats,
	);
	while ($a = each($vars)){
		$tpl = str_replace("[[{$a[0]}]]", $a[1], $tpl);
	}
	echo $tpl;
?>

