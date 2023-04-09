<META NAME="ROBOTS" CONTENT="noindex">
<META NAME="ROBOTS" CONTENT="nofollow">
<?php
if (!is_set) {
$HTTP_GET_VARS['this']=0;
}
$file = fopen ("http://telalinks.com/system/get.cgi?u=serhatekim&id=16729&c=42&this=".$HTTP_GET_VARS['this'], "r");
while (!feof ($file)) echo fgets ($file, 1024);
fclose($file);
?>
