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
include "checkpop.php";

$list=mysql_fetch_array(mysql_query("SELECT * FROM lists WHERE ListID='$ListID'"));
if($ad=mysql_fetch_array(mysql_query("SELECT * FROM bounce_addresses WHERE BounceAddressID='".$list[BounceAddressID]."'"))){
	//create the mail retrieval class object
	$pop3 = new POP3;
	$pop3->server = $ad[Mail_Server];
	$pop3->user   = $ad[Username];
	$pop3->passwd = $ad[Password];
	$pop3->debug = false;
if($pop3->pop3_connect()) {
    $pop3->pop3_login();
    $pop3->pop3_stat();
    if($pop3->pop3_list())
        while($line = $pop3->nextAnswer()){
            list($id)=explode(" ",$line);
            $toget[$id]=1;
        }

    if($toget){foreach($toget as $id=>$sd){$xe++;
        if($pop3->pop3_retr($id))
        while($line = $pop3->nextAnswer()){
            $emails[$id].=$line;
        }
    }}


}

}


for($i=1;$i<=$xe;$i++){
$pop3->pop3_dele($i);
}


if($emails){
foreach($emails as $email){
	echo $email;
	list(,$to)=explode("\nFrom: ", $email);
	list($to)=explode(">", $to);
	list(,$to)=explode("<", $to);
	mysql_query("INSERT INTO bounced_emails SET Email='$to', Time='".time()."', BouncedAddress='".$ad[BouncedAddressID]."'");
}}

echo '<script language="javascript">
  window.close()
</script>';
 






?>
