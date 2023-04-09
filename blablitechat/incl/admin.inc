<?php
include "config.php";

if(isset($w)&&$w=='logout'){
setcookie('admin_pass','');$admin_pass='';}

$pss_file=$data_dir.'/psss.php';
$die_string="</head><body class=\"y\" onload=\"window.location='admin.php?r=$random'\">OK</body></html>";

if(!is_writeable($pss_file)){
if(!isset($setup_pass)||$setup_pass==''){
include "incl/header.inc";
print '</head><body class="y" onload="document.forms[0].setup_pass.focus()"><form action="admin.php" method="post">';
print '<table align="center" class="t"><tr><td class="k" align="center">';
print '<input type="'.$password_field.'" name="setup_pass" class="g" value="" /> <input type="submit" class="g" value="'.$lang[6].'" /><br /><br />'.$lang[56];
print '</td></tr></table></form></body></html>';die();
}
else{
setcookie('admin_pass',$setup_pass);
$setup_pass='<?php die();?>'.md5($setup_pass);
save_file($pss_file,$setup_pass,'CHMOD /data to 777!');
include "incl/header.inc";
die($die_string);}}

else{
$stored_pass=open_file($pss_file,0);
$stored_pass=str_replace('<?php die();?>','',$stored_pass);

if(!isset($admin_pass)||$stored_pass!=md5($admin_pass)){

if(isset($enter_pass)&&$stored_pass==md5($enter_pass)){
setcookie('admin_pass',$enter_pass);
include "incl/header.inc";
die($die_string);}

else{
include "incl/header.inc";
print '</head><body class="y" onload="document.forms[0].enter_pass.focus()"><form action="admin.php" method="post">';
print '<table align="center" class="t"><tr><td class="k" align="center">';
print '<input type="'.$password_field.'" name="enter_pass" class="g" value="" /> <input type="submit" class="g" value="'.$lang[6].'" /><br /><br />';
print '</td></tr></table></form></body></html>';die();
}}}?>