<?

function GenerateMergeFieldInserts()
{
	global $ROOTURL;
	global $CURRENTADMIN;
	global $TABLEPREFIX;
	global $ListID;
	global $t;

	$float = '<script language="JavaScript" src="' . $ROOTURL . 'admin/includes/js/genmove.js"></script>';

	$float .= '<div id="mergeDiv" style="position:absolute; overflow-y:auto; top:10; width: 420; height:300; border: solid 1px black"><div class="handle" handlefor="mergeDiv" id="title" style="padding: 3px; background-color:#D4D0C8; height:20px; color:#000000; border-bottom: 1px solid #999999">&nbsp;<b>HTML Merge Fields</b></div>';

	$float .= '<TABLE width="100%" cellpadding="4" class="blockplain">
		<TR><TD colspan="3" class="menuheader"><div style="position: absolute; left:350" align="right">[<a class="menutext" href="javascript:void(0)" onClick="mergeDiv.style.display=\'none\'; foo.focus();">Close</a>]&nbsp;</div>Basic Tags</td></TR>

		<TR><TD class="admintext">Email Address</td><td class="admintext">%BASIC:EMAIL%</td><TD><a href="javascript: '."InsertCode('BASIC:EMAIL')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3"></td></TR>
		<TR><TD class="admintext">Confirmation (Confirmed/Unconfirmed)</td><td class="admintext">%BASIC:CONFIRMATION%</td><TD><a href="javascript: '."InsertCode('BASIC:CONFIRMATION')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3"></td></TR>
		<TR><TD class="admintext">Status (Active/Inactive)</td><td class="admintext">%BASIC:STATUS%</td><TD><a href="javascript: '."InsertCode('BASIC:STATUS')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3"></td></TR>
		<TR><TD class="admintext">Format (Text/HTML)</td><td class="admintext">%BASIC:FORMAT%</td><TD><a href="javascript: '."InsertCode('BASIC:FORMAT')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3"></td></TR>
		<TR><TD class="admintext">Subscription Date </td><td class="admintext">%BASIC:SUBDATE%</td><TD><a href="javascript: '."InsertCode('BASIC:SUBDATE')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3"></td></TR>
		<TR><TD class="admintext">Unsubscribe Link</td><td class="admintext">%BASIC:UNSUBLINK%</td><TD><a href="javascript: '."InsertCode('BASIC:UNSUBLINK')".'" class="adminlink">Insert</a></TD></tr>
		<TR><TD colspan="3"></td></TR>
	';
		
	$float.='<TR><TD colspan="3" class="menuheader"><B>Custom Fields</B></td></TR>';
	$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "'");
	
	while($f=mysql_fetch_array($list_fields))
	{
		$float.='<TR><TD class="admintext">'.$f["FieldName"].'</td><td class="admintext">%FIELD:'.$f["FieldID"].'%</td><TD><a href="javascript: '."InsertCode('FIELD:".$f["FieldID"]."')".'" class="adminlink">Insert</a></TD></tr><TR><TD colspan="3"></td></TR>';
	}

	$float.='<TR><TD colspan="3" class="menuheader"><B>Images</B></td></TR>';
	if($CURRENTADMIN["Manager"] == 1)
	{
		$images = mysql_query("SELECT * FROM " . $TABLEPREFIX . "images ORDER BY ImageName");
	}
	else
	{
		$images = mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY ImageName");
	}
	
	while($f=mysql_fetch_array($images))
	{
		$float.='<TR><TD class="admintext">'.$f["ImageName"].'</td><td class="admintext">%IMAGE:'.$f["ImageID"].'%</td><TD><a href="javascript: '."InsertCode('IMAGE:".$f["ImageID"]."')".'" class="adminlink">Insert</a></TD></tr><TR><TD colspan="3"></td></TR>';
	}
		
	$float .= '<TR><TD colspan="3" class="menuheader"><B>Links</B></td></TR>';
	if($CURRENTADMIN["Manager"] == 1)
	{
		$links = mysql_query("SELECT * FROM " . $TABLEPREFIX . "links ORDER BY LinkName");
	}
	else
	{
		$links = mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY LinkName");
	}
	
	while($l = mysql_fetch_array($links))
	{
		$float .= '<TR><TD class="admintext">'.$l["LinkName"].'</td><td class="admintext">%LINK:'.$l["LinkID"].'%</td><TD><a href="javascript: '."InsertCode('LINK:".$l["LinkID"]."')".'" class="adminlink">Insert</a></TD></tr><TR><TD colspan="3"></td></TR>';
	}

	$float .= '</TABLE>';
	$float .= '</div>

		<script>

			var whichField = 0;
			var whichWYSIWYG = 1;
			var whichText = 0;

			mergeDiv.style.display = "none";

			function toggleMergePopup(which, whichEditor)
			{
				whichField = which;
				whichWYSIWYG = whichEditor;
				whichText = whichEditor;

				var x = ((document.body.clientWidth / 2) - 210) + document.body.scrollLeft;
				var y = ((document.body.clientHeight / 2) - 150) + document.body.scrollTop;

				mergeDiv.style.left = x;
				mergeDiv.style.top = y;
				mergeDiv.style.display = "inline";

				whichField = which;
			}

			function InsertCode(theCode)
			{
				if(whichField == 1) //HTML
				{
					foo.focus();
					var sel = foo.document.selection;
					var r = sel.createRange();
					
					r.pasteHTML("%" + theCode + "%");
					mergeDiv.style.display = "none";
				}
				else //Text
				{
					if(whichText == 0) // Stand alone text box for newsletter
						var t = document.getElementById("TEXTBODY");

					t.value += "%" + theCode + "%";
					t.focus();
					mergeDiv.style.display = "none";
				}
			}

		</script>
	';

	return $float;
}


