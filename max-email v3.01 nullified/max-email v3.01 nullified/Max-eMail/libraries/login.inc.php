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
            
if($AdminAuthType=="htaccess"){		
	Header("WWW-authenticate: basic realm=\"You need to login!!\"");
    Header("HTTP/1.0 401 Unauthorized");
}else{
	echo '<HTML>
	<HEAD>
	<TITLE>Max-eMail V3 Elite Admin Login</TITLE>
	
	<style type="text/css">
		.inputfields{border-style:box;border-width:1;font-size:12;background-color:#FFFFF4}
	</style>
	
	</HEAD>
	
	<BODY>
	<FORM action="index.php?LOGINNOW" method="POST">
	<TABLE width="100%" height="100%" cellpadding="0" cellspacing="0">
	<TR width="100%">
		<TD height="100%" valign="middle" align="center">
		
		
		<TABLE width="400" height="200" cellpadding="3" cellspacing="1">
			<TR width="100%" height="20">
				<TD bgcolor="#B0C0D0" colspan="2">
				<FONT face="verdana,arial" size="2"><B><CENTER>:: Max-eMail Admin Login ::</CENTER></B></FONT>	
				</TD>
			</TR>
			
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">Username:			
				</TD><TD bgcolor="#efefef">
					<input type=text name=username class="inputfields">
			
				</TD>
					</TR>
					
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" align="right">
					<FONT face="verdana,arial" size="1">Password:			
				</TD><TD bgcolor="#efefef">
					<input type=password name=password class="inputfields">
							</TD>
							
			</TR>
				
				<TR width="100%" height="40">
				<TD bgcolor="#efefef" colspan="2" align="center">
					<input type=submit class="inputfields" value="Login to Max-eMail..">
							</TD>
							
			</TR>
						
				<TR width="100%" height="*">
				<TD bgcolor="#efefef" colspan="2" align="center">
						<font size=1 face="verdana,arial">
						ONLY AUTHORISED PERSONS MAY LOGIN!
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
