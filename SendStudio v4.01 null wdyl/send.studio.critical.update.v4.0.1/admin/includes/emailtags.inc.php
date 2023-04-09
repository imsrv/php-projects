<?


$OUTPUT.='<script language="JavaScript">
	function InsertCode(code){
		window.opener.document.'.$Formname.'.'.$FieldName.'.value=window.opener.document.'.$Formname.'.'.$FieldName.'.value+" %"+code+"% "
	}
</script>';


//basic tags!
$OUTPUT.='<TABLE width="100%" cellpadding="4">

<TR><TD colspan="3" bgcolor="'.$t["ColorOne"].'" class="admintext"><B>Basic Tags</B></td></TR>



<TR><TD class="admintext">Email Address</td><td class="admintext">%BASIC:EMAIL%</td><TD><a href="javascript: '."InsertCode('BASIC:EMAIL')".'" class="adminlink">Insert</a></TD></tr>
<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>
<TR><TD class="admintext">Confirmation (Confirmed/Unconfirmed)</td><td class="admintext">%BASIC:CONFIRMATION%</td><TD><a href="javascript: '."InsertCode('BASIC:CONFIRMATION')".'" class="adminlink">Insert</a></TD></tr>
<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>
<TR><TD class="admintext">Status (Active/Inactive)</td><td class="admintext">%BASIC:STATUS%</td><TD><a href="javascript: '."InsertCode('BASIC:STATUS')".'" class="adminlink">Insert</a></TD></tr>
<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>
<TR><TD class="admintext">Format (Text/HTML)</td><td class="admintext">%BASIC:FORMAT%</td><TD><a href="javascript: '."InsertCode('BASIC:FORMAT')".'" class="adminlink">Insert</a></TD></tr>
<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>
<TR><TD class="admintext">Subscription Date </td><td class="admintext">%BASIC:SUBDATE%</td><TD><a href="javascript: '."InsertCode('BASIC:SUBDATE')".'" class="adminlink">Insert</a></TD></tr>
<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>
<TR><TD class="admintext">Unsubscribe Link</td><td class="admintext">%BASIC:UNSUBLINK%</td><TD><a href="javascript: '."InsertCode('BASIC:UNSUBLINK')".'" class="adminlink">Insert</a></TD></tr>
<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>

<TR><TD colspan="3" bgcolor="'.$t["ColorOne"].'" class="admintext"><B>Autofill Fields</B></td></TR>
';
	if($ListID=="GLOBAL"){
		$s=" && (Global='1')";
	}else{
		$s=" && (Global='1' || ListID='$ListID')";
	}
$autofill_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "autofill_fields WHERE Status='1' $s");
	while($f=mysql_fetch_array($autofill_fields)){
		$OUTPUT.='<TR><TD class="admintext">'.$f["FieldName"].'</td><td class="admintext">%AUTOFILL:'.$f["AutoFillID"].'%</td><TD><a href="javascript: '."InsertCode('AUTOFILL:".$f["AutoFillID"]."')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>';
	}
	
if($ListID!="GLOBAL"){
$OUTPUT.='
<TR><TD colspan="3" bgcolor="'.$t["ColorOne"].'" class="admintext"><B>Custom Fields</B></td></TR>
';
	$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "'");
	while($f=mysql_fetch_array($list_fields)){
		$OUTPUT.='<TR><TD class="admintext">'.$f["FieldName"].'</td><td class="admintext">%FIELD:'.$f["FieldID"].'%</td><TD><a href="javascript: '."InsertCode('FIELD:".$f["FieldID"]."')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>';
	}

}
$OUTPUT.='<TR><TD colspan="3" bgcolor="'.$t["ColorOne"].'" class="admintext"><B>Images</B></td></TR>
';
	if($ListID=="GLOBAL"){
		$s="Global='1'";
	}else{
		$s="Global='1' || ListID='$ListID'";
	}
$images=mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE $s");
	while($f=mysql_fetch_array($images)){
		$OUTPUT.='<TR><TD class="admintext">'.$f["ImageName"].'</td><td class="admintext">%IMAGE:'.$f["ImageID"].'%</td><TD><a href="javascript: '."InsertCode('IMAGE:".$f["ImageID"]."')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>';
	}
	
$OUTPUT.='<TR><TD colspan="3" bgcolor="'.$t["ColorOne"].'" class="admintext"><B>Links</B></td></TR>
';
	if($ListID=="GLOBAL"){
		$s="Global='1'";
	}else{
		$s="Global='1' || ListID='$ListID'";
	}
$links=mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE Status='1' && $s");
	while($l=mysql_fetch_array($links)){
		$OUTPUT.='<TR><TD class="admintext">'.$l["LinkName"].'</td><td class="admintext">%LINK:'.$l["LinkID"].'%</td><TD><a href="javascript: '."InsertCode('LINK:".$l["LinkID"]."')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>';
	}	

if($ListID){
$ct=mysql_query("SELECT * FROM " . $TABLEPREFIX . "content_types WHERE Status='1'");
	while($tc=mysql_fetch_array($ct)){
		if($tc["SecondIndexField"]){
			$ISI=1;
		}else{
			$ISI=0;
		}
		if(mysql_num_rows($items=mysql_query("SELECT * FROM " . $TABLEPREFIX . "content_submissions WHERE ListID='$ListID' && Reviewed='1' && ContentTypeID='".$tc["ContentTypeID"]."'"))){
		$OUTPUT.='<TR><TD colspan="3" bgcolor="'.$t["ColorOne"].'" class="admintext"><B>'.$tc["ContentTypeName"].'</B></td></TR>';
			
			while($i=mysql_fetch_array($items)){
				$IF=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "content_field_values WHERE SubmissionID='".$i["SubmissionID"]."' && FieldID='".$tc["IndexField"]."'"));
				if($ISI){
				$SI=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "content_field_values WHERE SubmissionID='".$i["SubmissionID"]."' && FieldID='".$tc["SecondIndexField"]."'"));
				$SI=", ".$SI["Value"];
				}
				$OUTPUT.='<TR><TD class="admintext">'.$IF["Value"].$SI.'</td><td class="admintext">%CONTENT:'.$i["SubmissionID"].'%</td><TD><a href="javascript: '."InsertCode('CONTENT:".$i["SubmissionID"]."')".'" class="adminlink">Insert</a></TD></tr>
				<TR><TD colspan="3" bgcolor="'.$t["ColorTwo"].'"></td></TR>';
			}


		}
	}
}

$OUTPUT.='</TABLE>';






?>