function MakeSuccessBox($Title, $Content, $Link1, $Link2URL = "", $Link2Text = "", $NewWindow = false, $Link3URL = "", $Link3Text = "", $Link3Target = "", $Link4URL = "", $Link4Text = "", $Link4Target = "")
{
	global $ROOTURL;

	if($NewWindow == false)
	{
		$r = "
			<span class=heading1>$Title</span><br><br>
			<TABLE width=100% border=0 cellspacing=0 cellpadding=0>
				<tr>	  
				  <td width=18 class=infobox>
					<img src=" . $ROOTURL . "admin/images/success.gif width=18 height=18 hspace=10 vspace=5 align=middle>
				  </td>
				<td class=infobox>
					<b>$Content</b>
				</td>
				</tr>
			</TABLE>
			<br>
			<INPUT TYPE=button class=smallbutton onClick=\"document.location.href='$Link1'\" value='OK'>
		";
	}
	else
	{
		$r = "
			<span class=heading1>$Title</span><br><br>
			<TABLE width=100% border=0 cellspacing=0 cellpadding=0>
				<tr>	  
				  <td width=18 class=infobox>
					<img src=$ROOTURL/admin/images/success.gif width=18 height=18 hspace=10 vspace=5 align=middle>
				  </td>
				<td class=infobox>
					<b>$Content</b>
				</td>
				</tr>
			</TABLE>
			<br>
			<INPUT TYPE=button class=smallbutton onClick=\"window.open('$Link1')\" value='OK'>
		";
	}

	if($Link2URL != "")
	{
		$r .= "<INPUT TYPE=button class=\"medbutton\" onClick=\"document.location.href='$Link2URL'\" value='$Link2Text'>&nbsp;";
	}

	if($Link3URL != "")
	{
		if($Link3Target == "")
			$r .= "<INPUT TYPE=button class=\"medbutton\" onClick=\"document.location.href='$Link3URL'\" value='$Link3Text'>&nbsp;";
		else
			$r .= "<INPUT TYPE=button class=\"medbutton\" onClick=\"window.open('$Link3URL')\" value='$Link3Text'>&nbsp;";
	}

	if($Link4URL != "")
	{
		if($Link4Target == "")
			$r .= "<INPUT TYPE=button class=\"medbutton\" onClick=\"document.location.href='$Link4URL'\" value='$Link4Text'>&nbsp;";
		else
			$r .= "<INPUT TYPE=button class=\"medbutton\" onClick=\"window.open('$Link4URL')\" value='$Link4Text'>&nbsp;";
	}

	return $r;
}

