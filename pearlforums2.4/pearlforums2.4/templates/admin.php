<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    admin.php - HTML template of outter frame and links in 
//                  admin pages.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Admin index screen
//  Parameter: Stats(Array)
//  Return: HTML
function getAdminIndexHTML($stats){
	global $GlobalSettings,$Language,$AdminLanguage,$Document;
	if($stats[logtime]){
		$errorTime=date("M j, Y, g:i a",$stats[logtime]);
		$errorLog=<<<EOF
		<BR/>
		<TABLE ALIGN="CENTER">
		<TR>
			<TD ALIGN="CENTER" CLASS="ERROR">
				$AdminLanguage[SQLerrorfound] $errorTime.  $AdminLanguage[Pleasecheckerror].
			</TD>
		</TR>
		</TABLE>
EOF;
	}
	$contents= <<<EOF
<BR/><BR/>
<SPAN CLASS="ERROR">$stats[removeInstall] $stats[msg]</SPAN>
<TABLE>
<TR>
	<TD CLASS="TDPlain" VALIGN="TOP">
		<TABLE ALIGN="CENTER" CELLPADDING="0" CELLSPACING="5" BORDER="0">
		<TR>
			<TD CLASS="TDPlain">
				$AdminLanguage[PHPVersion]:
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				$stats[phpVersion]
			</TD>		
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				$AdminLanguage[MySQLVersion]:
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				$stats[mySQLVersion]
			</TD>		
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				$AdminLanguage[DatabaseSize]:
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				$stats[dbSize] KB
			</TD>		
		</TR>
		</TABLE>
	</TD>
	<TD WIDTH="50"><IMG SRC="images/spacer.gif" WIDTH="50" HEIGHT="1"></TD>
	<TD CLASS="TDPlain" VALIGN="TOP">
		<TABLE ALIGN="CENTER" CELLPADDING="0" CELLSPACING="5" BORDER="0">
		<TR>
			<TD CLASS="TDPlain">
				$AdminLanguage[PearlVersion]:
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				$GlobalSettings[pearlVersion]
			</TD>		
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				$Language[Topics]:
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				$stats[topicsCount]
			</TD>		
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				$Language[Posts]:
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				$stats[postsCount]
			</TD>		
		</TR>
		<TR>
			<TD CLASS="TDPlain">
				$Language[Members]:
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				$stats[membersCount]
			</TD>		
		</TR>
		</TABLE>
	</TD>
</TR>
</TABLE>

$errorLog
<BR/><BR/>
EOF;
	return $contents;	
}//getAdminIndexHTML	

//  Top template and links
//  Parameter: Title(string)
//  Return: HTML
function getAdminOpenTemplateHTML($title){
	global $Language,$Document,$AdminLanguage;
	$heading=commonWhiteTableBoxHTML(300,$title);
	$spacer=" &nbsp; ";
	$contents = commonLanguageButton("adminsettings",$AdminLanguage['Settings'],"?mode=admin&case=settings","") . $spacer;
	$contents .= commonLanguageButton("adminboards",$Language['Boards'],"?mode=admin&case=boards&action=list",""). $spacer;
	$contents .= commonLanguageButton("adminforums",$Language['Forums'],"?mode=admin&case=forums&action=list","") . $spacer;
	$contents .= commonLanguageButton("adminmembers",$Language['Members'],"?mode=admin&case=members&action=list","") . $spacer;
	$contents .= commonLanguageButton("admingroups",$AdminLanguage['Groups'],"?mode=admin&case=groups&action=list","") . $spacer;
	$contents .= commonLanguageButton("adminattachments",$Language['Attachments'],"?mode=admin&case=attachments","") . $spacer;
	$contents .= commonLanguageButton("adminpolls",$AdminLanguage['Polls'],"?mode=admin&case=polls","") . $spacer;
	$contents .= commonLanguageButton("adminavatars",$AdminLanguage['Avatars'],"?mode=admin&case=avatars&action=list","") . $spacer;
	$contents .= commonLanguageButton("adminsmileys",$AdminLanguage['Smileys'],"?mode=admin&case=smileys&action=list","") . $spacer;
	$contents .= commonLanguageButton("adminemailutility",$AdminLanguage['EmailUtility'],"?mode=admin&case=emails","") . $spacer;
	$contents .= commonLanguageButton("adminbannedips",$AdminLanguage['BannedIPs'],"?mode=admin&case=banned","") . $spacer;
	$contents .= commonLanguageButton("adminsensoredwords",$AdminLanguage['SensoredWords'],"?mode=admin&case=sensored","") . $spacer;
	$contents .= commonLanguageButton("adminreservedloginnames",$AdminLanguage['ReservedLoginNames'],"?mode=admin&case=reserved","") . $spacer;
	$contents .= commonLanguageButton("adminerrorlogs",$AdminLanguage['ErrorLogs'],"?mode=admin&case=errorlogs","") . $spacer;
	$contents .= commonLanguageButton("adminbackupdatabase",$AdminLanguage['BackupDatabase'],"?mode=admin&case=backupdatabase","") . $spacer;
	$contents .= commonLanguageButton("admindocumentation",$AdminLanguage['Documentation'],"?mode=admin&case=documentation","") . $spacer;
	
	$contents .= "<BR/>$heading";
	return $contents;
}//getAdminOpenTemplateHTML
	
?>