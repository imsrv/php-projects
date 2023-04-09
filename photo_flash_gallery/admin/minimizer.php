<?
function minimizer($src_w,$src_h,$dst_w,$dst_h)
{
	$mlt_w = $dst_w / $src_w;
	$mlt_h = $dst_h / $src_h;
	$mlt = $mlt_w < $mlt_h ? $mlt_w:$mlt_h;
	if($dst_w == "*") $mlt = $mlt_h;
	if($dst_h == "*") $mlt = $mlt_w;
	if($dst_w == "*" && $dst_h == "*") $mlt=1;
	$dst_w =  round($src_w * $mlt);
	$dst_h =  round($src_h * $mlt);
	
	return array("w"=>$dst_w,"h"=>$dst_h);
}
?>