function MakeErrorBox($Title, $Content)
{
	global $ROOTURL;

	$r = "
		<span class=heading1>$Title</span><br><br>
		<TABLE width=100% border=0 cellspacing=0 cellpadding=0>
			<tr>	  
			  <td width=18 class=infobox>
				<img src=" . $ROOTURL . "admin/images/error.gif width=18 height=18 hspace=10 vspace=5 align=middle>
			  </td>
			<td class=infobox>
				$Content<br>&nbsp;
			</td>
			</tr>
		</TABLE>
		<br>
		<INPUT TYPE=button class=smallbutton onClick=\"history.go(-1)\" value='OK'>
	";

	return $r;
}

function MakeInstallErrorBox($Title, $Content)
{
	global $ROOTURL;

	$r = "
		<span class=heading1>$Title</span><br><br>
		<TABLE width=100% border=0 cellspacing=0 cellpadding=0>
			<tr>	  
			  <td width=18 class=infobox>
				<img src=$ROOTURL/admin/images/error.gif width=18 height=18 hspace=10 vspace=5 align=middle>
			  </td>
			<td class=infobox>
				$Content<br>&nbsp;
			</td>
			</tr>
		</TABLE>
		<br>
		<INPUT TYPE=button class=medbutton onClick=\"document.location.reload()\" value='Try Again'>
	";

	return $r;
}

/////////////////////////////////////////////////////////////////////
class AdminForm{
	var $title;
	var $items;
	var $output;
	var $field;
	var $action;
	var $EXTRA;
	var $dontCloseForm;

	// Constructor
	function AdminForm()
	{
		$this->EXTRA = "";
		$this->output = "";
		$this->dontCloseForm = false;
	}

