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

GLOBAL $Username;
if(mysql_num_rows($res=mysql_query("SELECT * FROM admins WHERE Active='0' && AdminUsername='$Username' && IdentityKey='$IdentityKey'"))==1 && strlen($newp1)>=$MinPassLength && $newp1==$newp2){
	$ad=mysql_fetch_array($res);
	$AdminID=$ad[AdminID];
	$PW=md5($newp1);
	mysql_query("UPDATE admins SET AdminPassword='$PW', IdentityKey='', Active='1', LastChangedPassword='".time()."' WHERE AdminID='$AdminID'");
	
	echo '<HTML>
	<HEAD>
	<TITLE>Max-eMail V3 Elite First Login</TITLE>
	
	<style type="text/css">
		.inputfields{border-style:box;border-width:1;font-size:12;background-color:#FFFFF4}
	</style>
	
	</HEAD>
	
	<BODY>
	<CENTER>The process is complete...<P>
	<a href="index.php">Click here to login to Max-eMail Admin</a>
	</BODY>
	</HTML>';
	
}else{
	echo '<HTML>
	<HEAD>
	<TITLE>Max-eMail V3 Elite First Login</TITLE>
	
	<style type="text/css">
		.inputfields{border-style:box;border-width:1;font-size:12;background-color:#FFFFF4}
	</style>
	
	</HEAD>
	
	<BODY>
	<FORM action="index.php?NEWADMIN" method="POST">
	<TABLE width="100%" height="100%" cellpadding="0" cellspacing="0">
	<TR width="100%">
		<TD height="100%" valign="middle" align="center">
		
		
		<TABLE width="400" height="200" cellpadding="3" cellspacing="1">
			<TR width="100%" height="20">
				<TD bgcolor="#B0C0D0" colspan="2">
				<FONT face="verdana,arial" size="2"><B><CENTER>:: Please enter details below ::</CENTER></B></FONT>	
				</TD>
			</TR>
			
					<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">Identity Key:			
				</TD><TD bgcolor="#efefef">
					<input type=text name=IdentityKey class="inputfields">
			
				</TD>
					</TR>
			
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">Username:			
				</TD><TD bgcolor="#efefef">
					<input type=text name=Username class="inputfields">
			
				</TD>
					</TR>
					
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">Desired Password:			
				</TD><TD bgcolor="#efefef">
					<input type=password name=newp1 class="inputfields">
							</TD>
							
			</TR>
			
							<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">Desired Password Re-Type:			
				</TD><TD bgcolor="#efefef">
					<input type=password name=newp2 class="inputfields">
							</TD>
							
			</TR>
				
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" colspan="2" align="center">
					<input type=submit class="inputfields" value="Continue">
							</TD>
							
			</TR>
			
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" colspan="2">
					<FONT face="verdana,arial" size="1"><B>Notes</B>:<BR>
					- Password must be longer than '.$MinPassLength.' characters.<BR>
					- After clicking continue you will be prompted to login with your Username and password you just selected!<BR>
			
			</font>
							</TD>
							
			</TR>
						
			
		</TABLE>
		
		
		</TD>
	</TR>
	</TABLE>
	</FORM>
	</BODY>
	</HTML>';







}


?>