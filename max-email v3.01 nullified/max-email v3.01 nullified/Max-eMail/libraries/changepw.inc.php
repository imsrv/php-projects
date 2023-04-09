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
	echo '<HTML>
	<HEAD>
	<TITLE>Max-eMail V3 Elite Admin Login</TITLE>
	
	<style type="text/css">
		.inputfields{border-style:box;border-width:1;font-size:12;background-color:#FFFFF4}
	</style>
	
	</HEAD>
	
	<BODY>
	<FORM action="index.php?CHANGEPW" method="POST">
	<TABLE width="100%" height="100%" cellpadding="0" cellspacing="0">
	<TR width="100%">
		<TD height="100%" valign="middle" align="center">
		
		
		<TABLE width="400" height="200" cellpadding="3" cellspacing="1">
			<TR width="100%" height="20">
				<TD bgcolor="#B0C0D0" colspan="2">
				<FONT face="verdana,arial" size="2"><B><CENTER>:: Your password has expired ::</CENTER></B></FONT>	
				</TD>
			</TR>
			
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">Old Password:			
				</TD><TD bgcolor="#efefef">
					<input type=password name=oldpword class="inputfields">
			
				</TD>
					</TR>
					
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">New Password:			
				</TD><TD bgcolor="#efefef">
					<input type=password name=newp1 class="inputfields">
							</TD>
							
			</TR>
			
							<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">New Password Re-Type:			
				</TD><TD bgcolor="#efefef">
					<input type=password name=newp2 class="inputfields">
							</TD>
							
			</TR>
				
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" colspan="2" align="center">
					<input type=submit class="inputfields" value="Change password">
							</TD>
							
			</TR>
			
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" colspan="2">
					<FONT face="verdana,arial" size="1"><B>Rules</B>:<BR>
					- Password must be longer than '.$MinPassLength.' characters.<BR>
					- New password must be different than old password.</font>
							</TD>
							
			</TR>
						
			
		</TABLE>
		
		
		</TD>
	</TR>
	</TABLE>
	</FORM>
	</BODY>
	</HTML>';



?>
