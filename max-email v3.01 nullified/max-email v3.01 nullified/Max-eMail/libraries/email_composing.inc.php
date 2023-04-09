<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////
function TemplateFields($block){

	$bits=explode("####start####",$block);	
	foreach($bits as $bit){
		if(strstr($bit,"####end####")){
			list($field,$bit)=explode("####end####",$bit);
			$fields[]=$field;
		}
	}
	return $fields;

}

function Text_Compose_Form($OutputFieldName, $FormName, $CurrentValue=""){	
	GLOBAL $ROOT_URL;
$Out.='<script language="javascript">
	function InsertString'.$KeyName.'(string){
		document.'.$FormName.'.'.$OutputFieldName.'.value=document.'.$FormName.'.'.$OutputFieldName.'.value+string;
	}
	
	function InsertSavedLink'.$KeyName.'(url){';
		$Out.="document.$FormName.$OutputFieldName.value=document.$FormName.$OutputFieldName.value+url";
		$Out.='
	}
	
	</script>
	<TABLE width="100%">';
$Out.='<TR><TD><span class="admintext">Special Fields:</span></TD><TD>
<SELECT name="AutoFill'.$KeyName.'" class="inputfields" onChange="InsertString'.$KeyName.'(this.value)"><option value="">:: AutoFill</option>';

$autofill=mysql_query("SELECT * FROM autofill_fields");
while($af=mysql_fetch_array($autofill)){
	if(CanPerformAction("use|autofill|".$af[AutoFillID])){
		$Out.='<option value="'.$af[AutoFillField].'">'.$af[AutoFillName].'</option>';
	}
}

$Out.='</SELECT>&nbsp;&nbsp;';

$Out.='<SELECT name="ListFields'.$KeyName.'" class="inputfields" onChange="InsertString'.$KeyName.'(this.value)"><option value="">:: List Fields</option>';

$lists=mysql_query("SELECT * FROM lists");
while($l=mysql_fetch_array($lists)){
	if(CanPerformAction("view|members|".$l[ListID])){
		$listf=list_fields($l[ListID]);
			foreach($listf as $lf){
				$Out.='<option value="%LISTFIELD:'.$lf.'%">'.$l[ListName].'.'.$lf.'</option>';
			}
	}
}

$Out.='</SELECT>';

$Out.= '</TD></TR>';

$Out.='<tr><td><span class="admintext">Saved Links: </span></TD><td><select name="Links'.$KeyName.'" onChange="InsertSavedLink'.$KeyName.'(this.value)" class="inputfields"><option value="">:: Saved Links</option>';

$links=mysql_query("SELECT * FROM links");
while($im=mysql_fetch_array($links)){
	if(CanPerformAction("use|links|".$im[ImageGroupID])){
			$link=$ROOT_URL."/links.php?LinkID=".$im[LinkID];
			if($im[TraceCode]){
				$link.="&TraceCode=".$im[TraceCode];
			}
		$Out.='<option value="'.$link.'">'.$im[LinkName].'</option>';
	}
}

$Out.='</select></TD></TR>';

$Out.='<tr><td><span class="admintext">Saved Content: </span></TD><td><select name="Content'.$KeyName.'" onChange="InsertString'.$KeyName.'(this.value)" class="inputfields"><option value="">:: Saved Content</option>';

$content=mysql_query("SELECT * FROM content_items");
while($co=mysql_fetch_array($content)){
	if(CanPerformAction("use|content|".$co[ContentCatID])){
		$Out.='<option value="%TextCONTENT:'.$co[ContentID].'%">'.$co[ContentItemName].'</option>';
	}
}

$Out.='</select></TD></TR>';

$Out.='</TABLE>';
$Out.='<P><CENTER><TEXTAREA name="'.$OutputFieldName.'" cols="80" rows="15" class="inputfields">'.str_replace('$$COLON$$', ':', $CurrentValue).'</TEXTAREA><CENTER>';
return $Out;
}