	function Raw($info){
		$info=str_replace('$$$BAR$$$',"|",$info);
		$this->field=$info;
	}
///////////////////////////////////	
	function TextArea($info){
		
		$name = $cols = $rows = $value = $extra = "";
		@list($name,$cols,$rows,$value,$extra)=explode(":",$info);
		$value=trim(str_replace('$$COLON$$', ":", $value));
		$this->field='<TEXTAREA '.$extra.' name="'.$name.'" id="'.$name.'" class="inputfields" cols="'.$cols.'" rows="'.$rows.'">'.$value.'</TEXTAREA>';
		$this->field.= MakeHelp($name);
	}
///////////////////////////////////	
	function WYSIWYG($info){

		global $ROOTURL;
		
		$name = $cols = $rows = $value = $extra = "";
		@list($name,$cols,$rows,$value,$extra)=explode(":",$info);
		$value=str_replace('$$COLON$$', ":", $value);

		$value = str_replace("\\", "\\\\", $value);
		$value = str_replace("'", "\'", $value);
		$value = str_replace(chr(13), "", $value);
		$value = str_replace(chr(10), "", $value);
		$value = eregi_replace("</script>", "<\\/script>", $value);

		// Output only the first editor
		$numEditors++;

		ob_start();
		include("editor/editor1.html");
		$editor = ob_get_contents();
		ob_end_clean();

		$this->field = str_replace("%IMAGE_PATH%", $ROOTURL . "admin/editor/images", $editor);
		$this->field .= '

			<input type="hidden" name="wysiwyg" value="">
			<script>

			window.onLoad = doLoad();
			window.onError = function() { return false; }

			function doLoad()
			{
				foo.document.designMode = "On";
				foo.document.write(\'' . $value . '\');
				foo.document.close();
			}				

			</script>
		';

		$this->field.= MakeHelp($name);

		ob_end_clean();
	}
//////////////////////////////////
	function TextBox($info){

		$name = "";
		$max = "";
		$length = "";
		$value = "";
		$readonly = "";

		@list($name,$max,$length,$value,$readonly,$extra) = explode(":",$info);

		$value=str_replace('$$COLON$$', ":", $value);

		if($readonly)
			$this->field='<INPUT type="text" name="'.$name.'" class="inputfields" size="'.$length.'" maxlength="'.$max.'" value="'.$value.'" disabled>';
		else
			$this->field='<INPUT type="text" name="'.$name.'" class="inputfields" size="'.$length.'" maxlength="'.$max.'" value="'.$value.'">';

		$this->field .= $extra;
		$this->field .= MakeHelp($name);
	}
//////////////////////////////////
	function Password($info){
		list($name,$max,$length,$value,$readonly)=explode(":",$info);
		$value=str_replace('$$COLON$$', ":", $value);
		$this->field='<INPUT type="password" name="'.$name.'" class="inputfields" size="'.$length.'" maxlength="'.$max.'" value="'.$value.'">';
		$this->field.= MakeHelp($name);
	}
//////////////////////////////////
	function FileUpload($info){
		$this->field='<INPUT size="40" NAME="'.$info.'" TYPE="file" class="inputfields">';
		$this->field.= MakeHelp($info);
	}
//////////////////////////////////
	function CheckBoxes($info){
		$this->field='<span class="formtext">';
		list($name,$list)=explode(":",$info);
		$lines=explode(";",$list);
			foreach($lines as $line){
				if($line){
				$r++;
				list($value,$label)=explode("->",$line);
				list($label,$status)=explode("/",$label);
				$this->field.='<input type="checkbox" '.$status.' name="'.$name.'['.$r.']" value="'.$value.'">'.$label;			
				}
			}
		$this->field.= MakeHelp($name);
	}
//////////////////////////////////
	function CheckBox($info){
		$this->field='<span class="formtext">';
		list($name,$value,$label,$status)=explode(":",$info);
				$this->field.='<input type="checkbox" '.$status.' name="'.$name.'" value="'.$value.'">'.$label;
		$this->field.= MakeHelp($name);
	}
//////////////////////////////////
	function SelectBox($info){

		$name = $size = $list = $selected = $extra = $moreExtra = "";
		$value = $label = "";

		@list($name,$size,$list,$selected,$extra,$moreExtra)=explode(":",$info);

		$this->field='<SELECT class="inputfields" name="'.$name.'" size="'.$size.'" '.$extra.'>';
		$lines=explode(";",$list);
			foreach($lines as $line){
				if($line){
					@list($value,$label)=explode("->",$line);
						if($selected==$value && $selected){$sel="SELECTED";}else{$sel="";}
					$this->field.='<OPTION value="'.$value.'" '.$sel.'>'.$label.'</OPTION>';
				}
			}
		$this->field.='</SELECT>' . $moreExtra;
		$this->field.= MakeHelp($name);
	}
//////////////////////////////////
	function DateBoxes($info){
		list($name,$incyear,$mm,$dd,$yy)=explode(":",$info);
		$MonthsOfYear=array(1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"October",10=>"September",11=>"November",12=>"December");
		$DaysOfMonth=array(1=>"1st",2=>"2nd",3=>"3rd",4=>"4th",5=>"5th",6=>"6th",7=>"7th",8=>"8th",9=>"9th",10=>"10th",11=>"11th",12=>"12th",13=>"13th",14=>"14h",15=>"15th",16=>"16th",17=>"17th",18=>"18th",19=>"19th",20=>"2nd",21=>"21st",22=>"22nd",23=>"23rd",24=>"24th",25=>"25th",26=>"26th",27=>"27th",28=>"28th",29=>"29th",30=>"30th",31=>"31st");
			
			$this->field='<select class="inputfields" name="'.$name.'[dd]">';
			for($i=1;$i<=31;$i++){
				if($i==$dd){$sel="SELECTED";}else{$sel="";}
				$this->field.='<option '.$sel.' value="'.$i.'">'.$DaysOfMonth[$i];
			}
			$this->field.='</select>';
			
			$this->field.='<select class="inputfields" name="'.$name.'[mm]">';
			for($i=1;$i<=12;$i++){
				if($i==$mm){$sel="SELECTED";}else{$sel="";}
				$this->field.='<option '.$sel.' value="'.$i.'">'.$MonthsOfYear[$i];
			}
			$this->field.='</select>';
			
			if($incyear==1){
				$this->field.='<input class="inputfields" type="text" maxlength="4" size="4" value="'.$yy.'" name="'.$name.'[yy]">';
			}
		$this->field.= MakeHelp($name);		
	}	
//////////////////////////////////
	function SubmitButton($info){
		
		$label = $extra = "";
		@list($label,$extra,$cancelData)=explode(":",$info);	
		$extra=str_replace('$$COLON$$',":",$extra);

		$this->field = '<input type="submit" name="SubmitButton" value="'.$label.'" class="submit">';

		// Should we output a cancel button?
		if($extra != "")
		{
			$arrCancel = explode("-", $extra);

			if(is_array($arrCancel) && sizeof($arrCancel) > 1)
			{
				$this->field .= '&nbsp;<input class="cancel" type=button value="Cancel" onClick=\'if(confirm("Are you sure?")) { document.location.href="' . MakeAdminLink($arrCancel[1]) . '" }\'>';
			}
		}

		$this->field .= '<br>&nbsp;';
	}
//////////////////////////////////
	function Button($info){
		
		$label = $extra = "";
		@list($label,$extra)=explode(":",$info);	
		$extra=str_replace('$$COLON$$',":",$extra);
		$this->field='<input '.$extra.' type="button" value="'.$label.'" class="submit"><br>&nbsp;';
	}
//////////////////////////////////
	function Hidden($info){
		list($name,$value)=explode(":",$info);	
		$this->field='<input type="hidden" name="'.$name.'" value="'.$value.'" class="inputfields">';	
	}
//////////////////////////////////
	function Spacer($info){
		$this->field='<span class="formtext">'.$info.'</span>';		
	}
	
	
	function MakeForm($BlockHeading = ""){
		GLOBAL $items;

		$this->output = "";

		if(!is_numeric(strpos($this->action, "DEADLINK")))
		{
			$this->output='<FORM onSubmit="return CheckForm()" formid="myform" '.$this->EXTRA.' name="'.$this->title.'" action="'.$this->action.'" method="post">';
		}
		
		$this->output .= '<TABLE width=100% border=0 cellspacing=0 cellpadding=0>'."\n\n\n\n\n\n\n\n\n";

		if($BlockHeading != "")
		{
			$this->output .= '<TR>';
			$this->output .= '<TD colspan=2 height=20 class=menuheader>';
			$this->output .= '&nbsp;&nbsp;' . $BlockHeading;
			$this->output .= '</TD>';
			$this->output .= '</TR>';
			$this->output .= '<TR>';
			$this->output .= '<TD colspan=2 height=10 class=blocktop>';
			$this->output .= '</TD>';
			$this->output .= '</TR>';
		}
		
		foreach($this->items as $name=>$info){
			if($name<0 || $name=="0"){
				$name="";
			}else{
				$name.=":&nbsp;";
			}
			$this->output.='<TR><TD valign="top" width=200 align="left" class=blockplain><p style="margin-left:10"><span class="formtext">'.$name.'</span></TD><TD class=blockplain valign="top">';
			
			list($InputType,$Fields)=explode("|",$info);

			switch($InputType){
				case "raw":
					$this->Raw($Fields);
					break;
			
				case "textarea":
					$this->TextArea($Fields);
					break;
					
				case "wysiwyg":
					$this->WYSIWYG($Fields);
					break;
					
				case "textfield":
					$this->TextBox($Fields);
					break;
					
				case "password":
					$this->Password($Fields);
					break;
					
				case "checkboxes":
					$this->CheckBoxes($Fields);
					break;
				
				case "checkbox":
					$this->CheckBox($Fields);
					break;
				
				case "select":
					$this->SelectBox($Fields);
					break;
			
				case "hidden":
					$this->Hidden($Fields);
					break;
					
				case "spacer":
					$this->Spacer($Fields);
					break;
					
				case "submit":
					$this->SubmitButton($Fields);
					break;	

				case "button":
					$this->Button($Fields);
					break;	
				
				case "dateboxes":
					$this->DateBoxes($Fields);
					break;
					
				case "file":
				$this->FileUpload($Fields);
					break;	
			}
			
			$this->output.=$this->field;
			$this->output.='</TD></TR>'."\n\n";
		}

		if(!is_numeric(strpos($this->action, "DEADLINK")) && $this->dontCloseForm != true)
			$this->output .= "</FORM>";
		
		$this->output .= "</TABLE>";
	}

}

function MakeHelp($ControlName)
{
	global $HELP_ITEMS;
	global $ROOTURL;

	$output = "";
	$r = rand(1, 10000);

	if(@$HELP_ITEMS[$ControlName]["Title"] != "")
	{
		$title = @$HELP_ITEMS[$ControlName]["Title"];
		$content = @$HELP_ITEMS[$ControlName]["Content"];

		$output = '<img onMouseOut="HideHelp(d' . $r . ')" onMouseOver="ShowHelp(d' . $r . ', \''. $title . '\', \'' . $content . '\')" src="' . $ROOTURL . 'admin/images/help.gif" width="24" height="16" border="0"><div style="display:none" id="d' . $r . '"></div>';
	}

	return $output;
}

/////////////////////////////////////////////////////////////////////

function MakeBox($BoxTitle,$BoxContent,$Width="100%",$Seperator="<BR>"){
	GLOBAL $t,$boxes;
	
	$key=rand(10,1000);
	$boxes[$key]=$BoxTitle;
	
	$OUT='<TABLE width="'.$Width.'" cellspacing="0" cellpadding="4">
	<TR>
		<TD class="heading1">'.$BoxTitle.'</TD>
	</TR>
	<TR height="1">
		<TD></TD>
	</TR>
	<TR>
		<TD><span class="admintext">'.$BoxContent.'</SPAN></TD>
	</TR>
	<TR><TD><BR></TD></TR>
	</TABLE>';
	return $OUT;
}
/////////////////////////////////////////////////////////////////////

function MakePopup($url,$width,$height,$title,$args="",$argvals=""){
	GLOBAL $OUTPUT;
	srand(mktime());
	$url=MakeAdminLink($url);
	$PopUpName=$title.rand();
	$FuncName=$title."Pop".rand();
	$OUTPUT.="<script language=\"JavaScript\">
			<!--
			var $PopUpName;
			function $FuncName($args){
				window.name='$PopUpName';
				$PopUpName=window.open('$url','$title','width=$width,height=$height,scrollbars=yes,status=no,toolbars=no,left=125,top=200,resizable=no,menubar=no');


			}

			//-->
		</script>";
		return "javascript: $FuncName($argvals)";
}
/////////////////////////////////////////////////////////////////////

function MakeLink($url,$title,$confirm=0,$raw=0, $target=""){
	if($raw!=1){$url=MakeAdminLink($url);}
	if($confirm){
		GLOBAL $OUTPUT;
		srand((double) microtime() * 1000000);
			$FuncName="ConfirmLink".rand();
		$OUTPUT.="<script language=\"JavaScript\">
			<!--
			function $FuncName(){
				var answer;
				answer=confirm(\"Are you sure?\");
				if(answer==true){
					window.location=\"$url\"
				}
			}

			//-->
		</script>";
			
		return '<a href="javascript:'.$FuncName.'()" class="adminlink">'.$title.'</a>';
	}else{
		if($target == "")
			return '<a href="'.$url.'" class="adminlink">'.$title.'</a>';
		else
			return '<a href="'.$url.'" class="adminlink" target="_blank">'.$title.'</a>';
	}
}

?>