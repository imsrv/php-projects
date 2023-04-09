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
include "../config.inc.php";


$ad=AdminInfo($AdminID);


function ViewList($condition){
	GLOBAL $FULL_OUTPUT, $AdminID, $action;

	$res=mysql_query("SELECT * FROM admin_messages WHERE ToAdminID='$AdminID' $condition ORDER BY Date DESC");
	$BO.='<TABLE width="100%">
	<TR><TD width=20></TD><TD><span class="admintext">Subject</span></TD><TD><span class="admintext">From</span></TD><TD><span class="admintext">Date</span></TD><TD><span class="admintext">Options</span></TD></TR>
	<TR height="1" bgcolor="#cccccc"><TD colspan="5"></TD></TR>';
	
	while($r=mysql_fetch_array($res)){
		$Sender=AdminInfo($r[FromAdminID]);
			$n="";if($r[Received]==0){$n="new";}
		$BO.='<TR height="20"><TD><span class="admintext" style="color:red">'.$n.'</span></TD><TD><span class="admintext">'.$r[Subject].'</span></TD><TD><span class="admintext">'.$Sender[AdminRealName].' ['.$Sender[AdminUsername].']</span></TD><TD><span class="admintext">'.PrintableDate($r[Date]).'</span></TD><TD><span class="admintext">'.MakeLink("admin_messages?action=readmessage&MessageID=".$r[MessageID],"Read").' | '.MakeLink("admin_messages?view=$action&action=deletemessage&MessageID=".$r[MessageID],"Delete",1).'</span></TD></TR>';
	}
	$BO.='</TABLE><P>'.MakeLink("admin_messages.php?action=readnew", "View New").' | '.MakeLink("admin_messages.php?", "View All").' | '.MakeLink("admin_account.php?", "Send Message");
	
	$FULL_OUTPUT.=MakeBox("Listing ".mysql_num_rows($res)." messages", $BO);	
}

function DeleteMessage(){
	GLOBAL $FULL_OUTPUT, $AdminID, $MessageID, $view;
	
	mysql_query("DELETE FROM admin_messages WHERE ToAdminID='$AdminID' && MessageID='$MessageID'");
	$FULL_OUTPUT.=MakeBox("Message deleted", "The message was deleted");
		ViewList("");



}

function ReadMessage(){
	GLOBAL $FULL_OUTPUT, $MessageID, $view, $AdminID;

	$m=mysql_fetch_array(mysql_query("SELECT * FROM admin_messages WHERE MessageID='$MessageID' && ToAdminID='$AdminID'"));
	mysql_query("UPDATE admin_messages SET Received='1' WHERE MessageID='$MessageID' && ToAdminID='$AdminID'");
	
	$Sender=AdminInfo($m[FromAdminID]);
			
	$BO.='<B>'.$m[Subject].'</B><BR>'.nl2br($m[Body]).'<P>From: '.$Sender[AdminRealName].' ['.$Sender[AdminUsername].']<BR>Date: '.PrintableDate($m[Date]);
	
	$BO.='<P>'.MakeLink("admin_messages.php?action=readnew", "View New").' | '.MakeLink("admin_messages.php?", "View All").' | '.MakeLink("admin_messages.php?action=deletemessage&MessageID=$MessageID", "Delete",1).' | '.MakeLink("admin_account.php?ToAdminID=".$Sender[AdminID]."&Subject=".$m[Subject], "Reply");
	
	$FULL_OUTPUT.=MakeBox("Viewing message", $BO);
}

switch($action){

	case "readnew":
	ViewList("&& Received='0'");
	break;
	
	case "deletemessage":
	DeleteMessage();
	break;
	
	case "readmessage":
	ReadMessage();
	break;
	
	case "":
	ViewList("");
	break;

}


FinishOutput();

?>