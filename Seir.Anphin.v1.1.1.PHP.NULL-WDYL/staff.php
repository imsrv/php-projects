<?php

$templates='shrinepage,shrinepagerow,staffmenu,';
$settings='pagebit_limit,shrinepage_limit,shrinepagelistorder,shrine_timestamp,';
$wordbits='shrine_submit,shrine_reset,shrine_change,shrine_key,shrine_title,shrine_summary,shrine_header,shrine_footer,shrine_selected,';
$wordbits.='shrine_pagebit,shrine_accesslvl,newpagebittitle,newpagebitcontent,newpagebitaction,newpagebitorder,newpagebitnl2br,';
$wordbits.='shrine_pagesaved,shrine_pageadded,';

include('./lib/config.php');

if ($action!='sindex')
	$header=str_replace('<usercpmenu>', getTemplate('staffmenu'), $header);

function getshrinekey()
{
	GLOBAL $userid,$loggedin,$dbr;

	if ($loggedin==1) {
		return $dbr->result("SELECT shrinekey FROM arc_shrine WHERE suserid=$userid AND active=1 LIMIT 0,1");
	} else {
		return '';
	}
}

doHeader("$sitename: Shrines $actn");

if ($action=='savepagebit') {
	if ($loggedin==1) {
		$skey=getshrinekey();
		$tskey=$dbr->result("SELECT shrinekey FROM arc_pagebit WHERE pagebitid=$pagebitid");

		if ($skey==$tskey) {
			$dbr->query("UPDATE arc_pagebit SET
					ptitle='" .dbPrep($ptitle). "',
					pcontent='" .dbPrep($pcontent). "',
					page='" .dbPrep($pagename). "',
					convertnewline=$convertnewline,
					porder=" .validate_number($porder). ' WHERE pagebitid=' .validate_number($pagebitid));
			$dbr->query("UPDATE arc_shrine SET lastmodified=" .time(). " WHERE shrinekey='$skey'");
			updatesearchindex($pcontent, $pagebitid, 'arc_pagebit', 1);
			showmsg(stripslashes(str_replace('<ptitle>', $ptitle, getwordbit('shrine_pagesaved'))), 1);
			$action="modify";
			$edit="pagebit";
			$id=$pagebitid;
		}
	}
}

if ($action=='modify') {
	$skey=getshrinekey();

	if ($skey=='') {
		showmsg('shrine_notset');
		echo $footer;
		exit();
	}

	if (isset($deleteshrine)) {
		deleterows('Shrine', $deleteshrine);
		$action='listpagebits';
		unset($edit);
	}

	if (isset($deletepagebit)) {
		deleterows('Pagebit', $deletepagebit);
		footer(1);
	}

	if (isset($edit) && isset($id)) {
		require("adminfunctions.php");

		if ($edit=='pagebit') {
			$thequery=$dbr->query("SELECT ptitle,pcontent,porder,page,convertnewline FROM arc_pagebit WHERE pagebitid=$id");
			$pagebitinfo=$dbr->getarray($thequery);

			$inputs[]=formtop("staff.php?action=savepagebit");
			$inputs[]=inputform('text', getwordbit('newpagebittitle'), "ptitle", htmlspecialchars(stripslashes($pagebitinfo['ptitle'])));
			$inputs[]=inputform('textarea', getwordbit('newpagebitcontent'), "pcontent", htmlspecialchars(stripslashes($pagebitinfo['pcontent'])));
			$inputs[]=inputform('text', getwordbit('newpagebitorder'), "porder", $pagebitinfo['porder'], 4, 4);
			$inputs[]=inputform('text', getwordbit('newpagebitaction'), 'pagename', $pagebitinfo['page'], 25, 20);
			$inputs[]=inputform('yesno', getwordbit('newpagebitnl2br'), 'convertnewline', $pagebitinfo['convertnewline']);
			$inputs[]=inputform('hidden', '', 'pagebitid', $id);
			$inputs[]=inputform('submitreset', getwordbit('shrine_submit'), getwordbit('shrine_reset'));
			doinputs();
			formbottom();

		}
	} else {
		showmsg('bad_link');
	}
}

if ($action=='new_pagebit') {
	$skey=getshrinekey();
	if ($skey!='') {
		require('adminfunctions.php');
		$inputs[]=formtop('staff.php?action=buildpagebit');
		$inputs[]=inputform('text', getwordbit('newpagebittitle'), 'ptitle', '');
		$inputs[]=inputform('textarea', getwordbit('newpagebitcontent'), 'pcontent', '');
		$inputs[]=inputform('text', getwordbit('newpagebitaction'), 'npagename', '', 25, 20);
		$inputs[]=inputform('text', getwordbit('newpagebitorder'), 'porder', 1, 4, 4);
		$inputs[]=inputform('yesno', getwordbit('newpagebitnl2br'), 'convertnewline', 1);
		doinputs();
		getaddbitsubmit('pagebit');
	} else {
		showmsg('shrine_notset');
	}
}

if ($action=='buildpagebit') {
	if ($loggedin==1) {
		$shrinekey=getshrinekey();
		if (isset($addpagebit) && $shrinekey!='') {
			if ($porder=='')
				$porder=1;

			$dbr->query("INSERT INTO arc_pagebit SET
					ptitle='" .addslashes($ptitle). "',
					pcontent='" .addslashes($pcontent). "',
					page='" .addslashes(strtolower($npagename)). "',
					porder=$porder,
					puserid=$userid,
					shrinekey='$shrinekey',
					convertnewline=$convertnewline,
					pdate=" .time());
			$dbr->query("UPDATE arc_shrine SET lastmodified=" .time(). " WHERE shrinekey='$shrinekey'");
			updatesearchindex($pcontent, mysql_insert_id(), 'arc_pagebit');
			$pa=str_replace('<pagebit>', stripslashes($ptitle), getwordbit('shrine_pageadded'));
			showmsg($pa, 1);
		} else {
			showmsg('shrine_notset');
		}
	}
}

if ($action=='save') {
	if ($loggedin==1) {
		$shrineowner=$dbr->result("SELECT suserid FROM arc_shrine WHERE shrineid=" .validate_number($shrineid));

		if ($shrineowner==$userid) {

			$suserlvl=$dbr->result("SELECT level FROM arc_user WHERE userid=$userid");
			if ($saccesslvl>$suserlvl) {
				showmsg('shrine_accesstoohi');
				echo $footer;
				exit();
			}
			$dbr->query("UPDATE arc_shrine SET
					 stitle='$stitle',
					 summary='".insert_text($summary)."',
					 header='".insert_text($sheader)."',
					 footer='".insert_text($sfooter)."',
					 pagebit='".insert_text($spagebit)."',
					 lastmodified=" .time(). ",
					 saccesslvl=$saccesslvl WHERE shrineid=$shrineid");
			showmsg('shrine_saved');
			$action='edit_shrine';
		} else {
			showmsg('shrine_noaccess');
		}
	}
}

if ($action=='edit_shrine') {
	if ($loggedin==1) {
		$numshrines=$dbr->result("SELECT COUNT(shrineid) AS nums FROM arc_shrine WHERE suserid=$userid AND active=1");
		if ($numshrines>0) {
			$edits=$dbr->query("SELECT shrineid,shrinekey,stitle,suserid,saccesslvl,summary,header,footer,pagebit FROM arc_shrine WHERE suserid=$userid AND active=1");
			while ($a=$dbr->getarray($edits)) {
				require("adminfunctions.php");
				$inputs[]=formtop('staff.php?action=save');
				$inputs[]=inputform('display', getwordbit('shrine_key'), 'shrinekey', $a['shrinekey'], 5, 3);
				$inputs[]=inputform('text', getwordbit('shrine_title'), 'stitle', $a['stitle']);
				$inputs[]=inputform('textarea', getwordbit('shrine_summary'), 'summary', stripslashes($a['summary']));
				$inputs[]=inputform('textarea', getwordbit('shrine_header'), 'sheader', stripslashes($a['header']));
				$inputs[]=inputform('textarea', getwordbit('shrine_footer'), 'sfooter', stripslashes($a['footer']));
				$inputs[]=inputform('textarea', getwordbit('shrine_pagebit'), 'spagebit', stripslashes($a['pagebit']));
				$inputs[]=inputform('text', getwordbit('shrine_accesslvl'), 'saccesslvl', $a['saccesslvl'], 15, 10);
				$inputs[]=inputform('hidden', '', 'shrineid', $a['shrineid']);
				$inputs[]=inputform('submitreset', getwordbit('shrine_submit'), getwordbit('shrine_reset'));
				doinputs();
				formbottom();
			}
		} else {
			showmsg('shrine_notset');
		}
	} else {
		showmsg('shrine_notloggedin');
	}
}


if ($action=='savechange') {
	if ($loggedin==1) {
		$dbr->query("UPDATE arc_shrine SET active=0 WHERE suserid=$userid");
		$dbr->query("UPDATE arc_shrine SET active=1 WHERE shrinekey='$shrinekey'");

		showmsg('shrine_selected');
		$action='change';
	} else {
		showmsg('shrine_noshrines');
	}
}

if ($action=='change') {

	if ($loggedin==1) {

		require('adminfunctions.php');

		$skey=getshrinekey();

		$inputs[]=formtop('staff.php?action=savechange');
		$inputs[]=inputform('shrines', getwordbit('shrine_change'), 'shrinekey', $skey, 5);
		$inputs[]=inputform('submitreset', getwordbit('shrine_submit'), getwordbit('shrine_reset'));
		doinputs();
		formbottom();
	} else {
		showmsg('shrine_notloggedin');
	}

}

if ($action=='listpagebits') {

	$skey=getshrinekey();

	if ($skey!='') {

		$numpages=$dbr->result("SELECT COUNT(pagebitid) AS nump FROM arc_pagebit WHERE shrinekey='$skey'");
		if ($numpages>0) {
			require("adminfunctions.php");
			getgenericlist("SELECT pagebitid,ptitle FROM arc_pagebit WHERE shrinekey='$skey' ORDER BY page", 'Pagebit', 1, 0, 1, "staff.php?action=modify");
		}
	} else {
		showmsg('shrine_noshrines');
	}
}

if ($action=='sindex') {
	$offset=getoffset();
	if (isset($HTTP_GET_VARS['sid'])) {
		$pages=$dbr->query("SELECT
								arc_pagebit.pagebitid,
								arc_pagebit.ptitle,
								arc_pagebit.page,
								arc_pagebit.pdate,
								arc_pagebit.puserid,
								arc_user.displayname
							FROM
								arc_pagebit,arc_user
							WHERE
								arc_pagebit.shrinekey='$HTTP_GET_VARS[sid]' AND
								arc_pagebit.porder <> 0 AND
								arc_user.userid=arc_pagebit.puserid
							ORDER BY " .getSetting('shrinepagelistorder'). "
							LIMIT $offset, " .getSetting('shrinepage_limit'));

		$numpages=$dbr->result("SELECT COUNT(pagebitid) as pid FROM arc_pagebit WHERE shrinekey='$HTTP_GET_VARS[sid]' AND porder <> 0");

		$shrine_html=str_replace('<shrinekey>', strtoupper($HTTP_GET_VARS['sid']), getTemplate('shrinepage'));
		$temp='';
		$sprow=getTemplate('shrinepagerow');
		while ($p=$dbr->getarray($pages)) {
			$row=str_replace('<pagebitid>', stripslashes($p['pagebitid']), $sprow);
			$row=str_replace('<ptitle>', stripslashes($p['ptitle']), $row);
			$row=str_replace('<page>', $p['page'], $row);
			$row=str_replace('<pdate>', formdate($p['pdate'], getSetting('shrine_timestamp')), $row);
			$row=str_replace('<userid>', $p['puserid'], $row);
			$row=str_replace('<displayname>', htmlspecialchars(stripslashes($p['displayname'])), $row);
			$temp.=$row;
		}
		$shrine_html=str_replace('<pagelinks>', pagelinks(getSetting('shrinepage_limit'), $numpages, $offset, 'Shrine Page'), $shrine_html);
		echo str_replace('<shrinepagerow>', $temp, $shrine_html);
	}
}

footer();

?>