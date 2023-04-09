<?php
require "../common/config.php";

// Removes HTML tags
$comment = strip_tags($comment);


// Makes URLs to hypertext
$comment = eregi_replace('^([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})','<a href=\"mailto:\\1\">\\1</a>', $comment);
$comment = eregi_replace('[[:space:]]([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',' <a href=\"mailto:\\1\">\\1</a>', $comment);
$comment = eregi_replace('((ftp://|http://|https://|file://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1" target="_blank">\\1</a>', $comment);
$comment = eregi_replace('(^www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="http://\\1" target="_blank">\\1</a>', $comment);
$comment = eregi_replace('([[:space:]])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="http://\\2" target="_blank">\\2</a>', $comment);


// Definition of smilies
$comment = eregi_replace("-bigeek-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."bigeek.gif\" alt=\"Big eek\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-biggrin-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."biggrin.gif\" alt=\"Big grin\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-bigrazz-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."bigrazz.gif\" alt=\"Big razz\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-confused-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."confused.gif\" alt=\"Confused\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-confusedw-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."confusedw.gif\" alt=\"Confused\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-cool-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."cool.gif\" alt=\"Cool\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-cry-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."cry.gif\" alt=\"Crying\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-dead-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."dead.gif\" alt=\"Dead\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-eek-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."eek.gif\" alt=\"Eek\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-embarrassed-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."embarrassed.gif\" alt=\"Embarrassed\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-laugh-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."laugh.gif\" alt=\"Laughing\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-mad-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."mad.gif\" alt=\"Mad\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-no-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."no.gif\" alt=\"No\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-careless-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."none.gif\" alt=\"Careless\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-razz-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."razz.gif\" alt=\"Razz\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-roll-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."roll.gif\" alt=\"Rolling  eyes\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-rolleyes-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."rolleyes.gif\" alt=\"Rolling eyes\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-sad-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."sad.gif\" alt=\"Sad\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-shy-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."shy.gif\" alt=\"Shy\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-sigh-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."sigh.gif\" alt=\"Sigh\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-sighw-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."sighw.gif\" alt=\"Sigh\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-sleep-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."sleep.gif\" alt=\"Sleeping\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-sleepw-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."sleepw.gif\" alt=\"Sleeping\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-smile-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."smile.gif\" alt=\"Smile\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-smilegrin-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."smilewinkgrin.gif\" alt=\"Smilegrin\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-upset-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."upset.gif\" alt=\"Upset\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-upsetw-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."upsetw.gif\" alt=\"Upset\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-wink-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."wink.gif\" alt=\"Wink\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("-yes-", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."yes.gif\" alt=\"Yes\" border=\"0\" align=\"absmiddle\" />", "$comment");

// Definition of other smilies
$comment = eregi_replace("\:\O", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."bigeek.gif\" alt=\"Big eek\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\:\D", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."biggrin.gif\" alt=\"Big grin\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\:\P", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."bigrazz.gif\" alt=\"Big razz\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\8\)", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."cool.gif\" alt=\"Cool\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\X\(", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."dead.gif\" alt=\"Dead\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\:\|", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."none.gif\" alt=\"Careless\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\:\\(", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."sad.gif\" alt=\"Sad\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\:\)", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."smile.gif\" alt=\"Smile\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\;\D", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."smilewinkgrin.gif\" alt=\"Smilegrin\" border=\"0\" align=\"absmiddle\" />", "$comment");
$comment = eregi_replace("\;\)", "<img src=\"../common/smilies/".$smileycolor."/".$smileycolor."wink.gif\" alt=\"Wink\" border=\"0\" align=\"absmiddle\" />", "$comment");


// Adds BB-code if the configuration file says so
if ($allowbbcode == "yes") {
$comment = eregi_replace("\[b\]", "<b>", "$comment");
$comment = eregi_replace("\[/b\]", "</b>", "$comment");

$comment = eregi_replace("\[i\]", "<i>", "$comment");
$comment = eregi_replace("\[/i\]", "</i>", "$comment");

$comment = eregi_replace("\[u\]", "<u>", "$comment");
$comment = eregi_replace("\[/u\]", "</u>", "$comment");

$comment = eregi_replace("\[s\]", "<s>", "$comment");
$comment = eregi_replace("\[/s\]", "</s>", "$comment");

$comment = eregi_replace("\[big\]", "<big>", "$comment");
$comment = eregi_replace("\[/big\]", "</big>", "$comment");

$comment = eregi_replace("\[small\]", "<small>", "$comment");
$comment = eregi_replace("\[/small\]", "</small>", "$comment");
}

?>