<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    profile.php - HTML templates for outputs of profile screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Display member's profile.  Administrators's access: edit,lock|unlock account
//  Parameter: MemberDetails(Array)
//  Return: HTML
function getViewProfileHTML($MemberDetails){
	global $GlobalSettings,$Language,$Document,$Member;
	$avatar=$MemberDetails[fileName]?"<DIV ID=\"MemberFullPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/$MemberDetails[fileName]\"></DIV>":"<DIV ID=\"MemberFullPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/nophoto.gif\"></DIV>";		
	if(isset($MemberDetails[editLink])){
		$pad="<IMG SRC=\"images/spacer.gif\" WIDTH=\"1\" HEIGHT=\"5\" /><BR />";
	}
	if($Member['memberId']){
		$msgButton=commonLanguageButton("sendmessage",$Language['Sendmessage'],"?mode=messages&action=new&loginName=$MemberDetails[loginName]","");	
		$contactButton=commonLanguageButton("addcontact",$Language['AddContact'],"?mode=addressbook&action=new&contactId=$MemberDetails[memberId]","");	
		$controls = commonWhiteTableBoxHTML(0,"$MemberDetails[lockLink] &nbsp; $msgButton &nbsp; $contactButton &nbsp; $MemberDetails[editLink]");
	}
	$MemberDetails[bio] =$MemberDetails[bio]? nl2br(stripslashes($MemberDetails[bio])) . "<BR /><BR />":"";
	$MemberDetails['email']=$MemberDetails['hideEmail']?"":"<A HREF=\"mailto:$MemberDetails[email]\">$MemberDetails[email]</A><BR />";
	$MemberDetails['url']=$MemberDetails['url']?"<A HREF=\"$MemberDetails[url]\">$MemberDetails[url]</A><BR /><BR />":"<BR />";
	$contents = <<<EOF
		<CENTER><SPAN CLASS=ERROR>$Document[msg]</SPAN></CENTER>
		<TABLE WIDTH="100%" CELLSPACING="0" CELLPADDING="0" BORDER="0">
		<TR>			
			<TD CLASS="TDStyle" ALIGN="RIGHT">$controls &nbsp;</TD>
		</TR>
		</TABLE>
		<TABLE ALIGN="CENTER" CELLSPACING="0" CELLPADDING="0" BORDER="0">
		<TR>
			<TD CLASS="TDStyle" ALIGN="CENTER" VALIGN="TOP">
				$avatar	
				<NOBR>$MemberDetails[name]</NOBR><BR />
				$MemberDetails[adminPosition]<BR />	
			</TD>		
			<TD CLASS="TDStyle" WIDTH="10">&nbsp;</TD>
			<TD CLASS="TDStyle">
				
				$MemberDetails[bio]
				$MemberDetails[email]
				$MemberDetails[url]	
				$Language[Total]: <A HREF="$Document[mainScript]?mode=search&case=advanced&action=Search&name=$MemberDetails[name]">  $Language[TotalPosts]: $MemberDetails[totalPosts]</A><BR />
			</TD>
		</TR>
		</TABLE>
		<BR />
EOF;
	return $contents;
	
}//getViewProfileHTML

