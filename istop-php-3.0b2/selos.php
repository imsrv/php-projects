<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();

$objLay=new Layout(HTML_LAYOUT);
$objCad=$objLay->open(HTML_SELOS);
$objCad->replace_once('uv',HTTP_VOTAR);

$resDir=opendir(DIR_SELOS);
$n=0;
while($sFile=readdir($resDir)){
	if(ereg("\.gif|\.jpg|\.jpeg|\.bmp|\.png$",$sFile)){
		$sHTTP=HTTP_SELOS.$sFile;
		$ar[$n][0]=$sHTTP;
	}
	$n++;
}

$objCad->loop_replace('s',$ar);
$objLay->make($objCad);
?>