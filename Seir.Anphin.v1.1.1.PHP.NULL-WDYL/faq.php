<?php

$templates='faqgroupheader,faqgrouprow,faqgroupfooter,faqheader,faqrow,faqfooter,faqtoolbar,faq,faqgroup,faq2,';

include('./lib/config.php');

if ($action=='news' && empty($HTTP_GET_VARS['id']))
	$action='list';
elseif ($action=='news' && isset($HTTP_GET_VARS['id']))
	$action='view';

doHeader("$sitename Frequently Asked Questions");
echo $faqtoolbar;

if ($action=='list') {
	$f=$dbr->query("SELECT * FROM arc_faqgroup WHERE faqgrouporder <> 0 ORDER BY faqgrouporder,faqgroupname");
	while ($fgroups=$dbr->getarray($f)) {
		$faqg_html=getTemplate('faqgroup');
		$grouprow=str_replace('<faqgroupname>', stripslashes($fgroups['faqgroupname']), getTemplate('faqgrouprow'));
		echo str_replace('<faqgrouprow>', $grouprow, $faqg_html);
		$faq=$dbr->query("SELECT faqid,faqq,faqhits FROM arc_faq WHERE faqgroup=$fgroups[faqgroupid] ORDER BY faqq");
		$frow=getTemplate('faqrow');
		$faq_html=getTemplate('faq2');
		$tfaqrow='';
		while($faqs=@$dbr->getarray($faq)) {
			$afaqrow=str_replace('<faqq>', stripslashes($faqs['faqq']), $frow);
			$afaqrow=str_replace('<faqhits>', number_format($faqs['faqhits']), $afaqrow);
			$afaqrow=str_replace('<faqid>', $faqs['faqid'], $afaqrow);
			$tfaqrow.=$afaqrow;
		}
		echo str_replace('<faqrow>', $tfaqrow, $faq_html);
	}
}

if ($action=='view') {
	if (isset($HTTP_GET_VARS['id'])) {
		$f=$dbr->query("SELECT faqq,faqa,faqhits FROM arc_faq WHERE faqid=$HTTP_GET_VARS[id]");
		$g=$dbr->getarray($f);
		$faq=getTemplate('faq');
		$fviews=$g['faqhits']+1;
		$dbr->query("UPDATE arc_faq SET faqhits=$fviews WHERE faqid=$HTTP_GET_VARS[id]");
		$faq=str_replace('<faqq>', stripslashes($g['faqq']), $faq);
		$faq=str_replace('<faqa>', stripslashes(nl2br($g['faqa'])), $faq);
		echo str_replace('<faqhits>', number_format($fviews), $faq);
	}
}

footer();

?>