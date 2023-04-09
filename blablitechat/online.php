<?php include "config.php";
print "<?xml version=\"1.1\" encoding=\"$lang[1]\"?>";
print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
print "\n<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"$lang[2]\">\n";
print "<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=$lang[1]\" />\n";
?><style type="text/css">

body{font-family:verdana,sans-serif;font-size:10px;color:black;background-color:white}

</style><title><?php print $lang[27];?></title></head><body>
<?php
$online=0;
$fs=refresh_online(0,1);
$online=count($fs);

$activity='-';
$fs=open_file($log_file,1);
if(isset($fs[0])&&strlen($fs[0])>9){
$activity=explode(":|:",$fs[0]);
$activity=substr($fs[0],0,10);
$activity=show_time($activity);}

print $lang[27].': '.$online.'<br />';
print $lang[28].': '.$activity;

?></body></html>