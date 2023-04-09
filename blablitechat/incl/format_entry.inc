<?php
$entry=clean_entry($entry);

$entry=str_replace("[b]","<b>",$entry);
$entry=str_replace("[i]","<i>",$entry);
$entry=str_replace("[c]","<span class=\"n\">",$entry);
$entry=str_replace("[/i]","</i>",$entry);
$entry=str_replace("[/b]","</b>",$entry);
$entry=str_replace("[/c]","</span>",$entry);

$entry=eregi_replace('[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]','<a href="\\0" target="_blank">\\0</a>',$entry);
$entry=eregi_replace("([A-z0-9_-]+)@([A-z0-9_-]+.[a-zA-Z.]+)","<script type=\"text/javascript\">print_mail('\\1','\\2')</script>",$entry);

for($i=0;$i<count($smilies);$i++){
if(isset($smilies[$i])&&strlen($smilies[$i])>5){
$row=explode('|',$smilies[$i]);
$entry=str_replace($row[0],"<img src=\"$skin_dir/$row[1]\" width=\"$row[2]\" height=\"$row[3]\" title=\"$row[4]\" alt=\"$row[4]\" />",$entry);
}}

if(strlen($entry)>$full_length){
$entry=$lang[37].', <b>'.$name.'</b>...';$name='Admin';}

$words=explode(' ',$entry);
for($i=0;$i<count($words);$i++){
if(isset($words[$i])&&strlen($words[$i])>$words_length){
$entry=$lang[52].' <i>'.$REMOTE_ADDR.'</i>...';$name='Admin';break;
}}

$entry=remove_bad_words($entry);
?>