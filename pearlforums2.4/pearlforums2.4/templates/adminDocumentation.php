<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminHelp.php - HTML templates for help topics in
//                  admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format administrative help topics/contents
//  Return: HTML
function getHelpHTML(){
	global $Document,$GlobalSettings,$AdminLanguage,$Language;
	include_once("$Document[languagePreference]/documentation.php");	
	$heading=commonWhiteTableBoxHTML(300,$AdminLanguage[Documentation]);
	$helpText=getDocumentationContents();
	$contents = <<<EOF
	<TR>
		<TD CLASS="MainTR" ALIGN="CENTER">$heading</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
		<TABLE WIDTH="90%">
		<TR>
			<TD CLASS="TDStyle">
			$helpText
			</TD>
		</TR>
		</TABLE>		
		</TD>
	</TR>
EOF;
	return $contents;
}//getHelpHTML
?>
