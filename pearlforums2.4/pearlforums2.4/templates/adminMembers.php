<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminMembers.php - HTML templates for outputs of 
//                  member screens in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format form for editing or creating new record
//  Parameters: Title(string), ActionButtons(string), Message(string)
//  Return: HTML
function getMemberFormHTML($title,$buttons,$msg){
	global $GlobalSettings,$Language, $Document,$VARS,$AdminLanguage;
	extract($VARS,EXTR_OVERWRITE);
	if($fileName){
		$photo="<IMG SRC=$GlobalSettings[avatarsPath]/$fileName>";
	}
	$lockButton=commonGetIconButton("lock$locked",$accessAlt,"?mode=admin&case=members&action=access&memberId=$memberId&locked=$accessStatus","");	
	$contents = "<BR />";
	$contents .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$contents .= <<<EOF
<TR>
	<TD CLASS="TitleTR" ALIGN="CENTER">$title</TD>
</TR>
<TR>
	<TD CLASS="TDStyle">		
	<FORM ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">	
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="members">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="update">
	<INPUT TYPE="HIDDEN" NAME="memberId" VALUE="$memberId">
	<TABLE ALIGN="CENTER" CELLPADDING="5" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD CLASS="TDStyle" COLSPAN="2" ALIGN="CENTER">
			<SPAN CLASS="Error">$msg</SPAN> &nbsp;
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[LoginName]:
		</TD>
		<TD CLASS="TDStyle">
			$loginName $lockButton

		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Position]:
		</TD>
		<TD CLASS="TDStyle">
			<SELECT NAME="accessLevelId">
				$positionsListing
			</SELECT>
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Group]:
		</TD>
		<TD CLASS="TDStyle">
			<SELECT NAME="groupId">
				$groupsListing
			</SELECT>
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Name]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="TEXT" NAME="name" SIZE="25" VALUE="$name" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Email]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="TEXT" NAME="email" SIZE="25" VALUE="$email" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Hide] $Language[Email]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="CHECKBOX" NAME="hideEmail" VALUE="1" $hideEmail> $Language[Yes]
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[BioQuote]:
		</TD>
		<TD CLASS="TDStyle">
			<TEXTAREA NAME="bio" COLS="50" ROWS="4" STYLE="width:400">$MemberDetails[bio]</TEXTAREA> 
		</TD>		
	</TR>		
	<TR>
		<TD CLASS="TDStyle">
			$Language[Notify] $Language[Announcements]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="CHECKBOX" NAME="notifyAnnouncements" VALUE="1" $notifyAnnouncements> $Language[Yes]
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[URL]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="TEXT" NAME="url" SIZE="25" VALUE="$url" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Avatar]:
		</TD>
		<TD CLASS="TDStyle">
			<SELECT NAME="avatarId">
				$avatarsListing
			</SELECT>
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$AdminLanguage[IPAddress]:
		</TD>
		<TD CLASS="TDStyle">
			$ip
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[TotalPosts]:
		</TD>
		<TD CLASS="TDStyle">
			$totalPosts
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[ChangePassword]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="PASSWORD" NAME="passwd" SIZE="25" VALUE="$passwd" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[ConfirmPassword]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="PASSWORD" NAME="confirmPassword" SIZE="25" VALUE="$confirmPassword" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">			
		</TD>
		<TD CLASS="TDStyle">
			$buttons
		</TD>		
	</TR>	
	</TABLE>
	</FORM>
	</TD>
</TR>	
EOF;
	$contents .= commonTableFormatHTML("footer","","");
	$contents .= "<P ALIGN=CENTER>	$photo </P>";

	return $contents;
}//getMemberFormHTML

//  Format each row on listing
//  Parameter: MemberDetails(Array)
//  Return: HTML
function getMemberRowHTML($member){
	global $Language,$Document,$AdminLanguage;
	$confirmation=commonDeleteConfirmation("$AdminLanguage[DeleteMemberWarning]");
	$deleteButton=commonGetIconButton("delete",$Language['Delete'],"?mode=admin&case=members&action=delete&memberId=$member[memberId]",$confirmation);
	$editButton=commonGetIconButton("edit",$Language['Edit'],"?mode=admin&case=members&action=edit&memberId=$member[memberId]","");
	$lockButton=commonGetIconButton("lock$member[locked]",$member['accessAlt'],"?mode=admin&case=members&action=access&memberId=$member[memberId]&locked=$member[accessStatus]","");
	
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle"><NOBR>$member[name]</NOBR></TD>
		<TD CLASS="TDStyle">$member[loginName]</TD>
		<TD CLASS="TDStyle">$member[position]</TD>				
		<TD CLASS="TDStyle">$member[groupName]&nbsp;</TD>		
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$deleteButton
		</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$editButton
		</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$lockButton
		</TD>
EOF;
	return $contents;
}//getMemberRowHTML

//  Column labels on listings
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$Language[Name]</TD>
		<TD CLASS="TitleTR">$Language[Login]</TD>
		<TD CLASS="TitleTR">$Language[Position]</TD>
		<TD CLASS="TitleTR">$Language[Group]</TD>						
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Edit]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Lock]/$AdminLanguage[Unlock]</TD>		
	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Top Create, Alpha links and Quick Search box
//  Return: HTML
function getNewLinkHTML(){
	GLOBAL $Language,$Document,$VARS;
	$chars=array("#","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","R","S","T","U","V","W","X","Y","Z");	
	foreach($chars as $alpha){
		if($VARS[alpha]==$alpha){
			$l="<SPAN CLASS=GreyText>&laquo;</SPAN>";
			$r="<SPAN CLASS=GreyText>&raquo;</SPAN>";
		}
		else{$l=$r='';}
		$links .= "$r<A HREF=\"$Document[mainScript]?mode=admin&case=members&action=list&listType=alpha&alpha=$alpha\">$alpha</A>$l &nbsp;";
	}
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="members">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="list">	
	<INPUT TYPE="HIDDEN" NAME="listType" VALUE="search">	
	<TR>
		<TD CLASS="TDStyle" VALIGN="BOTTOM">
			$links
		</TD>
		<TD CLASS="TDStyle" ALIGN="RIGHT">
			<INPUT TYPE="TEXT" SIZE="10" NAME="searchText" VALUE="$VARS[searchText]"><INPUT TYPE="SUBMIT" VALUE="$Language[Search]" CLASS="GoButton">
		</TD>
	</TR>	
	</FORM>
	</TABLE>
EOF;
	return $contents;
}//getNewLinkHTML


?>