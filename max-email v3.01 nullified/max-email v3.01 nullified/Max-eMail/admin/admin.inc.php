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
//get the current time!
function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
    } 

$time_start = getmicrotime();
//end get current time!

include "../config.inc.php";

GLOBAL $AdminTemplate;
$t=$AdminTemplate;

//now the page title!
GLOBAL $REQUEST_URI;
list(,$thispage)=explode("/admin/",$REQUEST_URI);
list($thispage,)=explode(".php", $thispage);

if($ADMIN_LIST_SECTIONS[$thispage]){
	$thispage=' :: '.$ADMIN_LIST_SECTIONS[$thispage];
}elseif($ADMIN_ADV_SECTIONS[$thispage]){
	$thispage=' :: '.$ADMIN_ADV_SECTIONS[$thispage];
}elseif($thispage=="admin_account"){
	$thispage=" :: My Account";
}elseif($thispage=="index"){
	$thispage=" :: Admin Panel Home";
}else{
	$thispage="";
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?echo str_replace("::","",$thispage)." :: ".$t[PageTitle];?></TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">

<style type="text/css">
   .sidebarlinks{<?echo $t[sidebarlinks];?>}
   .sidebarlinks:hover{<?echo $t[sidebarlinkshover];?>};
   .formtext{<?echo $t[formtext];?>}
   .smalltext{<?echo $t[smalltext];?>}
   .admintext{<?echo $t[admintext];?>}
   .adminlink{<?echo $t[adminlink];?>}
   .adminlink:hover{<?echo $t[adminlinkhover];?>}
   .inputfields{<?echo $t[inputfields];?>}
</style>

</HEAD>

<BODY>

<TABLE width="100%" height="100%" cellpadding="0" cellspacing="0">

<TR>
<TD><?
 
 if($t[LogoURL]){
 echo '<img src="'.$t[LogoURL].'"';
}

?><BR><BR></TD>
<TD valign="middle" align="center">
  <BR>
</TD>
</TR>

<TR height="7">
<TD colspan="2"<?
 
 if($t[TopBarImageURL]){
 echo 'background="'.$t[TopBarImageURL].'"';
}

?>></TD>
</TR>

<TR height="2">
<TD colspan="2" bgcolor="<?echo $t[ColorTwo];?>"></TD>
</TR>

<TR height="20">
<TD bgcolor="<?echo $t[ColorOne];?>"><span class="sidebarlinks"><B>&nbsp;<?echo $t[PageTitle].$thispage;?></B></TD>
<td bgcolor="<?echo $t[ColorOne];?>" align="right"><span class="sidebarlinks"><B></B><a href="index.php" class="sidebarlinks" style="font-weight:bold">Admin Home</a> :: <a href="admin_account.php" class="sidebarlinks" style="font-weight: bold">My Account</a> :: <a href="index.php?LOGOUT" class="sidebarlinks" style="font-weight:bold">Logout</a>&nbsp;&nbsp;</B></span></td>
</TR>

<TR>
<TD colspan="2" height="100%">

    <TABLE width="100%" height="100%">
          <TR>
            <TD valign="top" width="146" bgcolor="<?echo $t[ColorTwo];?>">
                       <img src="" width="146" height="0">
					   <TABLE width="100%" cellpadding="4" cellspacing="0">
                          <TR bgcolor="<?echo $t[ColorOne];?>">
                            <B><span class="sidebarlinks"> :: Account Info </span></B></TD>
                          </TR>
                          <TR>
                             <TD>
                             
                             <span class="sidebarlinks">
							 <?
								GLOBAL $AdminID;						 
							 	$AdminInfo=AdminInfo($AdminID);
								$AdminGroupInfo=AdminGroupInfo($AdminID);
							 ?>
                             <B>Username:</B>    <BR>
                             <?echo $AdminInfo[AdminUsername];?> <BR>
                             <B>Admin Group:</B>          <BR>
                             <?echo $AdminGroupInfo[AdminGroupName];?>
                             </span><BR>
								 <BR>
                         
                             </TD>
                          </TR>
                       </TABLE>
                       
                       <TABLE width="100%" cellpadding="2" cellspacing="0">
                          <TR bgcolor="<?echo $t[ColorOne];?>">
                             <TD><span class="sidebarlinks"><B>:: List Functions</B></span></TD>
                          </TR>
							<?
								
																							
								foreach($ADMIN_LIST_SECTIONS as $SYSKEY=>$NAME){
									if(mysql_num_rows(mysql_query("SELECT * FROM admin_group_privelages WHERE AdminGroupID='".$AdminGroupInfo[AdminGroupID]."' && Action LIKE '%|$SYSKEY|%'")) || $AdminGroupInfo[SuperUser]==1){
										echo '<TR><TD><font face="verdana,arial" size="2"><A href="'.$SYSKEY.'.php" class="sidebarlinks">~ '.$NAME.'</a></FONT></TD></TR>';
									}
								}
							?>
                            
			     <TR><TD>&nbsp;</TD></TR>
                       </TABLE>
                       
                       <TABLE width="100%" cellpadding="2" cellspacing="0">
                          <TR bgcolor="<?echo $t[ColorOne];?>">
                             <TD><span class="sidebarlinks"><B>:: Advanced</B></span></TD>
                          </TR>
						  							<?
								
																							
								foreach($ADMIN_ADV_SECTIONS as $SYSKEY=>$NAME){
									if($AdminGroupInfo[SuperUser]==1){
										echo '<TR><TD><font face="verdana,arial" size="2"><A href="'.$SYSKEY.'.php" class="sidebarlinks">~ '.$NAME.'</a></FONT></TD></TR>';
									}
								}
							?>
                            
				  <TR><TD>&nbsp;</TD></TR>
                       </TABLE>


                       
            </TD>
           
            <TD valign="top">
                <CENTER>
                 <?
			echo $FULL_OUTPUT;
			?>
                </CENTER>
            </TD>
          </TR>
    </TABLE>
</TD>
</TR>


</TABLE>
<?
$time_end = getmicrotime();
$time = round($time_end - $time_start,2);
echo '<center><span class="smalltext">Copyright &copy; 2002 SiteOptions<BR>'.str_replace("-","",$time)." seconds taken to execute this page!".'</span></center>';

?>

</BODY>
</HTML>
