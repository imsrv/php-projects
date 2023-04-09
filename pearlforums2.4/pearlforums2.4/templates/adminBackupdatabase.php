<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminBackupdatabase.php - HTML templates for outputs of 
//                  database backup in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Database backup entry form 
//  Parameter: Stats(Array)
//  Return: HTML
function getFormHTML($stats){
	global $Document,$GlobalSettings,$Language,$AdminLanguage;
	$submitButton = commonGetSubmitButton(false,$AdminLanguage['Backup'],"");
	$backupType==""?$structureData=" checked":$structureOnly=" checked";
	$contents = <<<EOF
	<BR />
	$Document[msg]
	<BR />
	<FORM ACTION="$Document[mainScript]" METHOD="POST">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="backupdatabase">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="backup">	
	<TABLE ALIGN="CENTER">
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[Database]:
		</TD>
		<TD CLASS="TDPlain" ALIGN="RIGHT">
			$GlobalSettings[DBName] -
			$stats[dbSize] KB
		</TD>		
	</TR>
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
			
		</TD>
		<TD CLASS="TDPlain"><BR/>
			<INPUT TYPE="checkbox" NAME="extended" VALUE="1" checked>Extended inserts<BR/>
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
			
		</TD>
		<TD CLASS="TDPlain"><BR/>
			<INPUT TYPE="radio" NAME="backupType" VALUE="structure" $structureOnly>Structure only<BR/>
			<INPUT TYPE="radio" NAME="backupType" VALUE="data" $structureData>Structure and data<BR/>			
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
		</TD>
		<TD CLASS="TDPlain"><BR/>
			$submitButton
		</TD>
	</TR>	
	</TABLE>
	</FORM>
EOF;
	return $contents;
}//getFormHTML


?>
