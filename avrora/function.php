<?php
/*
0	read
1	write
2	delete
3	create
4	execute
*/
function check_access($obj,$id, $type) {
	return true;
}

function make_date($name, $current=FALSE, $class=FALSE) {
	$return='';
	if ($current) {
		$_year=date("Y",$current);
		$_month=date("m",$current);
		$_day=date("d",$current);
	}

	$return.= "<table width='' border='0' cellspacing='0' cellpadding='0'>\n";
	$return.= "	<tr>\n";

	$return.= "		<td><select name='".$name."_year' style='width:56px' class=".$class.">\n";
	for ($i=2000;$i<2006;$i++) {
		if ($i==$_year) {$sel='SELECTED';} else {$sel='';}
		$return.= "				<option value='".sprintf("%04d", $i)."' ".$sel.">".sprintf("%04d", $i)."</option>\n";
	}
	$return.= "			</select>\n";
	$return.= "		</td>\n";

	$return.= "		<td>&nbsp;<select name='".$name."_month' style='width:40px' class=".$class.">\n";
	for ($i=1;$i<13;$i++) {
		if ($i==$_month) {$sel='SELECTED';} else {$sel='';}
		$return.= "				<option value='".sprintf("%02d", $i)."' ".$sel.">".sprintf("%02d", $i)."</option>\n";
	}
	$return.= "			</select>\n";
	$return.= "		</td>\n";

	$return.= "		<td>&nbsp;<select name='".$name."_day' style='width:40px' class=".$class.">\n";
	for ($i=1;$i<32;$i++) {
		if ($i==$_day) {$sel='SELECTED';} else {$sel='';}
		$return.= "				<option value='".sprintf("%02d", $i)."' ".$sel.">".sprintf("%02d", $i)."</option>\n";
	}
	$return.= "			</select>\n";
	$return.= "		</td>\n";

	$return.= "	</tr>\n";
	$return.= "</table>\n";

	return $return;
}

function  post_mail_($mail_to, $mail_from, $mail_subj, $mail_text, $mail_header) {
	$head='';
	while (list ($key, $val) = each ($mail_header)) {
    	$head.=$mail_header[$key]."\n";
	}
	mail($mail_to, $mail_subj, $mail_text, "From: ".$mail_from."\r\n".$head);
}
?>