//  Format form for editing profile
//  Parameter: MemberDetails(Array),Errors(Array)
//  Return: HTML
function getEditProfileHTML($MemberDetails,$errorFields){
	global $GlobalSettings,$Language,$VARS,$Document,$Member;
	extract ($VARS,EXTR_OVERWRITE);
	$announcementChecked=$MemberDetails[notifyAnnouncements]?" checked":"";
	$hideEmailChecked=$MemberDetails[hideEmail]?" checked":"";
	$MemberDetails[bio]=stripslashes($MemberDetails[bio]);
	$controls = commonWhiteTableBoxHTML(0,commonLanguageButton("viewprofile",$Language['ViewProfile'],"?mode=profile",""));
	if($MemberDetails[groupName]){
		$group = <<<EOF
			<TR>
			<TD CLASS="TDStyle" WIDTH="120">
				$Language[Group]:
			</TD>
			<TD CLASS="TDStyle">
				$MemberDetails[groupName]
			</TD>
		</TR>
EOF;
	}
	$contents .= <<<EOF
		<TABLE WIDTH="100%">
		<TR>
			<TD ALIGN="RIGHT">
				$controls
			</TD>
		</TR>
		</TABLE>
		<FORM NAME="profile" ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="profile" />
		<INPUT TYPE="HIDDEN" NAME="action" VALUE="update" />
		<TABLE ALIGN="CENTER" CELLPADDING="0" CELLSPACING="4" BORDER="0">
		<TR>
			<TD></TD>
			<TD CLASS="TDStyle">$Document[msg]</TD>
		</TR>
		$group
		<TR>
			<TD CLASS="TDStyle" WIDTH="120">
				$Language[FullName]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="name" SIZE="30" VALUE="$MemberDetails[name]" MAXLENGTH="40" /> <SPAN CLASS="Error"> $errorFields[name]</SPAN>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				$Language[Email]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="email" SIZE="30" VALUE="$MemberDetails[email]" MAXLENGTH="100" /> <SPAN CLASS="Error">$errorFields[email]</SPAN>	
				<INPUT TYPE="checkbox" NAME="hideEmail" VALUE="1" $hideEmailChecked>$Language[Hide]
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				$Language[URL]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="url" SIZE="30" VALUE="$MemberDetails[url]" MAXLENGTH="100" /> 
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				$Language[BioQuote]:
			</TD>
			<TD CLASS="TDStyle">
				<TEXTAREA NAME="bio" COLS="50" ROWS="4">$MemberDetails[bio]</TEXTAREA> 
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				$Language[Avatar]/$Language[Photo]:
			</TD>
			<TD CLASS="TDStyle">
				<SELECT NAME="avatarId" onChange="showSampleAvatar()">
				$MemberDetails[avatarListing]
				</SELECT>
				<INPUT NAME="userfile" TYPE="file">
			</TD>
		</TR>			
		<TR>
			<TD CLASS="TDStyle">
				$Language[Announcements]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="checkbox" NAME="notifyAnnouncements" VALUE="1" $announcementChecked>$Language[Notify]
			</TD>
		</TR>					
		<TR>
			<TD COLSPAN="2">&nbsp;</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				$Language[Password]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="PASSWORD" NAME="passwd" SIZE="20" VALUE="$passwd" MAXLENGTH="20" /> <SPAN CLASS="Error">$errorFields[passwd]</SPAN> <SPAN CLASS="GreyText">[$Language[Requiredforupdate]]</SPAN>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN="2">&nbsp;</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle" VALIGN="TOP"><IMG SRC="images/spacer.gif" WIDTH="1" HEIGHT="4"><BR />
				$Language[ChangePassword]:
			</TD>
			<TD VALIGN="TOP">
				<TABLE BGCOLOR="LIGHTYELLOW" BORDER="0" CELLSPACING="0" CELLPADDING="0">
				<TR>
					<TD CLASS="TDPlain" WIDTH="124">
						$Language[NewPassword]:
					</TD>
					<TD CLASS="TDPlain">
						<INPUT TYPE="PASSWORD" NAME="newPassword" SIZE="20" VALUE="$newPassword" MAXLENGTH="20" /> 
					</TD>
				</TR>
				<TR>
					<TD CLASS="TDPlain">
						$Language[ConfirmPassword]:
					</TD>
					<TD CLASS="TDPlain">
						<INPUT TYPE="PASSWORD" NAME="confirmPassword" SIZE="20" VALUE="$confirmPassword" MAXLENGTH="20" /> <SPAN CLASS="Error">$errorFields[confirmPassword]</SPAN>
					</TD>
				</TR>					
				</TABLE>
			</TD>			
		</TR>
		<TR>
			<TD COLSPAN="2">&nbsp;</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">&nbsp;
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="SUBMIT" VALUE="$Language[Update]" CLASS="SubmitButtons" />
			</TD>
		</TR>
		</TABLE>
		<BR />
		<IMG NAME="sampleAvatar" SRC="$GlobalSettings[avatarsPath]/default.gif">
		<SCRIPT>
			var sampleAvatars=new Array($Document[sampleAvatars]);
			showSampleAvatar();
		
			function showSampleAvatar(){
  				document.images.sampleAvatar.src="$GlobalSettings[avatarsPath]/"+sampleAvatars[document.profile.avatarId.selectedIndex];
        	}
		</SCRIPT>

EOF;
	return $contents;
}//getEditProfileHTML	

?>