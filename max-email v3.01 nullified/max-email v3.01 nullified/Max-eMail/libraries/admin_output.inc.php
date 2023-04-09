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
function FinishOutput(){
GLOBAL $FULL_OUTPUT;
include "admin.inc.php";
exit;
}



/////////////////////////////////////////////////////////////////////
class AdminForm{
	var $title;
	var $items;
	var $output;
	var $field;
	var $action;
	var $EXTRA;
	
	function Raw($info){
		$this->field=$info;
	}
///////////////////////////////////	
	function TextArea($info){
		list($name,$cols,$rows,$value,$extra)=explode(":",$info);
		$value=str_replace('$$COLON$$', ":", $value);
		$this->field='<TEXTAREA '.$extra.' name="'.$name.'" class="inputfields" cols="'.$cols.'" rows="'.$rows.'">'.$value.'</TEXTAREA>';
	}
//////////////////////////////////
	function TextBox($info){
		list($name,$max,$length,$value,$readonly)=explode(":",$info);
		$value=str_replace('$$COLON$$', ":", $value);
		$this->field='<INPUT type="text" name="'.$name.'" class="inputfields" size="'.$length.'" maxlength="'.$max.'" value="'.$value.'">';
	}
//////////////////////////////////
	function FileUpload($info){
		$this->field='<INPUT size="40" NAME="'.$info.'" TYPE="file" class="inputfields">';
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
				$this->field.='<input type="checkbox" '.$status.' name="'.$name.'['.$r.']" value="'.$value.'">'.$label.'<BR>';			
				}
			}
	}
//////////////////////////////////
	function CheckBox($info){
		$this->field='<span class="formtext">';
		list($name,$value,$label,$status)=explode(":",$info);
				$this->field.='<input type="checkbox" '.$status.' name="'.$name.'" value="'.$value.'">'.$label.'<BR>';			
	}
//////////////////////////////////
	function SelectBox($info){
		list($name,$size,$list,$selected,$extra)=explode(":",$info);
		
		$this->field='<SELECT class="inputfields" name="'.$name.'" size="'.$size.'" '.$extra.'>';
		$lines=explode(";",$list);
			foreach($lines as $line){
				if($line){
					list($value,$label)=explode("->",$line);
						if($selected==$value && $selected){$sel="SELECTED";}else{$sel="";}
					$this->field.='<OPTION value="'.$value.'" '.$sel.'>'.$label.'</OPTION>';			
				}
			}
		$this->field.='</SELECT>';
	}
//////////////////////////////////
	function SubmitButton($info){
		list($label)=explode(":",$info);	
		$this->field='<input type="submit" name="SubmitButton" value="'.$label.'" class="inputfields">';	
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
	
	
	function MakeForm(){
		GLOBAL $items;
		
		$this->output='<FORM '.$this->EXTRA.' name="'.$this->title.'" action="'.$this->action.'" method="post"><TABLE width=100%>'."\n\n\n\n\n\n\n\n\n";
		
		foreach($this->items as $name=>$info){
			if($name<0){
				$name="";
			}else{
				$name.=":&nbsp;";
			}
			$this->output.='<TR><TD valign="top" width=150 align="right"><span class="formtext"> '.$name.'</span></TD><TD>';
			
			list($InputType,$Fields)=explode("|",$info);

			switch($InputType){
				case raw:
					$this->Raw($Fields);
					break;
			
				case textarea:
					$this->TextArea($Fields);
					break;
					
				case textfield:
					$this->TextBox($Fields);
					break;
					
				case checkboxes:
					$this->CheckBoxes($Fields);
					break;
				
				case checkbox:
					$this->CheckBox($Fields);
					break;
				
				case select:
					$this->SelectBox($Fields);
					break;
			
				case hidden:
					$this->Hidden($Fields);
					break;
					
				case spacer:
					$this->Spacer($Fields);
					break;
					
				case submit:
					$this->SubmitButton($Fields);
					break;			
					
				case file:
				$this->FileUpload($Fields);
					break;	
			}
			
			$this->output.=$this->field;
			$this->output.='</TD></TR>'."\n\n";
		}
		$this->output.="</FORM></TABLE>";
	}

}

/////////////////////////////////////////////////////////////////////

function MakeBox($BoxTitle,$BoxContent){
	GLOBAL $AdminTemplate;
	
	
	$OUT='<BR><TABLE width="700" cellspacing="0" cellpadding="4">
	<TR>
		<TD bgcolor="'.$AdminTemplate[ColorOne].'"><B><span class="admintext">:: '.$BoxTitle.'</B></span></TD>
	</TR>
	<TR height="1">
		<TD></TD>
	</TR>
	<TR>
		<TD bgcolor="'.$AdminTemplate[ColorTwo].'"><span class="admintext">'.$BoxContent.'</SPAN></TD>
	</TR>
	</TABLE>';
	return $OUT;
}
/////////////////////////////////////////////////////////////////////

function MakePopup($url,$width,$height,$title,$args="",$argvals=""){
	GLOBAL $FULL_OUTPUT;
	srand(mktime());
	$PopUpName=$title.rand();
	$FuncName=$title."Pop".rand();
	$FULL_OUTPUT.="<script language=\"JavaScript\">
			<!--
			var $PopUpName;
			function $FuncName($args){
				window.name='$PopUpName';
				$PopUpName=window.open('$url','$title','width=$width,height=$height,scrollbars=no,status=no,toolbars=no,left=125,top=200,resizable=no,menubar=no');


			}

			//-->
		</script>";
		return "javascript: $FuncName($argvals)";
}
/////////////////////////////////////////////////////////////////////

function MakeLink($url,$title,$confirm=0){
	if($confirm){
		GLOBAL $FULL_OUTPUT;
		srand((double) microtime() * 1000000);
			$FuncName="ConfirmLink".rand();
		$FULL_OUTPUT.="<script language=\"JavaScript\">
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
		return '<a href="'.$url.'" class="adminlink">'.$title.'</a>';
	}
}






?>