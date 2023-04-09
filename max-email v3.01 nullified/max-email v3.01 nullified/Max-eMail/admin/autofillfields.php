<HTML>
<TITLE>AutoFill Fields Available to you..</TITLE>
<HEAD>
<style type="text/css">
   .admintext{font-size:12; text-decoration:none; color:black}
</style>
</HEAD>
<BODY bgcolor="#B0C0D0">
<CENTER>
<TABLE width="90%" cellspacing="0">
<TR bgcolor="#ffffff"><TD><span class="admintext">Field Name</span></TD><TD><span class="admintext">Use this..</span></TD><TD><span class="admintext">Replaces with..</span></TD></TR>
<TR height="1" bgcolor="#efefef"><TD colspan="3"></TD></TR>
<?

include "../config.inc.php";

echo '<TR><TD colspan="3"><B>&nbsp;</TD></TR>
<TR><TD colspan="3"><B><span class="admintext">Date Fields</span></B></TD></TR>
<TR height="1" bgcolor="#efefef"><TD colspan="3"></TD></TR>';
$res=mysql_query("SELECT * FROM autofill_fields WHERE Type='date'");
while($r=mysql_fetch_array($res)){
	if(CanPerformAction("use|autofill|".$r[AutoFillID])){
		echo '<TR><TD><span class="admintext">'.$r[AutoFillName].'</span></TD><TD><span class="admintext">'.$r[AutoFillField].'</span></TD><TD><span class="admintext">'.date($r[ReplaceWith]).'</span></TD></TR>';
	}
}
echo '<TR><TD colspan="3"><B>&nbsp;</TD></TR>
<TR><TD colspan="3"><B><span class="admintext">Basic Fields</span></B></TD></TR>
<TR height="1" bgcolor="#efefef"><TD colspan="3"></TD></TR>';
$res=mysql_query("SELECT * FROM autofill_fields WHERE Type='basic'");
while($r=mysql_fetch_array($res)){
	if(CanPerformAction("use|autofill|".$r[AutoFillID])){
			//get a short enough version of replace with!
			if(strlen($r[ReplaceWith])>15){
				$r[ReplaceWith]=substr($r[ReplaceWith],0,15)."..";
			}
		echo '<TR><TD><span class="admintext">'.$r[AutoFillName].'</span></TD><TD><span class="admintext">'.$r[AutoFillField].'</span></TD><TD><span class="admintext">'.$r[ReplaceWith].'</span></TD></TR>';
	}
}


?>
</TABLE></CENTER>
</BODY>
</HTML>