<?

////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    addressbook.php - HTML templates of address book,
//                  a new module in version 2.0.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

function getNewContactFormHTML($totalCount,$MemberDetails){
	global $GlobalSettings,$VARS,$Document,$Language;
	extract ($VARS,EXTR_OVERWRITE);

	$avatar=$MemberDetails[avatar]?"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/$MemberDetails[avatar]\"></DIV>":"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/nophoto.gif\"></DIV>";

	$contents = <<<EOF
<BR/>
		<FORM ACTION="$Document[mainScript]" METHOD="POST">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="addressbook" />
		<INPUT TYPE="HIDDEN" NAME="action" VALUE="insert" />
		<INPUT TYPE="HIDDEN" NAME="contactId" VALUE="$contactId" />
		<INPUT TYPE="HIDDEN" NAME="totalCount" VALUE="$totalCount" />
<TABLE WIDTH="400" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="10" BORDER="0" STYLE="border-style:outset;border-color:white;border-width:1px">
<TR>
	<TD>		
		<TABLE WIDTH="400" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
		<TR>
			<TD CLASS="TDPlain" ALIGN="CENTER" VALIGN="TOP">
				<BR>
				$avatar
				$MemberDetails[name]
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				<SPAN CLASS="GreyText">$Language[Contactdetails]</SPAN><br>
				<TEXTAREA NAME="notes" ROWS="7" STYLE="width:250px">$notes</TEXTAREA><BR>
				<INPUT TYPE="SUBMIT" VALUE="$Language[AddContact]"  CLASS="SUBMITBUTTON" />
			</TD>
		</TR>
		</TABLE>
		
	</TD>
</TR>
</TABLE>
</FORM>		
<BR>
EOF;
	return $contents;
}//getNewContactFormHTML

function getEditContactFormHTML($ContactDetails){
	global $GlobalSettings,$VARS,$Document,$AlternatingColors,$Language;

	$avatar=$MemberDetails[avatar]?"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/$MemberDetails[avatar]\"></DIV>":"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/nophoto.gif\"></DIV>";

	$notes=$ContactDetails[notes];
	$contents = <<<EOF
<BR />	
		<FORM ACTION="$Document[mainScript]" METHOD="GET">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="addressbook" />
		<INPUT TYPE="HIDDEN" NAME="action" VALUE="update" />
		<INPUT TYPE="HIDDEN" NAME="entryId" VALUE="$ContactDetails[entryId]" />
<TABLE BGCOLOR="$AlternatingColors[0]" WIDTH="400" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="10" BORDER="0" STYLE="border-style:outset;border-color:white;border-width:1px">
<TR>
	<TD>		
		<TABLE WIDTH="400" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
		<TR>
			<TD CLASS="TDPlain" VALIGN="TOP" ALIGN="CENTER">
				<BR>
				$avatar
				$ContactDetails[name]
			</TD>
			<TD CLASS="TDPlain" ALIGN="RIGHT">
				<SPAN CLASS="GreyText">$Language[Contactdetails]</SPAN><br>
				<TEXTAREA NAME="notes" ROWS="7" STYLE="width:250px">$notes</TEXTAREA><BR>
				<INPUT TYPE="SUBMIT" VALUE="$Language[Update]"  CLASS="SUBMITBUTTON" />
			</TD>
		</TR>
		</TABLE>
		
	</TD>
</TR>
</TABLE>
</FORM>		
<BR>
EOF;
	return $contents;
}//getEditContactFormHTML

function getContactRowHTML($data){
	GLOBAL $GlobalSettings,$Document,$GenderTypes,$Member;

	$deleteButton=commonLanguageButton("deletepost",$Language['Delete'],"?mode=addressbook&action=delete&entryId=$data[entryId]","");	
	$editButton=commonLanguageButton("edit",$Language['Edit'],"?mode=addressbook&action=edit&entryId=$data[entryId]","");	
	$msgButton=commonLanguageButton("sendmessage",$Language['Sendmessage'],"?mode=messages&action=new&loginName=$data[loginName]","");	
	$controls = commonWhiteTableBoxHTML(0,"$deleteButton &nbsp; $editButton &nbsp; $msgButton");
	
	$avatar=$data[avatar]?"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/$data[avatar]\"></DIV>":"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/nophoto.gif\"></DIV>";
	$notes=nl2br($data[notes]);

	$contents=<<<EOF
<TR>
<TD CLASS="TDPlain">
	<TABLE CLASS="TABLESTYLE" WIDTH="400" BORDER="0" BGCOLOR="#EFEFEF" CELLSPACING="5" CELLPADDING="0" BORDER="0">
	<TR>
		<TD CLASS="TDPlain" ALIGN="CENTER">
			$avatar
			<A HREF=$Document[scriptName]?mode=profile&loginName=$data[loginName]>$data[name]</A>
		</TD>
		<TD CLASS="TDPlain" VALIGN="TOP">
			<TABLE WIDTH="100%">
			<TR>
				<TD ALIGN="RIGHT">$controls <BR/><BR/></TD>
			</TR>
			<TR>
				<TD CLASS="TDPlain">
					$notes
				</TD>
			</TR>
			</TABLE>
			
			
		</TD>
	</TR>
	</TABLE>	
</TD>
</TR>
EOF;

	return $contents;
}
?>