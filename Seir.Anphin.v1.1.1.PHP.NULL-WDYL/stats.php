<?php

$templates='stats_page,';
$settings='latest_post_timestamp,';
include('./lib/config.php');

$limit=10;
$users1='';
$topics1='';
$topics2='';
$topics3='';
$days_since_setup=round($misc['setupdate']/86400);
$days_from_setup=round(time()/86400);
$days_running=$days_from_setup-$days_since_setup;
if ($days_running==0) $days_running=1;
if ($misc['numtopics']<1) $misc['numtopics']=1;
$output=getTemplate('stats_page');

// most active users
$users_query=$dbr->query("SELECT userid,displayname,post_count FROM arc_user ORDER BY post_count DESC LIMIT 0,$limit");
while ($users=$dbr->getarray($users_query)) {
	$users1.="<a href=\"user.php?action=profile&id=$users[userid]\">".stripslashes($users['displayname']).'</a> ('.number_format($users['post_count']).')<br>';
}

// most replied topics
$topics_query=$dbr->query("SELECT topicid,ttitle,treplies FROM arc_topic ORDER BY treplies DESC LIMIT 0,$limit");
while ($topics=$dbr->getarray($topics_query)) {
	$topics1.="<a href=\"post.php?action=readcomments&ident=topic&id=$topics[topicid]\">".format_text($topics['ttitle']).'</a> ('.number_format($topics['treplies']).')<br>';
}

// most viewed topics
$topics_query=$dbr->query("SELECT topicid,ttitle,topichits FROM arc_topic ORDER BY topichits DESC LIMIT 0,$limit");
while ($topics=$dbr->getarray($topics_query)) {
	$topics2.="<a href=\"post.php?action=readcomments&ident=topic&id=$topics[topicid]\">".format_text($topics['ttitle']).'</a> ('.number_format($topics['topichits']).')<br>';
}

// most recent topics
$topics_query=$dbr->query("SELECT topicid,ttitle,topicdate FROM arc_topic ORDER BY topicdate DESC LIMIT 0,$limit");
while ($topics=$dbr->getarray($topics_query)) {
	$topics3.="<a href=\"post.php?action=readcomments&ident=topic&id=$topics[topicid]\">".format_text($topics['ttitle']).'</a> ('.formdate($topics['topicdate'], getSetting('latest_post_timestamp')).')<br>';
}

$numforums=$dbr->result("SELECT COUNT(forumid) FROM arc_forum WHERE isforum=1");
$postspermember=round($misc['numposts'] / $misc['numusers'], 2);
$postspertopic=round($misc['numposts'] / $misc['numtopics'], 2);
$postsperforum=round($misc['numposts'] / $numforums, 2);
$postsperday=round($misc['numposts'] / $days_running, 2);
$membersperday=round($misc['numusers'] / $days_running, 2);
$numpolls=number_format($dbr->result("SELECT COUNT(pollid) FROM arc_poll"));
$numforums=number_format($numforums);

doHeader("$sitename: Statistics");

$output=str_replace('<numusers>', number_format($misc['numusers']), $output);
$output=str_replace('<numforums>', $numforums, $output);
$output=str_replace('<numtopics>', number_format($misc['numtopics']), $output);
$output=str_replace('<numpolls>', $numpolls, $output);
$output=str_replace('<numposts>', number_format($misc['numposts']), $output);
$output=str_replace('<days_running>', number_format($days_running), $output);
$output=str_replace('<postspermember>', $postspermember, $output);
$output=str_replace('<postspertopic>', $postspertopic, $output);
$output=str_replace('<postsperforum>', $postsperforum, $output);
$output=str_replace('<postsperday>', $postsperday, $output);
$output=str_replace('<membersperday>', $membersperday, $output);
$output=str_replace('<users1>', $users1, $output);
$output=str_replace('<topics1>', $topics1, $output);
$output=str_replace('<topics2>', $topics2, $output);
$output=str_replace('<topics3>', $topics3, $output);
$output=str_replace('<limit>', $limit, $output);

echo $output;

footer();

?>