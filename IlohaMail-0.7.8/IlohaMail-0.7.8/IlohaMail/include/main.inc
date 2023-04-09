<?
/////////////////////////////////////////////////////////
//	
//	include/main.inc
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

function FormFieldHeader($user, $folder, $start, $sort_field, $string, $cur_field, $cur_order, $color){
	$result="main.php?";
	$result.="user=$user";
	$result.="&folder=".urlencode($folder);
	$result.="&start=$start";
	$result.="&sort_field=$sort_field";
	if (strcasecmp($sort_field, $cur_field)==0){
		if ($cur_order=="ASC") $sort_order="DESC";
		else if ($cur_order=="DESC") $sort_order="ASC";
	}else{
		if (strcasecmp($sort_field, "date")==0) $sort_order="DESC";
		else $sort_order="ASC";
	}
	$result.="&sort_order=$sort_order";
	$result="<a href=\"".$result."\"><b><font color=\"".$color."\">$string</font></b></a>";
	
	return $result;
}
?>