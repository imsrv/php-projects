<?php
/* Nullified by GTT */
error_reporting(7);


function blogcphead(){
	echo '<html><head><title>GamaBlog Cp</title></head><body>
		<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr><td><strong><font size="+3"><a href=index.php><img src="gama.gif" align="absbottom" border=0></a>
		GamaSoftware\'s GamaBlog v1.0</font></strong> <a href="index.php?action=logout"><font face=\"Verdana\" size=\"-2\">logout</font></a></td>
		</tr><tr><td align="center"><font size="+1"><strong>Entries/</strong></font>
		<a href="entry.php?action=add"><font size="-2"><em>Add</em></font></a><font size="-2"><em> 
		/ <a href="entry.php?action=list">Edit</a></em></font><font size="+1"><strong>&nbsp;&nbsp;Templates/</strong></font><font size="-2"><em><a href="template.php?action=add">Add</a> 
		/ <a href="template.php?action=list">Edit</a> </em></font><font size="+1"><strong>&nbsp;Options/</strong></font><font size="-2"><em><a href="options.php?action=add">Add</a> 
		/ <a href="options.php?action=list">Edit</a></em></font><font size="+1"><strong>&nbsp;&nbsp;Tools/</strong></font>
		<a href="tools.php"><font size="-2"><em>List</em></font></a></td>
		</tr><tr><td align="center" valign="top"><br><br>';
}

function blogcpfoot(){
	echo '</td></tr></table></body></html>';
}

function blogtablehead($title,$action,$description,$upload=0){
	if($upload==1)
		$uploadformdata="ENCTYPE=\"multipart/form-data\"";
	echo "<form method=\"post\" $uploadformdata action=\"$PHP_SELF?action=$action\">
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		<tr align=\"center\" valign=\"middle\" bgcolor=\"#000000\"> 
		<td colspan=\"2\"><strong><font color=\"#FFFFFF\">$title<br>
        <font size=\"-1\">$description</font></font></strong></td>
		</tr>";
}
function blogtablefoot($reset=1,$submit=1){
	if($submit==1)
		$submitbutton="<input type=\"submit\" value=\"Submit\">";
	if($reset==1)
		$resetbutton="<input type=\"reset\" value=\"Reset\">";
	echo "<tr align=\"center\"><td colspan=\"2\">$submitbutton $resetbutton</td></tr></table></form>";
}

function blogtextbox($title,$description,$variable,$value="",$size="",$max="",$controls=0){
	global $option;
	if($controls > 0){
		$width1="20%";
		$width2="60%";
		$width3="20%";
	}else{
		$width1="26%";
		$width2="74%";
		$width3="";
	}
	$value=stripslashes($value);
	if($controls==1)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a> | <a href=\"$PHP_SELF?action=delete&optionid=$option[id]\" title=\"Click only if you're sure!\"><font face=\"Verdana\" size=\"2\" color=\"red\">Delete</font></a></td>";
	if($controls==2)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a></td>";
	echo"<tr><td width=\"$width1\"><strong>$title<br></strong><font size=\"-1\">$description</font></td>
      <td width=\"$width2\" align=\"right\"> <input type=\"text\" size=\"$size\" maxlength=\"$max\" name=\"$variable\" value=\"$value\"></td>$controlcell</tr>";
}

function blogupload($title,$description,$variable,$controls=0){
	if($controls > 0){
		$width1="20%";
		$width2="60%";
		$width3="20%";
	}else{
		$width1="26%";
		$width2="74%";
		$width3="";
	}
	if($controls==1)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a> | <a href=\"$PHP_SELF?action=delete&optionid=$option[id]\" title=\"Click only if you're sure!\"><font face=\"Verdana\" size=\"2\" color=\"red\">Delete</font></a></td>";
	if($controls==2)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a></td>";
	echo"<tr><td width=\"$width1\"><strong>$title<br></strong><font size=\"-1\">$description</font></td>
      <td width=\"$width2\" align=\"right\"> <input type=\"file\" name=\"$variable\"></td>$controlcell</tr>";
}

function blogtextarea($title,$description,$variable,$value="",$cols="",$rows="",$controls=0){
	global $option;
	if($controls > 0){
		$width1="20%";
		$width2="60%";
		$width3="20%";
	}else{
		$width1="26%";
		$width2="74%";
		$width3="";
	}
	$value=stripslashes($value);
	if($controls==1)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a> | <a href=\"$PHP_SELF?action=delete&optionid=$option[id]\" title=\"Click only if you're sure!\"><font face=\"Verdana\" size=\"2\" color=\"red\">Delete</font></a></td>";
	if($controls==2)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a></td>";
	echo"<tr><td width=\"$width1\"><strong>$title<br></strong><font size=\"-1\">$description</font></td>
		<td align=\"right\" width=\"$width2\"><textarea name=\"$variable\" cols=\"$cols\" rows=\"$rows\">$value</textarea></td>$controlcell</tr>";
}

function blogyesno($title,$description,$variable,$value="",$controls=0){
	global $option;
	if($controls > 0){
		$width1="20%";
		$width2="60%";
		$width3="20%";
	}else{
		$width1="26%";
		$width2="74%";
		$width3="";
	}
	if($controls==1)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a> | <a href=\"$PHP_SELF?action=delete&optionid=$option[id]\" title=\"Click only if you're sure!\"><font face=\"Verdana\" size=\"2\" color=\"red\">Delete</font></a></td>";
	if($controls==2)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a></td>";
	if($value==1)
		$yeschecked="checked";
	if($value==0)
		$nochecked="checked";
	echo"<tr><td width=\"$width1\"><strong>$title<br></strong><font size=\"-1\">$description</font></td>
		<td align=\"right\" width=\"$width2\">Yes <input type=\"radio\" name=\"$variable\" value=\"1\" $yeschecked>
        No <input type=\"radio\" name=\"$variable\" value=\"0\" $nochecked></td>$controlcell</tr>";
}

function blogpassword($title,$description,$variable,$value="",$size="",$max="",$controls=0){
	global $option;
	if($controls > 0){
		$width1="20%";
		$width2="60%";
		$width3="20%";
	}else{
		$width1="26%";
		$width2="74%";
		$width3="";
	}
	$value=stripslashes($value);
	if($controls==1)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a> | <a href=\"$PHP_SELF?action=delete&optionid=$option[id]\" title=\"Click only if you're sure!\"><font face=\"Verdana\" size=\"2\" color=\"red\">Delete</font></a></td>";
	if($controls==2)
		$controlcell="<td align=\"center\" width=\"$width3\"><a href=\"$PHP_SELF?action=edit&optionid=$option[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a></td>";
	echo"<tr><td width=\"$width1\"><strong>$title<br></strong><font size=\"-1\">$description</font></td>
      <td width=\"$width2\" align=\"right\"> <input type=\"password\" size=\"$size\" maxlength=\"$max\" name=\"$variable\" value=\"$value\"></td>$controlcell</tr>";
}

function bloghidden($variable,$value){
	global $option;
	echo"<input type=\"hidden\" name=\"$variable\" value=\"$value\">";
}

?>