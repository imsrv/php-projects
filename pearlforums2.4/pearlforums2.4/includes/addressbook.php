<?

////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    addressbook.php - Handles actions on addresss book,
//                  a new module in version 2.0.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

if(!$Member['memberId'])
	commonDisplayError($Language[AddressBook],$Language[Accessdenied]);

include_once("$GlobalSettings[templatesDirectory]/addressbook.php");
$action=$VARS['action']==''?"list":$VARS['action'];
$exe="{$action}Contact";

include_once("$GlobalSettings[templatesDirectory]/addressbook.php");

$Document['contents'] = commonTableHeader(true,0,200,"$Language[AddressBook]");

$exe();	
$Document['contents'] .=commonTableFooter(true,0,"&nbsp;");	

//  Delete message and attachment, if any
function deleteContact(){
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$sql="delete from {$Global_DBPrefix}AddressBook where memberId=$Member[memberId] and entryId=$entryId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	if(mysql_affected_rows()==0){
		commonDisplayError($Language[AddressBook],$Language[Accessdenied]);
	}
	else{
		$Document['msg'] = $Language['Recordremoved'];
	}
	listContact();
}//deleteContact

//  Update contact
function updateContact(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$notes=strip_tags($notes,$Document['AllowableTags']);
	$sql="update {$Global_DBPrefix}AddressBook set notes=\"$notes\" where memberId=$Member[memberId] and entryId=$entryId";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$Document[msg]=$Language[Recordupdated];
	listContact();
}//updateContact

//  Create new contact
function insertContact(){
	global $GlobalSettings,$Member,$Document,$VARS,$Language;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	$notes=strip_tags($notes,$Document['AllowableTags']);

	//just make sure
	$sql="select count(*) as totalCount from {$Global_DBPrefix}AddressBook where memberId=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	$totalCount=$dataSet[totalCount];

	if($totalCount>$GlobalSettings[MaxAddressBook]){
		commonDisplayError($Language[AddressBook],"$Language[MaxContactReached] ($GlobalSettings[MaxAddressBook])");
	}
	else{
		$sql="insert into {$Global_DBPrefix}AddressBook(memberId,contactId,notes) values ($Member[memberId],$contactId,\"$notes\")";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$Document[msg] = $Language[Contactentrycreated];
		listContact();
	}
}//insertContact

//  Edit contact
function editContact(){
	global $GlobalSettings,$Member,$Document,$VARS;	
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$sql="select contact.entryId,contact.contactId,contact.memberId,contact.notes,avatar.fileName as avatar,
		member.name from {$Global_DBPrefix}AddressBook as contact
		left join {$Global_DBPrefix}Members as member on(member.memberId=contact.contactId) 
		left join {$Global_DBPrefix}Avatars as avatar on (avatar.avatarId=member.avatarId)
		where contact.entryId=$entryId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);
		$Document[contents] .=getEditContactFormHTML($dataSet);
}//editContact

//  Get new contact form
function newContact(){
	global $GlobalSettings,$Member,$Document,$Language,$VARS;		
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$sql="select count(*) as totalCount from {$Global_DBPrefix}AddressBook where memberId=$Member[memberId]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);
	$dataSet = mysql_fetch_array($fetchedData);
	$totalCount=$dataSet[totalCount];

	if($totalCount>$GlobalSettings[MaxAddressBook]){
		commonDisplayError($Language[AddressBook],"$Language[MaxContactReached] ($GlobalSettings[MaxAddressBook])");
	}
	else{
		$sql="select member.name,avatar.fileName as avatar from {$Global_DBPrefix}Members as member 
			left join {$Global_DBPrefix}Avatars as avatar on (avatar.avatarId=member.avatarId)
			where member.memberId=$contactId";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);
		$dataSet = mysql_fetch_array($fetchedData);
		$Document[contents] .=getNewContactFormHTML($totalCount,$dataSet);
	}

}//newContact

//  List contacts
function listContact(){	
	global $GlobalSettings,$Language,$Member,$Document,$VARS;	
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);
	
	$Document['listingsPerPage']= 5;
	$page=$page==""?1:$page;
	$Document[fromPage]=($page -1)* $Document['listingsPerPage'];	
	if(!$totalCount){
		$sql="select count(*) as total from {$Global_DBPrefix}AddressBook where memberId=$Member[memberId]";
		$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
		$dataSet = mysql_fetch_array($fetchedData);
		$totalCount=$dataSet[total];
	}
	$Document['contents'] .= "<TABLE ALIGN=CENTER CELLPADDING=5><TR><TD ALIGN=CENTER><SPAN CLASS=ERROR>$Document[msg]</SPAN></TD></TR>";
	$sql="select distinct member.name,member.memberId,member.loginName,contact.entryId,contact.notes,avatar.fileName as avatar from 
		{$Global_DBPrefix}Members as member 
		left join {$Global_DBPrefix}AddressBook as contact on(member.memberId=contact.contactId) 
		left join {$Global_DBPrefix}Avatars as avatar on (avatar.avatarId=member.avatarId)
		where contact.memberId=$Member[memberId] order by member.name limit $Document[fromPage], $Document[listingsPerPage]";
	$fetchedData=mysql_query($sql) or commonLogError($sql,true);	
	while($dataSet = mysql_fetch_array($fetchedData))
	{
		$Document['contents'] .= getContactRowHTML($dataSet);
	}
	$counts=mysql_num_rows($fetchedData);

	if($counts==$Document[listingsPerPage]){//build paging
		$page=$page?$page:1;
		$pages = floor($totalCount/$Document['listingsPerPage']);
		if($totalCount%$Document['listingsPerPage']){$pages++;}

		if($pages>$Document['MaxPagingLinks']){
			$links=$Document['MaxPagingLinks'];
			$maxLoops=$page + $links;
			$maxLoops=$maxLoops>$pages?$pages:$maxLoops;	
		}
		else{
			$maxLoops = $pages;
		}
		$page++;
		for($p=$page;$p<=$maxLoops;$p++){
			$pageList .= " <A HREF=\"$Document[scriptName]?mode=addressbook&page=$p&case=$case\">$p</A> ";		
		}
	}
	if($totalCount==0){
		$Document['contents'] .= "<TR><TD CLASS=TDPlain ALIGN=CENTER><TABLE WIDTH=400 ALIGN=CENTER CELLPADDING=0 CELLSPACING=10 BORDER=0 STYLE='border-style:outset;border-color:white;border-width:1px'><TR><TD ALIGN=CENTER CLASS=TDPlain><BR><BR>$Language[Norecordsfound]<BR><BR><BR></TD></TR></TABLE></TD></TR>";
	}
	$Document['contents'] .= "</TABLE>";
	$Document['contents'] .= commonPreviousNext(430,$previous,$pageList);

}//listContact

?>