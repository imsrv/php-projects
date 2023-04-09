<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    locale.php - HTML templates for outputs of local time settings.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format form for choosing local time offset
//  Parameters: ActionButtons(string)
//  Return: HTML
function getFormHTML($button){
	Global $Document,$Language,$HTTP_COOKIE_VARS;
	$serverTime= date ("M d, h:i a");
	$offset = substr($HTTP_COOKIE_VARS[TimeOffset], 0, 1);    
	$hours=str_replace("+","",$HTTP_COOKIE_VARS[TimeOffset]);
	$hours=str_replace("-","",$hours);

	$localTime = "<B>$Language[Localtime]: " . commonTimeFormat(true, time()) . "</B><BR /><BR />"; 		
	
	if($offset=="+")
		$offsetPSelect="Selected";
	else
		$offsetMSelect="Selected";
		
	for($hr=0;$hr<17;$hr++){
		$selected = $hours==$hr?"selected":"";
		$hoursListing .= "<OPTION VALUE=\"$hr\" $selected>$hr</OPTION>";
	}
	$contents=<<<EOF
	<BR />
	<TABLE ALIGN="CENTER">
	<FORM ACTION="$Document[mainScript]" NAME="f">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="locale">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="set">	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Servertime]:  $serverTime <BR><BR>
			$localTime
			Time offset from your local:

			<SELECT NAME="offset">
				<OPTION VALUE="+" $offsetPSelect>$Language[plus]</OPTION>
				<OPTION VALUE="-" $offsetMSelect>$Language[minus]</OPTION>				
			</SELECT>
			<SELECT NAME="hours">
				$hoursListing
			</SELECT>
				$Language[hours]
			<BR /><BR/>

			$button
		</TD>
		<TD CLASS="TDStyle">
		</TD>
	</TR></FORM>
	</TABLE>
	<BR>
EOF;
	return $contents;
}//getFormHTML

//  Format results page
//  Parameter: TimeOffset(integer)
//  Return: HTML
function getDoneHTML($TimeOffset){
	GLOBAL $Document,$Language,$VARS;
	$localTime = ($TimeOffset * 3600) + time();
	$localTime = date("l F j, g:i a", $localTime); 
	
	$contents=<<<EOF
	<BR />
	<TABLE ALIGN="CENTER" WIDTH="$Document[contentWidth]">
	<TR>
		<TD CLASS="TDStyle">
			$Language[Thankyou]	$Language[Timedisplay]:<BR /><BR />
			
			$Language[Localtime]: <B>&raquo; $localTime
			</B><BR><BR>			
		</TD>
	</TR>
	</TABLE>
	<BR /><BR /><BR />
EOF;
	return $contents;
}//getDoneHTML

?>