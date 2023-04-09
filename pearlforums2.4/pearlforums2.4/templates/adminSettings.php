<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminSettings.php - HTML templates for outputs of 
//                  setting screens in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format form for editing
//  Parameters: Re-entry?(true|false), CureentSettingsData(Array)
//  Return: HTML
function getFormHTML($entry,$data){
	global $Document,$GlobalSettings,$Language,$AdminLanguage,$VARS;
	extract($GlobalSettings,EXTR_OVERWRITE);
	extract($data,EXTR_OVERWRITE);
	$membersOnlyList =  commonYesNoOptions($membersOnly);
	$checkBannedIPsList =  commonYesNoOptions($checkBannedIPs);	
	$checkSensoredWordsList =  commonYesNoOptions($checkSensoredWords);	
	$allowGuestPostingList =  commonYesNoOptions($allowGuestPosting);	
	$allowAttachmentsList  =  commonYesNoOptions($allowAttachments);
	$allowMessageAttachmentsList  =  commonYesNoOptions($allowMessageAttachments);
	$allowNotifyList = commonYesNoOptions($allowNotify);
	$displayMemberProfileList = commonYesNoOptions($displayMemberProfile);
	$showEditTimeList = commonYesNoOptions($showEditTime);
	$showModeratorsList = commonYesNoOptions($showModerators);
	$showBoardDescriptionList = commonYesNoOptions($showBoardDescription);
	$showForumInfoList = commonYesNoOptions($showForumInfo);	
	$showIPsList = commonYesNoOptions($showIPs);
	$graphicButtonsList = commonYesNoOptions($graphicButtons);	
	$antiOnRegistrationList = commonYesNoOptions($RegistrationSpamGuard);	
	$antiOnLoginList = commonYesNoOptions($LoginSpamGuard);	
	if(!is_writable("settings.php")){
		$writableWarning="<BR/><SPAN CLASS=ERROR>$AdminLanguage[WritableWarningSettings]<STRONG><BR/>";		
	}

	if($entry){
		$avatarTypes=count($avatarTypes)?implode(" ",$avatarTypes):"";
		$disallowAttachmentTypes=count($disallowAttachmentTypes)?implode(" ",$disallowAttachmentTypes):"";
	}
	$submitButton = commonGetSubmitButton(false,$Language['Update'],"");
	$contents = <<<EOF
	<TABLE WIDTH="90%">
	<TR>
		<TD CLASS="TDStyle">
			$writableWarning
			$Document[msg]
		</TD>
	</TR>
	</TABLE>
	<FORM ACTION="$Document[mainScript]" METHOD="POST">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="settings">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="Update">	
	<INPUT TYPE="HIDDEN" NAME="oSpamGuardFolder" VALUE="$SpamGuardFolder">
	<TABLE ALIGN="CENTER">
	<TR>
		<TD COLSPAN="2" CLASS="TDPlain"><BR />
			<B><U>$AdminLanguage[DatabaseSettings]</U></B>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[Server]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBServer" VALUE="$DBServer" SIZE="10">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[DatabaseName]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBName" VALUE="$DBName" SIZE="10">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[TableNamePrefix]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBPrefix" VALUE="$DBPrefix" SIZE="10">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[Username]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBUser" VALUE="$DBUser" SIZE="10">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$Language[Password]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="DBPassword" VALUE="$DBPassword" SIZE="10">
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2" CLASS="TDPlain"><BR />
			<B><U>$AdminLanguage[General]</U></B>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[DefaultDocumentTitle]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="title" VALUE="$title" SIZE="30">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[Organization]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="Organization" VALUE="$Organization" SIZE="30">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[WebmasterEmail]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="WebmasterEmail" VALUE="$WebmasterEmail" SIZE="30">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[LanguagePreference]:
		</TD>
		<TD CLASS="TDPlain">
				<INPUT TYPE="TEXT" NAME="languagePreference" VALUE="$languagePreference" SIZE="10">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[AllowGuestPosting]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="allowGuestPosting">
				$allowGuestPostingList
			</SELECT> <SMALL><SPAN CLASS="GreyText">[$AdminLanguage[GuestPostingHelp]]</SPAN></SMALL>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MembersOnly]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="membersOnly">
				$membersOnlyList
			</SELECT> <SMALL><SPAN CLASS="GreyText">[$AdminLanguage[MembersOnlyHelp]]</SPAN></SMALL>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[CheckBannedIPs]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="checkBannedIPs">
				$checkBannedIPsList
			</SELECT> <SMALL><SPAN CLASS="GreyText">[$AdminLanguage[BannedIpsHelp]]</SPAN></SMALL>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[CheckSensoredWords]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="checkSensoredWords">
				$checkSensoredWordsList
			</SELECT> <SMALL><SPAN CLASS="GreyText">[$AdminLanguage[SensoredHelp]]</SPAN></SMALL>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[GraphicButtons]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="graphicButtons">
				$graphicButtonsList
			</SELECT> <SMALL><SPAN CLASS="GreyText">[$AdminLanguage[GraphicButtonsHelp]]</SPAN></SMALL>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[TemplateWidth]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="width" VALUE="$width" SIZE="10"> pixels,%
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[LinkColor]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="linkColor" VALUE="$linkColor" SIZE="10">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[TextColor]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="textColor" VALUE="$textColor" SIZE="10">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[SessionDuration]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="sessionDuration" VALUE="$sessionDuration" SIZE="10"> $AdminLanguage[seconds]
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[PostingsPerPage]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="postingsPerPage" VALUE="$postingsPerPage" SIZE="10"> 
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MaximumPagingLinks]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="MaxPagingLinks" VALUE="$MaxPagingLinks" SIZE="10"> 
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[ListingsPerPage]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="listingsPerPage" VALUE="$listingsPerPage" SIZE="10"> 
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[ShowBoardDescription]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="showBoardDescription">
				$showBoardDescriptionList
			</SELECT> 	
		</TD>
	</TR>		
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[ShowForumInfo]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="showForumInfo">
				$showForumInfoList
			</SELECT> 	<SMALL><SPAN CLASS="GreyText">[$AdminLanguage[ShowForumInfoHelp]]</SPAN></SMALL>
		</TD>
	</TR>		
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[ShowModerators]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="showModerators">
				$showModeratorsList
			</SELECT>
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[ShowIPs]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="showIPs">
				$showIPsList
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2" CLASS="TDPlain"><BR /><!-- SPAMGUARD -->
			<B><U>$AdminLanguage[SpamGuard]</U></B>
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[AntiOnRegistration]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="RegistrationSpamGuard">
				$antiOnRegistrationList
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[AntiOnLogin]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="LoginSpamGuard">
				$antiOnLoginList
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[SpamGuardFolder]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="SpamGuardFolder" VALUE="$SpamGuardFolder" SIZE="30">
		</TD>
	</TR>	

	<TR>
		<TD COLSPAN="2" CLASS="TDPlain"><BR /><!-- POSTINGS -->
			<B><U>$AdminLanguage[Postings]</U></B>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[AllowTopicNotifications]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="allowNotify">
				$allowNotifyList
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[DisplayMemberProfiles]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="displayMemberProfile">
				$displayMemberProfileList
			</SELECT> <SMALL><SPAN CLASS="GreyText">[$AdminLanguage[DisplayMemberProfilesHelp]]</SPAN></SMALL>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[ShowEditTime]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="showEditTime">
				$showEditTimeList
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[AllowableTags]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="allowableTags" VALUE="$allowableTags" STYLE="width:400">
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[BadTagAttributes]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="badAttributes" VALUE="$badAttributes" STYLE="width:400">
		</TD>
	</TR>	
	<TR>
		<TD COLSPAN="2" CLASS="TDPlain"><BR />
			<B><U>$AdminLanguage[Avatars]</U></B>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MaximumFileSize]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="avatarSize" VALUE="$avatarSize" SIZE="10"> bytes
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MaximumDisplayWidth]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="avatarWidth" VALUE="$avatarWidth" SIZE="10"> pixels
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MaximumDisplayHeight]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="avatarHeight" VALUE="$avatarHeight" SIZE="10"> pixels
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[FileTypes]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="avatarTypes" VALUE="$avatarTypes" SIZE="30"> <SPAN CLASS="GreyText"><SMALL>[$AdminLanguage[Usespace]]</SMALL></SPAN>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2" CLASS="TDPlain"><BR /><!-- ATTACHMENTS -->
			<B><U>$Language[Attachments]</U></B>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[AllowAttachments]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="allowAttachments">
				$allowAttachmentsList
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MaximumFileSize]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="attachmentSize" VALUE="$attachmentSize" SIZE="10"> bytes
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[DisallowAttachmentTypes]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="disallowAttachmentTypes" VALUE="$disallowAttachmentTypes" SIZE="30"> <SPAN CLASS="GreyText"><SMALL>[$AdminLanguage[Usespace]]</SMALL></SPAN>		
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2" CLASS="TDPlain"><BR /><!-- MESSAGING -->
			<B><U>$Language[Messaging]</U></B>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MaxMessagesPerMember]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="maxMemberMessages" VALUE="$maxMemberMessages" SIZE="10"> 
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[AllowMessageAttachments]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="allowMessageAttachments">
				$allowMessageAttachmentsList
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MaxDiskSpacePerMember]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="maxMessageAttachment" VALUE="$maxMessageAttachment" SIZE="10"> bytes
			<SMALL><SPAN CLASS="GreyText">[$AdminLanguage[MaximumDiskSpaceHelp]]</SPAN></SMALL>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2" CLASS="TDPlain"><BR /><!-- ADDRESS BOOK -->
			<B><U>$Language[AddressBook]</U></B>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[MaxContactEntries]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="MaxAddressBook" VALUE="$MaxAddressBook" SIZE="10"> 
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
		</TD>
		<TD CLASS="TDPlain"><BR />
			$submitButton
		</TD>
	</TR>	
	<TR>
		<TD COLSPAN="2"><BR/><BR/>
			<INPUT TYPE="SUBMIT" NAME="restore" VALUE="$AdminLanguage[RestoreDefaultValues]" CLASS="SubmitButtons">
		</TD>
	</TR>
	</TABLE>
	
	</FORM>
EOF;
	return $contents;
}//getFormHTML

//  Format refresh HTML.  Required to avoid viewing the last settings from cached pages.
//  Return: HTML
function reloadHTML(){
	global $AdminLanguage,$Language, $Document,$VARS,$Member;
	$contents .= <<<EOF
	<TABLE ALIGN="CENTER">
	<TR>
		<TD CLASS="TDPlain">
		<script language="javascript">
			setTimeout("forward()",1000);
			function forward(){
				location = '$Document[mainScript]?mode=admin&case=settings';
			}
		</script>

		<P ALIGN="CENTER">
		<BR />
		$Document[msg]  <BR /><BR /><BR />
				
		</P>
		</TD>
	</TR>
	</TABLE>
EOF;
	return $contents;
}//reloadHTML
?>
