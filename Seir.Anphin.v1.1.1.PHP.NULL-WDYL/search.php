<?php

$templates='findpostlist,findpostlistrow,';
$settings='search_limit,post_timestamp,find_truncatewords,';
$wordbits='text_truncated,search_listmsg,';

include('./lib/config.php');

if (isset($searchtable)) {
	switch ($searchtable) {
		case 1:
			$text='postcontent';
			$id='postid';
			$table='arc_post';
			$authorid='postuserid';
			$date='postdate';
			$extra='arc_post.parentid,arc_post.parentident,';
			break;
		case 2:
			$text='pcontent';
			$id='pagebitid';
			$table='arc_pagebit';
			$authorid='puserid';
			$date='pdate';
			$extra='arc_pagebit.page,';
			break;
	}
}

if ($action=='news')
	$action='search';

switch ($action) {
	case 'search':
		doHeader("$sitename: Search");
		require('./adminfunctions.php');
		if ($isadmin==1 && isset($HTTP_GET_VARS['update'])) {
			$inputs[]=formtop('search.php?action=updatewords');
		} else {
			$inputs[]=formtop('search.php?action=dosearch');
		}
		$inputs[]=inputform('text', 'Search Keyword', 'keywords');
		$inputs[]=inputform('searchtables', 'Search Where', 'searchtable');
		$inputs[]=inputform('submitreset', 'Begin Search', 'Reset Parameters');
		doinputs();
		formbottom();
		break;

	case 'dosearch':
		doHeader("$sitename: Searching for $keywords");

		$query_trim=trim($keywords);
		$words=explode(' ', addslashes(strtolower($query_trim)));
		$regular_expression="" .implode(",", $words)."";

		$keywordarray=split(",",$regular_expression);
		$arrsize=sizeof($keywordarray);
		$limit=getSetting('search_limit');

		for($i=0;$i<$arrsize;$i++) {
			$search="SELECT count(arc_searchwords.word) as words,
					  arc_searchwords.wid,
					  $table.$text,
					  $table.$id,
					  $table.$authorid,
					  $table.$date,
					  $extra
					  arc_user.displayname
					 FROM arc_searchwords,
					  $table,
					  arc_user
					 WHERE $table.$id=arc_searchwords.wid
					   AND arc_user.userid=$table.$authorid
					   AND $table.$text LIKE '%$keywordarray[$i]%'
					 GROUP BY arc_searchwords.wid
					 ORDER BY words DESC
					 LIMIT 0,$limit";

			$getresults=$dbr->query($search);
			$resultsnumber=mysql_num_rows($getresults);

		}
		$listmsg=str_replace('<keywords>', $keywords, getwordbit('search_listmsg'));
		$findpostlist=str_replace('<findpostlist>', $listmsg, getTemplate('findpostlist'));
		$resulthtml='';
		$row=getTemplate('findpostlistrow');

		function searchoutput($getresults,$resultsnumber) {
			GLOBAL $text,$id,$authorid,$date,$row,$resulthtml,$searchtable;
			if($resultsnumber==0) {
	    		showmsg("Your search did not return any results.", 1);
			} elseif ($resultsnumber>0) {
				for($count=0; $count<$resultsnumber; $count++) {
					$usersid=mysql_result($getresults,$count,$authorid);
					$usersname=mysql_result($getresults,$count,'displayname');
					$datestamp=mysql_result($getresults,$count,$date);
					$body=mysql_result($getresults,$count,$text);
					$qid=mysql_result($getresults,$count,$id);
					$cnote=$count+1;
					$prow=str_replace('<postuserid>', $usersid, $row);
					if ($searchtable==1) {
						$parentid=mysql_result($getresults,$count,'parentid');
						$parentident=mysql_result($getresults,$count,'parentident');
						$prow=str_replace('<msg>', "<a href=\"post.php?action=readcomments&ident=$parentident&id=$parentid#id\">View Post in Context</a>", $prow);
					} elseif($searchtable==2) {
						$pagename=mysql_result($getresults,$count,'page');
						$prow=str_replace('<msg>', "<a href=\"index.php?action=$pagename\">View Page</a>", $prow);
					}
					$prow=str_replace('<postcontent>', truncatewords(htmlspecialchars(unfilter(stripslashes($body))), getSetting('find_truncatewords')), $prow);
					$prow=str_replace('<postdate>', formdate($datestamp, getSetting('post_timestamp')), $prow);
					$prow=str_replace('<displayname>', htmlspecialchars(stripslashes($usersname)), $prow);
					$prow=altbgcolor($prow);
					$resulthtml.=$prow;
				}
			}
		}
		searchoutput($getresults,$resultsnumber);
		$findpostlist=str_replace('<totalposts>', number_format($resultsnumber), $findpostlist);
		echo str_replace('<findpostlistrows>', $resulthtml, $findpostlist);

		break;

	case 'updatewords':
		doHeader("$sitename: Performing Search");

		$result=$dbr->query("SELECT $text,$id FROM $table");
		$number=$dbr->numrows($result);
		$j=0;
		while($j<$number) {
			$body=mysql_result($result,$j, $text);

			$qid=mysql_result($result,$j, $id);

		    $noise_words=file('lib/words.txt');
		    $filtered=$body;

		    $filtered=ereg_replace("^"," ",$filtered);

		    for ($i=0; $i<count($noise_words); $i++) {
		        $filterword=trim($noise_words[$i]);
		        $filtered=eregi_replace(" $filterword "," ",$filtered);
		    }

		    $filtered=trim($filtered);
		    $filtered=addslashes($filtered);
		    $querywords=ereg_replace(",","",$filtered);
		    $querywords=ereg_replace(" ",",",$querywords);
		    $querywords=ereg_replace("\?","",$querywords);
		    $querywords=ereg_replace("\(","",$querywords);
		    $querywords=ereg_replace("\)","",$querywords);
		    $querywords=ereg_replace("\.","",$querywords);
		    $querywords=str_replace(",","','",$querywords);
		    $querywords=ereg_replace("^","'",$querywords);
		    $querywords=ereg_replace("$","'",$querywords);
		    $eachword=explode(",", $querywords);
		    $eachword=array_unique($eachword);

			foreach ($eachword as $val) if (trim($val)!="" && $val!=" ") $dbr->query("REPLACE arc_searchwords VALUES($val,$qid, '$table')");
		    $j++;
		}
		break;
}

footer();
?>