function HTML_Compose_Form($OutputFieldName, $FormName, $CurrentValue="", $KeyName=""){
GLOBAL $ROOT_URL;

$KeyName=str_replace("
", '', $KeyName);
$KeyName=strip_tags($KeyName);


if(!$CurrentValue){
	$CurrentValue='<HTML>
<BODY>
YOUR EMAIL HERE
</BODY>
</HTML>';
}

$Out.='
<script language="javascript">
	function InsertString'.$KeyName.'(string){
		document.'.$FormName.'.'.$OutputFieldName.'.value=document.'.$FormName.'.'.$OutputFieldName.'.value+string;
	}
	
	function SetFont'.$KeyName.'(){
		';
		$Out.="document.$FormName.$OutputFieldName.value=document.$FormName.$OutputFieldName.value+'<font size=\"'+document.$FormName.FontSize$KeyName.value+'\" color=\"'+document.$FormName.FontColor$KeyName.value+'\" face=\"'+document.$FormName.FontFace$KeyName.value+'\"></font>';";
	$Out.='}
	
	function InsertUrl'.$KeyName.'(){
		var url=prompt("Enter the url", "http://www.");
		var title=prompt("What text would you like to appear?");';
		$Out.="document.$FormName.$OutputFieldName.value=document.$FormName.$OutputFieldName.value+'<a href=\"'+url+'\">'+title+'</a>'";
	$Out.='
	}
	
	function InsertSavedLink'.$KeyName.'(url){
		var title=prompt("What text would you like to appear?");';
		$Out.="document.$FormName.$OutputFieldName.value=document.$FormName.$OutputFieldName.value+'<a href=\"'+url+'\">'+title+'</a>'";
	$Out.='
	}
	
	function InsertImage'.$KeyName.'(image){';
		$Out.="document.$FormName.$OutputFieldName.value=document.$FormName.$OutputFieldName.value+'<img src=\"$ROOT_URL/view_image.php?ImageID='+image+'\">'";
	$Out.='
	}
		
	function InsertEmailLink'.$KeyName.'(){
		var email=prompt("Enter the email address", "you@youemail.com");
		var title=prompt("What text would you like to appear?");';
		$Out.="document.$FormName.$OutputFieldName.value=document.$FormName.$OutputFieldName.value+'<a href=\"email:'+email+'\">'+title+'</a>'";
	$Out.='
	}
</script>

<TABLE width="100%">';

$Out.="<tr><TD width=\"10\"><span class=\"admintext\">Basic:</span></td><td>
<input type=\"button\" value=\" B \" style=\"font-weight:bold\" class=\"inputfields\" onClick=\"InsertString$KeyName('<B></B>')\">
<input type=\"button\" value=\" I \" style=\"font-style: italic\" class=\"inputfields\" onClick=\"InsertString$KeyName('<I></I>')\">
<input type=\"button\" value=\" U \" class=\"inputfields\" style=\"text-decoration: underline\" onClick=\"InsertString$KeyName('<U></U>')\">
<input type=\"button\" value=\" Link \" class=\"inputfields\" onClick=\"InsertUrl$KeyName()\">
<input type=\"button\" value=\" Email Link \" class=\"inputfields\" onClick=\"InsertEmailLink$KeyName()\">
<input type=\"button\" value=\" Newline \" class=\"inputfields\" onClick=\"InsertString$KeyName('<BR>')\">
<input type=\"button\" value=\" New Para \" class=\"inputfields\" onClick=\"InsertString$KeyName('<P>')\">
</td></tr>

<tr><td><span class=\"admintext\">Font:</span></td><td><select name=\"FontSize$KeyName\"\" class=\"inputfields\">
<option value=\"\">:: Size</option>";
$sizes=range(-7,7);
foreach($sizes as $size){
$Out.="<option value=\"$size\" $sel>$size</option>";
}

$Out.="
</select>

<select name=\"FontColor$KeyName\" class=\"inputfields\">
<option value=\"\">:: Color</option>";
$colors=array(black,red,orange,yellow,green,pink,blue);
foreach($colors as $color){
	$Out.="<option value=\"$color\" style=\"color:$color\">$color</option>";
}

$Out.="</select>

<select name=\"FontFace$KeyName\" class=\"inputfields\">
<option value=\"\">:: Face</option>
<option value=\"verdana\">Verdana</option>
<option value=\"arial\">Arial</option>
<option value=\"tahoma\">Tahoma</option>
<option value=\"times\">Times</option>
<option value=\"courier\">Courier</option>
</select>
<input type=\"button\" value=\"Set Font\" onClick=\"SetFont$KeyName()\" class=\"inputfields\">

</td></tr>";

$Out.='<TR><TD><span class="admintext">Special Fields:</span></TD><TD>
<SELECT name="AutoFill'.$KeyName.'" class="inputfields" onChange="InsertString'.$KeyName.'(this.value)"><option value="">:: AutoFill</option>';

$autofill=mysql_query("SELECT * FROM autofill_fields");
while($af=mysql_fetch_array($autofill)){
	if(CanPerformAction("use|autofill|".$af[AutoFillID])){
		$Out.='<option value="'.$af[AutoFillField].'">'.$af[AutoFillName].'</option>';
	}
}

$Out.='</SELECT>&nbsp;&nbsp;';

$Out.='<SELECT name="ListFields'.$KeyName.'" class="inputfields" onChange="InsertString'.$KeyName.'(this.value)"><option value="">:: List Fields</option>';

$lists=mysql_query("SELECT * FROM lists");
while($l=mysql_fetch_array($lists)){
	if(CanPerformAction("view|members|".$l[ListID])){
		$listf=list_fields($l[ListID]);
			foreach($listf as $lf){
				$Out.='<option value="%LISTFIELD:'.$lf.'%">'.$l[ListName].'.'.$lf.'</option>';
			}
	}
}

$Out.'</SELECT>';

$Out.='</TD></TR>';

$Out.='<TR><TD><span class="admintext">Images/Links: </span></TD><TD><select name="Images'.$KeyName.'" onChange="InsertImage'.$KeyName.'(this.value)" class="inputfields"><option value="">:: Images</option>';

$images=mysql_query("SELECT * FROM images");
while($im=mysql_fetch_array($images)){
	if(CanPerformAction("use|images|".$im[ImageGroupID])){
		$Out.='<option value="'.$im[ImageID].'">'.$im[FileName].'</option>';
	}
}

$Out.='</select>&nbsp;&nbsp;';

$Out.='<select name="Links'.$KeyName.'" onChange="InsertSavedLink'.$KeyName.'(this.value)" class="inputfields"><option value="">:: Saved Links</option>';

$links=mysql_query("SELECT * FROM links");
while($im=mysql_fetch_array($links)){
	if(CanPerformAction("use|links|".$im[ImageGroupID])){
			$link=$ROOT_URL."/links.php?LinkID=".$im[LinkID];
			if($im[TraceCode]){
				$link.="&TraceCode=".$im[TraceCode];
			}
		$Out.='<option value="'.$link.'">'.$im[LinkName].'</option>';
	}
}

$Out.='</select></TD></TR>';

$Out.='<tr><td><span class="admintext">Saved Content: </span></TD><td><select name="Content'.$KeyName.'" onChange="InsertString'.$KeyName.'(this.value)" class="inputfields"><option value="">:: Saved Content</option>';

$content=mysql_query("SELECT * FROM content_items");
while($co=mysql_fetch_array($content)){
	if(CanPerformAction("use|content|".$co[ContentCatID])){
		$Out.='<option value="%HTMLCONTENT:'.$co[ContentID].'%">'.$co[ContentItemName].'</option>';
	}
}

$Out.='</select></TD></TR>';

$out.='</TABLE>';

$Out.='<P><CENTER><TEXTAREA name="'.$OutputFieldName.'" cols="80" rows="15" class="inputfields">'.str_replace('$$COLON$$', ':', $CurrentValue).'</TEXTAREA><CENTER>';

return $Out;

}




?>