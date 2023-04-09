<html>
<head>
<title>

<?php
$forumtitle=strip_tags($configarray[0]);

print "$forumtitle$pagetitle";

echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/$theme/style.css\">";
?>
<script language="javascript">
<!--
function codeinsert(code) {
	document.post.body.value = document.post.body.value + code;
	document.post.body.focus();
}
//-->
</script>

</head>
<body>

<?php

//start header vars
unset($header);
//header logo
if($configarray[34]=="on"){
 $header['logo']="<span class=\"textlarge\"><font size=20>$configarray[0]</font></span>";
}else{
 $header['logo']="<img border=\"0\" src=\"images/${theme_images}/logo.gif\" alt=\"$configarray[0]\">";
}

//headerbuttons
$header['buttons']="<table border=\"0\" height=\"0\" cellspacing=\"0\" cellpadding=\"0\">".
"<tr><td>".
template("tablebutton","<a href=\"index.php\" title=\"Forum listing\">home</a>").
"</td><td>".
template("tablebutton","<a href=\"register.php\" title=\"Create a new account\">register</a>").
"</td>";

if($login==1){
$header['buttons'].="<td>".
template("tablebutton","<a href=\"user_edit.php\" title=\"Profile, Options, PMs, etc\">profile</a>").
"</td>";
}

$header['buttons'].="<td>";
if($userloggedinarray[15]=="administrator"){
$header['buttons'].=template("tablebutton","<a href=\"admin_config.php\" title=\"Board controls, settings, etc\">admin</a>");
}else{
$header['buttons'].="&nbsp";
}
$header['buttons'].="</td>
</tr>
<tr>";

$modulesarray=listdirs("modules");
$m=0;
for($n=0;$n<count($modulesarray);$n++){
include("modules/$modulesarray[$n]/config.php");

if($moduleconfig['active']!=="no"){
 $header['buttons'].="<td>".
 template("tablebutton","<a href=\"modules.php?module=$modulesarray[$n]\" title=\"$modulesarray[$n]\">$modulesarray[$n]</a>").
 "</td>";

 if(intval(($m+1)/4)==($m+1)/4&&$n!==count($modulesarray)){$headerbuttons.="</tr><tr>";}//create a new row for more buttons
 $m++;
}

}
$header['buttons'].="</tr></table>";
//end header buttons

$header['links']="<span class=\"textsmall\"><a href=\"index.php\">$forumtitle</a>$links</span>";

$header['date']="<span class=\"textsmall\">".date($dateformat,time())."</span>";
//end header vars

print "<table border=\"0\" width=\"95%\" height=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\"><tr><td>";

print template("header",$header);

print "<br>";

?>
